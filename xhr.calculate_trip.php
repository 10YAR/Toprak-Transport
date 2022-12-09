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
    if ($value_distance_from_home > 50000) {
        return (["error" => 3, "message" => "Nous sommes désolés, nous ne proposons pas nos services de taxi dans votre secteur"]);
    }

    $distance = getDistance($depart, $arrivee);
    $text_distance = $distance->routes[0]->legs[0]->distance->text;
    $value_distance = $distance->routes[0]->legs[0]->distance->value;
    $duration = $timestamp1 + $distance->routes[0]->legs[0]->duration->value;
    $duration_text = $distance->routes[0]->legs[0]->duration->text;

    if ($value_distance < 5000) {
        $price = 19;
        $tranche = "A";
    }elseif ($value_distance > 5000 AND $value_distance < 10000) {
        $price = 25;
        $tranche = "A";
    }elseif ($value_distance > 10000 AND $value_distance < 15000) {
        $price = 30;
        $tranche = "A";
    }elseif ($value_distance > 15000 AND $value_distance < 20000) {
        $price = 35;
        $tranche = "B";
    }elseif ($value_distance > 20000 AND $value_distance < 30000) {
        $price = 40;
        $tranche = "B";
    }elseif ($value_distance > 30000 AND $value_distance < 40000) {
        $price = 60;
        $tranche = "B";
    }elseif ($value_distance > 40000 AND $value_distance < 50000) {
        $price = 70;
        $tranche = "C";
    }elseif ($value_distance > 50000 AND $value_distance < 60000) {
        $price = 80;
        $tranche = "C";
    }elseif ($value_distance > 60000 AND $value_distance < 70000) {
        $price = 90;
        $tranche = "C";
    }elseif ($value_distance > 70000 AND $value_distance < 80000) {
        $price = 100;
        $tranche = "D";
    }elseif ($value_distance > 80000 AND $value_distance < 90000) {
        $price = 110;
        $tranche = "D";
    }else {
        $price = ceil((($value_distance / 10000) * 18) / 10) * 10;
        $tranche = "D";
    }

    // Définition des tranches de prix supplémentaires
    $tranches = array("A" => 15, "B" => 20, "C" => 30, "D" => 40);

    // Si réservation de nuit... prix plus cher!
    if ($pick_hour > 23 OR $pick_hour < 7)
        $price += $tranches[$tranche];

    // Diff heures
    $date1 = date_create("now");
    $date2 = date_create($formatted_date);
    $hours_diff = date_diff($date1, $date2);
    $hours_diff_calc = $hours_diff->h;
    $hours_diff_calc += ($hours_diff->days * 24);

    // Si réservation immédiate (-8heures), tarif + cher
    if ($hours_diff_calc < 2) {

    }
    // on décale pour que ce soit toujours appliqué
    if ($price < 50)
        $price += $tranches[$tranche];
    else
        $price += ($price / 10) * 2.3;

    // Si c'est un trajet aller retour...
    if ($allerretour == "true") {
        $price_double = ($price * 2);
        $price = $price_double - (($price_double / 100) * 10);
        $dist_only = str_replace(" km", "", $text_distance);
        $text_distance = ($dist_only*2)+3 . " km";
    }

    if ($value_distance_from_home > 40000) {
        $price += (($price / 3) * 3.0);
    }elseif ($value_distance_from_home > 45000) {
        $price += (($price / 3) * 6.0);
    }

    $duration_text = str_replace([" hour", " mins"], ["h", "min"], $duration_text);
    return (["price" => (ceil(round($price)/10) * 10) - 3, "distance" => $text_distance, "duration" => $duration, "text_duration" => $duration_text]);
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