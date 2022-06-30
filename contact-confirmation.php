<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>
<?php
define('TO_EMAIL', 'contact@toprak-transport.fr');

/**
 * Function for sending email message
 * @return string ( Return Email Sending Status )
 */
function sendEmailMsg(){

    if(!empty($_POST['contact_form'])){

        $captcha_error = false;
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_response = $_POST['recaptcha_response'];
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $captcha_secret_v3 . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        if ($recaptcha->score > 0.7) {

            $name = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

            if (!empty($name) && !empty($email) && !empty($message)) {

                $headers = 'From: ' . $email . "\r\n";
                $headers .= 'Reply-To: ' . $email . "\r\n";
                $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

                /* Formatting Email Message */
                $title = 'Toprak Transport : Nouveau message de ' . $name;
                $message =
                    'Un client a envoyé un message sur le site :' . "\n\n"
                    . 'Nom: ' . $name . "\n"
                    . 'Email: ' . $email . "\n"
                    . 'Message:' . "\n"
                    . $message . "\n\n\n"
                    . 'Sender IP Address: ' . getUserIp() . "\n";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') sendEmailMsg();
?>
<section class="tj-payment" id="success-payment">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="success-msg">
                    <?php if ($captcha_error) { ?>
                        <span class="fas fa-check"></span>
                        <h3>Message envoyé!</h3>
                        <p>Votre message a bien été envoyé, nous y répondrons par email sous 48 heures</p>
                        <a href="/"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Retour à l'accueil</a>
                    <?php }else { ?>
                        <form method="POST" class="tj-contact-form" id="contact-form" action="contact-confirmation.php">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="inner-holder">
                                        <label for="name">Nom</label>
                                        <input placeholder="Nom et prénom" name="nom" type="text" id="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 no-pad">
                                    <div class="inner-holder">
                                        <label for="email">Email</label>
                                        <input placeholder="E-mail" name="email" type="email" id="email" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner-holder">
                                        <label for="message">Message</label>
                                        <textarea name="message" placeholder="Votre message" id="message" required></textarea>
                                        <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="inner-holder">
                                        <button class="btn-submit" id="frm_submit_btn" name="contact_form" type="submit">Envoyer <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            $(document).ready(function () {
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('<?= $captcha_public_v3 ?>', {action: 'contact'}).then(function (token) {
                                        var recaptchaResponse = document.getElementsByClassName('recaptchaResponse');
                                        for (var child of recaptchaResponse) {
                                            child.value = token;
                                        }
                                    });
                                });
                            });
                        </script>
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
                            <a href="mailto:info@toprak-transport.fr">
                                info@toprak-transport.fr
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "core/footer.php"; ?>
