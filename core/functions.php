<?php

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use SendinBlue\Client\Model\CreateContact;
use SendinBlue\Client\Model\SendSmtpEmail;

require_once "vendor/autoload.php";
require_once "core/SQL.php";
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, 'fr_FR.utf8','fra');
$captcha_public_v3 = getenv('CAPTCHA_PUBLIC_V3');
$captcha_private_v3 = getenv('CAPTCHA_PRIVATE_V3');
if (getenv("ENV") === "test") {
    ini_set("display_errors", 1);
}
$FILE = $_SERVER['PHP_SELF'];

/**
 * @param $trip_date
 * @param $trip_time
 * @param $pick_address
 * @param $drop_address
 * @param $pick_place_id
 * @param $drop_place_id
 * @param $retour
 * @param $nom
 * @param $tel
 * @param $email
 * @param $price
 * @param $distance
 * @param $duration
 * @return bool
 * @throws JsonException
 * @throws TelegramException
 */
function saveBooking($trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $retour, $nom, $tel, $email, $price, $distance, $duration): bool
{
    global $db;

    $stmt = $db->prepare("INSERT INTO bookings (trip_date, trip_time, pick_address, drop_address, pick_place_id, drop_place_id, price, retour, nom, tel, email, status) 
    VALUES (:trip_date, :trip_time, :pick_address, :drop_address, :pick_place_id, :drop_place_id, :price, :retour, :nom, :tel, :email, 'pending')");

    $stmt->bindValue(':trip_date', $trip_date);
    $stmt->bindValue(':trip_time', $trip_time);
    $stmt->bindValue(':pick_address', $pick_address);
    $stmt->bindValue(':drop_address', $drop_address);
    $stmt->bindValue(':pick_place_id', $pick_place_id);
    $stmt->bindValue(':drop_place_id', $drop_place_id);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':retour', $retour);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':tel', $tel);
    $stmt->bindValue(':email', $email);

    if ($stmt->execute()) {
        $last_id = $db->querySingle('SELECT id FROM bookings ORDER BY id DESC LIMIT 1');
        $bookingToken = urlencode(base64_encode(json_encode(array($last_id, $email), JSON_THROW_ON_ERROR)));
        createSendinblueContact($nom, $email, $tel);
        sendTelegramBooking($nom, $tel, $trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $price, $retour, $bookingToken, $distance, $duration);
        return true;
    }
    return false;
}

/**
 * @param $email
 * @param $nom
 * @param $trip_date
 * @param $trip_time
 * @param $pick_address
 * @param $drop_addresss
 * @param $price
 * @param $retour
 * @param $bookingToken
 * @return bool
 */
function sendConfirmationEmail($email, $nom, $trip_date, $trip_time, $pick_address, $drop_addresss, $price, $retour, $bookingToken): bool
{
    if ($retour) {
        $retourMessage = "(Trajet aller-retour)";
    }
    else {
        $retourMessage = "(Trajet aller simple)";
    }

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', getenv("SENDINBLUE_API_KEY"));

    $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
        new GuzzleHttp\Client(),
        $config
    );
    $sendSmtpEmail = new SendSmtpEmail();
    $sendSmtpEmail['to'] = array(array('email' => $email , 'name' => $nom));
    $sendSmtpEmail['templateId'] = 14;
    $sendSmtpEmail['params'] = array(
        'date'=> $trip_date,
        'heure'=> $trip_time,
        'depart' => $pick_address,
        'arrivee' => $drop_addresss,
        'tarif' => $price,
        'retour' => $retourMessage,
        'cancel' => $bookingToken);

    try {
        $apiInstance->sendTransacEmail($sendSmtpEmail);
        return true;
    } catch (Exception $e) {
        mail(getenv("ADMIN_EMAIL"), "Erreur lors de l'envoi de l'email", $e->getMessage());
        return false;
    }
}

