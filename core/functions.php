<?php
require_once "vendor/autoload.php";
require_once "core/SQL.php";
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, 'fr_FR.utf8','fra');
$captcha_public_v3 = getenv('CAPTCHA_PUBLIC_V3');
$captcha_private_v3 = getenv('CAPTCHA_PRIVATE_V3');
$FILE = $_SERVER['PHP_SELF'];

function saveBooking($trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $retour, $nom, $tel, $email, $price) {
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
        $cancel = urlencode(base64_encode(json_encode(array($last_id, $email), JSON_THROW_ON_ERROR)));
        createSendinblueContact($nom, $email, $tel);
        sendConfirmationEmail($email, $nom, $trip_date, $trip_time, $pick_address, $drop_address, $price, $retour, $cancel);
        return true;
    }
    return false;
}

function sendConfirmationEmail($email, $nom, $trip_date, $trip_time, $pick_address, $drop_addresss, $price, $retour, $cancel) {
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
        'cancel' => $cancel);

    try {
        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        return true;
    } catch (Exception $e) {
        mail(getenv("ADMIN_EMAIL"), "Erreur lors de l'envoi de l'email", $e->getMessage());
        return false;
    }
}

function createSendinblueContact($name, $email, $tel) {
    // Convert the attributes to a format that SendinBlue can understand
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

function cancelBooking($cancel) {
    global $db;
    $cancel = json_decode(base64_decode(urldecode($cancel)), JSON_THROW_ON_ERROR);
    $stmt = $db->prepare("UPDATE bookings SET status = :status WHERE id = :id AND email = :email");
    $stmt->bindValue(':status', "canceled");
    $stmt->bindValue(':id', $cancel[0]);
    $stmt->bindValue(':email', $cancel[1]);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function notifyWhatsapp($message) {
    $url = "https://api.whatsapp.com/send?phone=+33603806219&text=".urlencode($message['message']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_exec($ch);
    curl_close($ch);
}