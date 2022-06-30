<?php

use Longman\TelegramBot\Request;

require_once "vendor/autoload.php";
require_once "core/SQL.php";
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, 'fr_FR.utf8','fra');
$captcha_public_v3 = getenv('CAPTCHA_PUBLIC_V3');
$captcha_private_v3 = getenv('CAPTCHA_PRIVATE_V3');
if (getenv("ENV") == "test") ini_set("display_errors", 1);
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
 * @return bool
 * @throws JsonException
 */
function saveBooking($trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $retour, $nom, $tel, $email, $price, $distance, $duration) {
    global $db;

    $stmt = $db->prepare("INSERT INTO bookings (trip_date, trip_time, pick_address, drop_address, pick_place_id, drop_place_id, price, retour, nom, tel, email) 
    VALUES (:trip_date, :trip_time, :pick_address, :drop_address, :pick_place_id, :drop_place_id, :price, :retour, :nom, :tel, :email)");

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
function sendConfirmationEmail($email, $nom, $trip_date, $trip_time, $pick_address, $drop_addresss, $price, $retour, $bookingToken) {
    if ($retour) $retourMessage = "(Trajet aller-retour)";
    else $retourMessage = "(Trajet aller simple)";

    $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', getenv("SENDINBLUE_API_KEY"));

    $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
        new GuzzleHttp\Client(),
        $config
    );
    $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
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
        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
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
function createSendinblueContact($name, $email, $tel) {
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
    $createContact = new \SendinBlue\Client\Model\CreateContact(); // Values to create a contact
    $createContact['email'] = $email;
    $createContact["updateEnabled"] = true;
    $createContact['listIds'] = [6];
    $createContact['attributes'] = array('NOM' => $firstname, "PRENOM" => $lastname, 'SMS' => $tel);

    try {
        $result = $apiInstance->createContact($createContact);
        return true;
    } catch (Exception $e) {
        mail(getenv("ADMIN_EMAIL"), "Erreur lors de l'ajout du contact SendinBlue", $e->getMessage());
        return false;
    }
}

/**
 * @param $cancel
 * @return bool
 */
function cancelBooking($bookingToken) {
    global $db;
    $bookingToken = json_decode(base64_decode(urldecode($bookingToken)), JSON_THROW_ON_ERROR);
    $sel = $db->prepare("SELECT * FROM bookings WHERE id = :id AND email = :email");
    $sel->bindValue(':id', $bookingToken[0]);
    $sel->bindValue(':email', $bookingToken[1]);
    $datas = $sel->execute();
    $datas = $datas->fetchArray(SQLITE3_ASSOC);

    if ($datas['status'] == 'pending') {
        $stmt = $db->prepare("UPDATE bookings SET status = :status WHERE id = :id AND email = :email");
        $stmt->bindValue(':status', "canceled");
        $stmt->bindValue(':id', $bookingToken[0]);
        $stmt->bindValue(':email', $bookingToken[1]);
        $stmt->execute();
        $message = "*-ANNULATION-*\n\nLa réservation de *" . $datas['nom'] . " (" . $datas['tel'] . ")* a été ANNULÉE\n";
        sendTelegramMessage($message);
    }
    return true;
}

/**
 * @param $accept
 * @return bool
 */
function acceptBooking($bookingToken) {
    global $db;
    $bookingToken = json_decode(base64_decode(urldecode($bookingToken)), JSON_THROW_ON_ERROR);
    $stmt = $db->prepare("UPDATE bookings SET status = :status WHERE id = :id AND email = :email");
    $stmt->bindValue(':status', "accepted");
    $stmt->bindValue(':id', $bookingToken[0]);
    $stmt->bindValue(':email', $bookingToken[1]);
    if ($stmt->execute()) {
        $sel = $db->prepare("SELECT * FROM bookings WHERE id = :id AND email = :email");
        $sel->bindValue(':id', $bookingToken[0]);
        $sel->bindValue(':email', $bookingToken[1]);
        $datas = $sel->execute();
        $datas = $datas->fetchArray(SQLITE3_ASSOC);

        if ($datas['status'] == 'pending') {
            sendConfirmationEmail($datas['email'], $datas['nom'], $datas['trip_date'], $datas['trip_time'], $datas['pick_address'], $datas['drop_address'], $datas['price'], $datas['retour'], $bookingToken);
            $message = "*-CONFIRMATION-*\n\nLa réservation de *" . $datas['nom'] . " (" . $datas['tel'] . ")* a été acceptée\n";
            sendTelegramMessage($message);
        }
        return true;
    }
    return false;
}

/**
 * @return false|\Longman\TelegramBot\Telegram
 */
function initTelegram() {
    $bot_api_key  = getenv("TELEGRAM_BOT_API_KEY");
    $bot_username = 'ToprakTransportBot';

    try {
        $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
        $telegram->handleGetUpdates();
    } catch (Longman\TelegramBot\Exception\TelegramException $e) {
        var_dump($e->getMessage());
        mail(getenv("ADMIN_EMAIL"), "Erreur lors de l'initialisation Telegram", $e->getMessage());
        return false;
    }

    return $telegram;
}

/**
 * @param $message
 * @return void
 * @throws \Longman\TelegramBot\Exception\TelegramException
 */
function sendTelegramMessage($message) {
    $telegram = initTelegram();
    $result = Request::sendMessage([
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
 * @param $price
 * @param $retour
 * @return void
 * @throws \Longman\TelegramBot\Exception\TelegramException
 */
function sendTelegramBooking($name, $tel, $trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $price, $retour, $bookingToken, $distance, $duration) {
    if ($retour === "true") $retourMessage = "(Trajet aller-retour)";
    else $retourMessage = "(Trajet aller simple)";

    $telegram = initTelegram();
    if ($telegram) {
        $result = Request::sendMessage([
            'chat_id' => getenv("TELEGRAM_CHAT_ID"),
            'text'    => "*---Nouvelle course---*\n\n"
                . "*$name ($tel)*\n"
                . "*Date:* $trip_date à $trip_time\n\n"
                . "*Départ:* $pick_address\n"
                . "*Arrivée:* $drop_address\n"
                . "*Itinéraire:* [Google Maps](https://www.google.com/maps/dir/?api=1&origin=$pick_address&destination=$drop_address&destination_place_id=$drop_place_id&origin_place_id=$pick_place_id)\n"
                . "*Distance:* $distance ($duration)\n\n"
                . "*Tarif:* $price € $retourMessage\n\n"
                . "✔ [Accepter](https://toprak-transport.fr/booking.php?accept=$bookingToken) --- "
                . "❌ [Refuser](https://toprak-transport.fr/booking.php?cancel=$bookingToken)\n\n",
            'parse_mode' => "MARKDOWN",
            'disable_web_page_preview' => true
        ]);
    }
}