/**
 * @param $name
 * @param $email
 * @param $tel
 * @return bool
 */
function createSendinblueContact($name, $email, $tel): bool
{
    // Converts the attributes to a format that SendinBlue can understand
    $name = explode(" ", $name);
    $firstname = $name[0];
    $lastname = $name[1] ?? null;
    $tel = "33".substr($tel, 1, strlen($tel));

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', getenv("SENDINBLUE_API_KEY"));

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(
        new GuzzleHttp\Client(),
        $config
    );
    $createContact = new CreateContact(); // Values to create a contact
    $createContact['email'] = $email;
    $createContact["updateEnabled"] = true;
    $createContact['listIds'] = [6];
    $createContact['attributes'] = array('NOM' => $firstname, "PRENOM" => $lastname, 'SMS' => $tel);

    try {
        $apiInstance->createContact($createContact);
        return true;
    } catch (Exception $e) {
        mail(getenv("ADMIN_EMAIL"), "Erreur lors de l'ajout du contact SendinBlue", $e->getMessage());
        return false;
    }
}

/**
 * @param $bookingToken
 * @return bool
 * @throws JsonException
 * @throws TelegramException
 */
function cancelBooking($bookingToken): bool
{
    global $db;
    $datas = getBooking($bookingToken);

    if ($datas['status'] !== 'canceled') {
        $stmt = $db->prepare("UPDATE bookings SET status = :status WHERE id = :id AND email = :email");
        $stmt->bindValue(':status', "canceled");
        $stmt->bindValue(':id', $bookingToken[0]);
        $stmt->bindValue(':email', $bookingToken[1]);
        $stmt->execute();
        $message = "*-ANNULATION-*\n\nLa réservation de *" . $datas['nom'] . " " . $datas['prenom'] . " (" . $datas['tel'] . ")* a été ANNULÉE par le client\n";
        sendTelegramMessage($message);
    }
    return true;
}

/**
 * @param $bookingToken
 * @return bool
 * @throws JsonException
 * @throws TelegramException
 */
function acceptBooking($bookingToken): bool
{
    global $db;
    $datas = getBooking($bookingToken);

    if ($datas['status'] === 'pending') {
        $stmt = $db->prepare("UPDATE bookings SET status = :status WHERE id = :id AND email = :email");
        $stmt->bindValue(':status', "accepted");
        $stmt->bindValue(':id', $bookingToken[0]);
        $stmt->bindValue(':email', $bookingToken[1]);
        $stmt->execute();
        sendConfirmationEmail($datas['email'], $datas['nom'], $datas['trip_date'], $datas['trip_time'], $datas['pick_address'], $datas['drop_address'], $datas['price'], $datas['retour'], $bookingToken[0]);
        $message = "*-CONFIRMATION-*\n\nLa réservation de *" . $datas['nom'] . " (" . $datas['tel'] . ")* a été acceptée\n";
        sendTelegramMessage($message);
        return true;
    }
    return false;
}

/**
 * @throws JsonException
 */
function getBooking($bookingToken) {
    global $db;
    $bookingToken = json_decode(base64_decode(urldecode($bookingToken)), true, 512, JSON_THROW_ON_ERROR);
    $sel = $db->prepare("SELECT * FROM bookings WHERE id = :id AND email = :email");
    $sel->bindValue(':id', $bookingToken[0]);
    $sel->bindValue(':email', $bookingToken[1]);
    return $sel->execute()->fetchArray(SQLITE3_ASSOC);
}

/**
 * @return false|Telegram
 */
function initTelegram() {
    $bot_api_key  = getenv("TELEGRAM_BOT_API_KEY");
    $bot_username = 'ToprakTransportBot';

    try {
        $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
        $telegram->handleGetUpdates();
    } catch (Longman\TelegramBot\Exception\TelegramException $e) {
        mail(getenv("ADMIN_EMAIL"), "Erreur lors de l'initialisation Telegram", $e->getMessage());
        return false;
    }

    return $telegram;
}

