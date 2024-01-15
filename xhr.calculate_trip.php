<?php
require_once "core/functions.php";

if (!empty($_POST['depart']) && !empty($_POST['arrivee']) && !empty($_POST['pick_date']) && !empty($_POST['pick_time'])) {

    $depart = $_POST["depart"];
    $arrivee = $_POST["arrivee"];
    $pick_date = $_POST["pick_date"];
    $pick_time = $_POST["pick_time"];
    $allerretour = $_POST['allerretour'];

    echo json_encode(calculatePrice($depart, $arrivee, $pick_date, $pick_time, $allerretour));
}

function calculatePrice($depart, $arrivee, $pick_date, $pick_time, $allerretour) {

    $pick_hour = substr($pick_time, 0, 2);
    $pick_minute = substr($pick_time, 3, 2);

    // Date formattée en anglais
    $formatted_date = transDate($pick_date) . " ".$pick_hour.":".$pick_minute.":00";

    $timestamp1 = strtotime($formatted_date);
    $timestamp2 = strtotime(date("Y-m-d H:i:s"));

    // Cas où la date de réservation est déjà passée
    if ($timestamp1 <= $timestamp2) {
        return (["error" => 1, "message" => "L'heure indiquée est déjà dépassée !"]);
    }

    $diff_timestamp = $timestamp1 - $timestamp2;
    if ($diff_timestamp < 900) {
        return (["error" => 2, "message" => "Votre réservation est trop tôt. Choisissez un horaire de départ supérieur à 15 minutes."]);
    }

    $distance_from_home = getDistance("ChIJA-x2ddZC70cR5s7vOh8QaPA", $depart);
    $value_distance_from_home = $distance_from_home->routes[0]->legs[0]->distance->value ?? 1000000;

    // Cas où c'est trop loin
    if ($value_distance_from_home > 150000) {
        return (["error" => 3, "message" => "Nous sommes désolés, nous ne proposons pas nos services de taxi dans votre secteur"]);
    }

    $distance = getDistance($depart, $arrivee);
    $text_distance = $distance->routes[0]->legs[0]->distance->text;
    $value_distance = $distance->routes[0]->legs[0]->distance->value;
    $duration = $timestamp1 + $distance->routes[0]->legs[0]->duration->value;
    $duration_text = $distance->routes[0]->legs[0]->duration->text;

    $km_price = 1.6;

    // Si réservation de nuit... prix plus cher!
    $pick_time_frm = (float) ($pick_hour . "." . $pick_time);
    if ($pick_time_frm >= 22.0 || $pick_time_frm <= 7.0) $km_price = 2;

    $kms = $value_distance / 1000;
    $kms_from_home = $value_distance_from_home / 1000;

    $price = ceil($kms * $km_price);
    $price += ceil($kms_from_home * $km_price) / 4;

    // Si c'est un trajet aller retour...
    if ($allerretour == "true") {
        $price *= 2;
        $dist_only = str_replace(" km", "", $text_distance);
        $text_distance = ($dist_only*2)+3 . " km";
        $duration_text .= " (x2)";
    }else {
        if ($value_distance < 20000) $price += 5;
    }

    if ($value_distance > 90000) $price += 15;
    if ($price < 20) $price = 20;
    if ($price <= 20 && $allerretour === "true") $price = 35;

    $duration_text = str_replace([" hour", " mins"], ["h", "min"], $duration_text);
    return (["price" => (ceil(round($price)/10) * 10) - 5, "distance" => $text_distance, "duration" => $duration, "text_duration" => $duration_text]);
}

function getDistance($addressFrom, $addressTo){
    $apiKey = getenv('GOOGLE_CLOUD_API_KEY');
    $api = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".($addressFrom)."&destination=place_id:".($addressTo)."&region=fr&unit=metric&key=".$apiKey);
    return json_decode($api);
}

function transDate($date) {
    $day = substr($date, 0, 2);
    $month = substr($date, 3, 2);
    $year = substr($date, 6, 4);
    return $year . "-" . $month . "-" . $day ;
}

function frenchDate($date) {
    $date = str_replace(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'), $date);
    return $date;
}