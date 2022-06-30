<?php
require_once "core/functions.php";

$titlePages = ["index.php" => "Toprak Transport : Taxi en Seine-et-Marne", "services.php" => "Nos services", "aboutus.php" => "Qui sommes nous", "contact.php" =>  "Nous contacter"];
$titlePage = $titlePages[basename($_SERVER["SCRIPT_FILENAME"])] ?? "Toprak Transport : Taxi en Seine-et-Marne";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Voyagez en toute sérénité avec nos chauffeurs privés ayant plus de 15 ans d'expérience. La référence du taxi en seine-et-marne. Réservez immédiatement en ligne">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titlePage ?></title>

    <link rel="icon" href="../images/custom/favicon.ico" />

    <link href="../css/bootstrap.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/style.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/fontawesome-all.min.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/color.css" id="switcher" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/owl.carousel.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/animate.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/responsive.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/icomoon.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/flatpickr.min.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">

    <noscript>
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/fontawesome-all.min.css" rel="stylesheet">
        <link href="../css/color.css" id="switcher" rel="stylesheet">
        <link href="../css/owl.carousel.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/responsive.css" rel="stylesheet">
        <link href="../css/icomoon.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/flatpickr.min.css">
    </noscript>

    <script src="../js/jquery-1.12.5.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" defer></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" defer></script>
    <![endif]-->

</head>
<body>
<div class="tj-wrapper">