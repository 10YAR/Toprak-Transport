<!--Footer Content Start-->
<section class="tj-footer2" style="<?= $FILE == '/index.php' ? 'padding:200px 0 35px;' : '' ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <ul class="payment-icons">
                    <li><i class="fab fa-cc-visa"></i></li>
                    <li><i class="fab fa-cc-mastercard"></i></li>
                    <li><i class="fas fa-coins"></i></li>
                </ul>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="copyright_text">
                    <p>
                        &copy; Copyright <?= date("Y") ?> Toprak Transport - Taxi Montereau<br />
                        <a href="/mentions-legales" title="Mentions Légales">Mentions légales</a> - <a href="/conditions-generales-d-utilisation" title="CGU">CGU</a> - <a href="/politique-de-confidentialite" title="Politique de confidentialité">Politique de confidentialité</a>
                        <span class="footer_leftText">Horaires d'ouverture : 7j/7 et 24h/24 <br/> Réalisation <a href="https://diyar-bayrakli.fr" title="Diyar Bayrakli" target="_blank">Diyar Bayrakli</a></span>
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
<!--<script src="../js/map.js" defer></script>-->
<script src="../js/moment.js" defer></script>
<script src="../js/flatpickr.js" defer></script>
<script rel="dns-prefetch" src="https://npmcdn.com/flatpickr@4.6.9/dist/l10n/fr.js" defer></script>
<script src="../js/reservation.js" defer></script>
<script rel="dns-prefetch" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?= getenv('GOOGLE_CLOUD_API_KEY') ?>&callback=initializeMap" defer></script>
<script rel="dns-prefetch" src="https://www.google.com/recaptcha/api.js?render=<?= getenv('CAPTCHA_PUBLIC_V3') ?>" defer></script>
<script src="../js/custom.js" defer></script>
<!-- Js Files End -->
</body>
<?php
if (isset($_GET['acceptCookies']) && $_GET['acceptCookies'] == 'yes') {
    setcookie('acceptCookies', 'yes', time() + 365 * 24 * 3600, '/', null, false, true);
} elseif (empty($_COOKIE['acceptCookies'])) {
?>
<div class="rgpd">
    <div class="rgpd__content">
        <p class="rgpd__content__text">En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de cookies pour vous proposer des services et offres adaptés à vos centres d’intérêts. <a href="/politique-de-confidentialite" title="Politique de confidentialité">En savoir plus</a></p>
        <a class="rgpd_accept_button" href="?acceptCookies=yes">J'accepte</a>
    </div>
</div>
<?php } ?>

<div id="fb-root"></div>
<div id="fb-customer-chat" class="fb-customerchat"></div>
<script type="text/javascript" defer>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "115415361167825");
    chatbox.setAttribute("attribution", "biz_inbox");
    chatbox.setAttribute("welcome_screen_greeting", "Discutez avec nous ici!");
    chatbox.setAttribute("logged_out_greeting", "Discutez avec nous ici!");
    chatbox.setAttribute("theme_color", "#dd3751");

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

<?php if ($_COOKIE['acceptCookies'] === 'yes') { ?>
<!-- Matomo -->
<script>
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(["setCookieDomain", "*.toprak-transport.fr"]);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//matomo.diyar.dev/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '2']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="//matomo.diyar.dev/matomo.php?idsite=2&amp;rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Matomo Code -->
<?php } ?>
</html>