/**
 * @param $message
 * @return void
 * @throws TelegramException
 */
function sendTelegramMessage($message) {
    initTelegram();
    Request::sendMessage([
        'chat_id' => getenv("TELEGRAM_CHAT_ID"),
        'text'    => $message,
        'parse_mode' => "MARKDOWN"
    ]);
}

/**
 * @param $name
 * @param $tel
 * @param $trip_date
 * @param $trip_time
 * @param $pick_address
 * @param $drop_address
 * @param $pick_place_id
 * @param $drop_place_id
 * @param $price
 * @param $retour
 * @param $bookingToken
 * @param $distance
 * @param $duration
 * @return void
 * @throws TelegramException
 */
function sendTelegramBooking($name, $tel, $trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $price, $retour, $bookingToken, $distance, $duration): void
{
    if ($retour === "true") {
        $retourMessage = "(Trajet *aller-retour*)";
    }
    else {
        $retourMessage = "(Trajet aller simple)";
    }

    $duration = str_replace([" hour", " mins"], ["h", "min"], $duration);
    $telegram = initTelegram();
    if ($telegram) {
         Request::sendMessage([
            'chat_id' => getenv("TELEGRAM_CHAT_ID"),
            'text'    => "*---Nouvelle course---*\n\n"
                . "*$name ($tel)*\n"
                . "*Date:* $trip_date à $trip_time\n\n"
                . "*Départ:* $pick_address\n"
                . "*Arrivée:* $drop_address\n\n"
                . "*Itinéraire:* [Google Maps](https://www.google.com/maps/dir/?api=1&origin=$pick_address&destination=$drop_address&destination_place_id=$drop_place_id&origin_place_id=$pick_place_id)\n"
                . "*Distance:* $distance ($duration)\n\n"
                . "*Tarif:* $price € $retourMessage\n\n"
                . "✔ [Accepter](https://toprak-transport.fr/booking.php?accept=$bookingToken) \n\n",
            'parse_mode' => "MARKDOWN",
            'disable_web_page_preview' => true
        ]);
    }
}

/**
 * @return array|false
 */
function getActualites()
{
    global $db;
    $sel = $db->prepare("SELECT * FROM actualites WHERE status = 1 ORDER BY created_at DESC");
    $results = $sel->execute();
    $datas = [];
    while ($res = $results->fetchArray(SQLITE3_ASSOC))
    {
        array_push($datas, $res);
    }
    return $datas;
}

/**
 * @param $id
 * @return array|false
 */
function getActualite($id) {
    global $db;
    $sel = $db->prepare("SELECT * FROM actualites WHERE id = :id");
    $sel->bindValue(':id', $id);
    return $sel->execute()->fetchArray(SQLITE3_ASSOC);
}

/**
 * @param $url
 * @return string
 */
function sluggify($url): string
{
    # Prep string with some basic normalization
    # Remove quotes (can't, etc.)
    $url = str_replace(array('\'', 'é', 'è', 'ê', 'à', 'ç', 'ô', 'î'), array('', 'e', 'e', 'e', 'a', 'c', 'o', 'i'), $url);
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);

    $url = html_entity_decode($url);
    # Replace non-alpha numeric with hyphens
    $match = '/[^a-z0-9]+/';
    $replace = '-';
    $url = preg_replace($match, $replace, $url);

    $url = trim($url, '-');

    return $url;
}

function createActualite($title, $actu_html, $image) {
    global $db;
    $ins = $db->prepare("INSERT INTO actualites (title, actu_html, actu, image) VALUES (:title, :actu_html, :actu, :image)");
    $ins->bindValue(':title', $title);
    $ins->bindValue(':actu_html', $actu_html);
    $ins->bindValue(':actu', strip_tags($actu_html));
    $ins->bindValue(':image', $image);
    return $ins->execute();
}