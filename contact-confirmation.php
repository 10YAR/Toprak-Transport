<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>
<?php
define('TO_EMAIL', 'contact@toprak-transport.fr, bulentbayrakli75@gmail.com');

if(!empty($_POST['contact_form'])) {

    $captcha_error = false;
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response = $_POST['recaptcha_response'];
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $captcha_private_v3 . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->score > 0.7) {

        $name = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_EMAIL);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        if (!empty($name) && !empty($email) && !empty($message)) {

            $headers = 'From: ' . $email . "\r\n";
            $headers .= 'Reply-To: ' . $email . "\r\n";
            $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

            /* Formatting Email Message */
            $title = 'Toprak Transport : Nouveau message de ' . $name;
            $message .= "\n\n\n" . 'Téléphone: ' . $phone . "\n\n";

            // Send Mail
            $result = mail(TO_EMAIL, $title, $message, $headers);
            if ($result) {
                $status = 1;
            } else {
                $status = 0;
            }
        }
    }else {
        $captcha_error = true;
    }
}

/**
 * Function for getting user IP address
 * @return string ( Return IP Address )
 */
function getUserIp() {
    $ip = '';

    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    } else if(getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    } else if(getenv('REMOTE_ADDR')) {
        $ip = getenv('REMOTE_ADDR');
    } else {
        $ip = 'N/A';
    }

    return $ip;
}
?>
<section class="tj-payment" id="success-payment">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="success-msg">
                    <?php if (isset($captcha_error) && $captcha_error == false) { ?>
                        <span class="fas fa-check"></span>
                        <h3>Message envoyé!</h3>
                        <p>Votre message a bien été envoyé, nous y répondrons par email sous 48 heures</p>
                        <a href="/"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retour à l'accueil</a>
                    <?php } else { ?>
                        <span class="fas fa-exclamation-triangle"></span>
                        <h3>Erreur!</h3>
                        <p>Votre message n'a pas été envoyé, veuillez réessayer</p>
                        <a href="/"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retour à l'accueil</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="address-box">
                    <div class="add-info">
                        <span class="icon-map icomoon"></span>
                        <p>Toprak Transport, <br>Montereau-Fault-Yonne,<br> France</p>
                    </div>
                    <div class="add-info">
                        <span class="icon-phone icomoon"></span>
                        <p>
                            <a href="tel:0659742684">06.59.74.26.84</a>
                        </p>
                    </div>
                    <div class="add-info">
                        <span class="icon-mail-envelope-open icomoon"></span>
                        <p>
                            <a href="mailto:contact@toprak-transport.fr">
                                contact@toprak-transport.fr
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "core/footer.php"; ?>
