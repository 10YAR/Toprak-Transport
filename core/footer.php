<!--Footer Content Start-->
<section class="tj-footer2" style="<?= $FILE == '/index.php' ? 'padding:200px 0 35px;' : '' ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <ul class="payment-icons">
                    <li><i class="fab fa-cc-visa"></i></li>
                    <li><i class="fab fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-coins"></i></li>
                </ul>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="copyright_text">
                    <p>
                        &copy; Copyright <?= date("Y") ?> Toprak Transport - Taxi en Seine-et-Marne
                        <span style="float:right;display:inline-block;">Horaires d'ouverture : 7j/7 et 24h/24 - Réalisation <a href="https://diyar-bayrakli.fr" target="_blank">Diyar Bayrakli</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Footer Content End-->
</div>
<!--Wrapper Content End-->
<!-- Js Files Start -->
<script src="../js/bootstrap.min.js" defer></script>
<script src="../js/migrate.js" defer></script>
<script src="../js/owl.carousel.min.js" defer></script>
<script src="../js/jquery.isotope.min.js" defer></script>
<script src="../js/imagesloaded.pkgd.min.js" defer></script>
<script src="../js/jquery.counterup.min.js" defer></script>
<script src="../js/waypoints.min.js" defer></script>
<script src="../js/jquery.validate.min.js" defer></script>
<script src="../js/map.js" defer></script>
<script src="../js/moment.js" defer></script>
<script src="../js/flatpickr.js" defer></script>
<script src="https://npmcdn.com/flatpickr@4.6.9/dist/l10n/fr.js" defer></script>
<script src="../js/reservation.js" defer></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?= getenv('GOOGLE_CLOUD_API_KEY') ?>&callback=initializeMap" defer></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('CAPTCHA_PUBLIC_V3') ?>" defer></script>
<script src="../js/custom.js" defer></script>
<!-- Js Files End -->
</body>

<div id="fb-root"></div>
<div id="fb-customer-chat" class="fb-customerchat"></div>
<script type="text/javascript">
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "115415361167825");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v14.0'
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/fr_FR/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</html>