<?php
require_once "vendor/autoload.php";
require_once "core/SQL.php";

function saveBooking($trip_date, $trip_time, $pick_address, $drop_address, $pick_place_id, $drop_place_id, $retour, $nom, $tel, $email, $price) {
    global $db;
    $stmt = $db->prepare("INSERT INTO bookings 
    (trip_date, time, pick_address, drop_address, pick_place_id, drop_place_id, price, retour, nom, tel, email) 
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

    if ($stmt->execute()) return true;
    return false;
}