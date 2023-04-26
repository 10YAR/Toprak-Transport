<?php
require_once "core/functions.php";

$titlePages = ["index.php" => "Toprak Transport - VTC / Service de Taxi à Montereau et Fontainebleau", "services.php" => "Nos services", "aboutus.php" => "Qui sommes nous", "contact.php" =>  "Nous contacter", "confidentialite.php" => "Politique de confidentialité", "cgu.php" => "Conditions générales d'utilisation", "mentions-legales.php" => "Mentions légales", "actualites.php" => "Actualités taxi et chauffeurs"];

if (isset($_GET['action']) && $_GET['action'] === "read") {
    $id = explode("-", $_GET['id'])[0];
    $actu = getActualite($id);
    $titlePage = $actu['title'];
}else {
    $titlePage = $titlePages[basename($_SERVER["SCRIPT_FILENAME"])] ?? "Toprak Transport : Service de Taxi à Fontainebleau et Montereau";
}

if (isset($_GET['acceptCookies']) && $_GET['acceptCookies'] === 'yes') {
    setcookie('acceptCookies', 'yes', time() + 365 * 24 * 3600, '/', 'toprak-transport.fr', false, true);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="description" content="<?= $actu['description'] ?? "Voyagez en toute sérénité avec nos chauffeurs privés ayant plus de 15 ans d'expérience. La référence du taxi en seine-et-marne. Réservez immédiatement en ligne"?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?= $actu['keywords'] ?? "fontainebleau, montereau, Service de Taxi, VTC, chauffeur, seine-et-marne, Uber, voyage, réservation, transporteur, aéroport, transport, hopital" ?>">
    <meta name="referrer" content="always">
    <meta name="robots" content="index, follow">

    <title><?= $titlePage ?></title>

    <link rel="canonical" href="https://toprak-transport.fr/<?= basename($_SERVER["SCRIPT_FILENAME"]) ?>">

    <link rel="icon" href="../images/custom/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/custom/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/custom/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/custom/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <link href="../css/bootstrap.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/style.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/fontawesome-all.min.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/color.css" id="switcher" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/owl.carousel.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/animate.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/responsive.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/icomoon.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="../css/flatpickr.min.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <?php if (basename($_SERVER["SCRIPT_FILENAME"]) === "actualites.php") { ?>
    <link href="../css/actus.css" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <script src="../js/ckeditor.js" defer></script>
    <?php } ?>

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
    <script src="../js/html5shiv.min.js" defer></script>
    <script src="../js/respond.min.js" defer></script>
    <![endif]-->
    <!-- Google tag (gtag.js) -->
    <script rel="dns-prefetch" src="https://www.googletagmanager.com/gtag/js?id=AW-11032844317" defer></script>
    <script defer>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-11032844317');
    </script>

    <script type="application/ld+json" defer>
	{
		"@context": "https://schema.org",
		"@type": "Organization",
		"name": "Toprak Transport : Service Taxi à Fontainebleau et Montereau",
		"url": "https://toprak-transport.fr/",
					"description": "Service de Taxi chauffeur privé VTC, booker dès maintenant une course à Fontainebleau ou Montereau, estimation du prix en ligne et réservation au 0185481930.",
					"logo": "https://toprak-transport.fr/images/custom/favicon.png",
		"sameAs": [
			"https://toprak-transport.fr/",
			"https://www.facebook.com/topraktransports/"
			]
	}
	</script>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= $titlePage ?>">
    <meta property="og:image" content="https://toprak-transport.fr/images/custom/photo_banner.webp">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="1000">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:url" content="https://toprak-transport.fr/<?= basename($_SERVER["SCRIPT_FILENAME"]) ?>">
    <meta property="og:title" content="<?= $titlePage ?>">
    <meta property="og:description" content="<?= $actu['description'] ?? "Voyagez en toute sérénité avec nos chauffeurs privés ayant plus de 15 ans d'expérience. Contactez-nous au 06.59.74.26.84 ou réservez votre trajet en ligne"?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:description" content="<?= $actu['description'] ?? "Voyagez en toute sérénité avec nos chauffeurs privés ayant plus de 15 ans d'expérience. Contactez-nous au 06.59.74.26.84 ou réservez votre trajet en ligne"?>">
    <meta name="twitter:title" content="<?= $titlePage ?>">
    <meta name="twitter:image" content="https://toprak-transport.fr/images/custom/photo_banner.webp">

    <meta name="msapplication-TileColor" content="#DD3751">
    <meta name="theme-color" content="#DD3751">
</head>
<body>
<div class="tj-wrapper">