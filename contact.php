<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>

    <section class="tj-contact-section">
        <div class="container">
            <div class="row">
                <div class="tj-heading-style">
                    <h3>Nous contacter</h3>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="form-holder">
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
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="address-box cta-list">
                        <div class="add-info">
                            <span class="icon-map icomoon"></span>
                            <p>Toprak Transport, <br />Montereau-Fault-Yonne,<br /> France</p>
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
<?php require_once "core/bandeau-footer.php"; ?>
<?php require_once "core/footer.php"; ?>