<header class="tj-header">
    <!--Header Content Start-->
    <div class="container">
        <div class="row">
            <!--Toprow Content Start-->
            <div class="col-md-3 col-xs-12 col-sm-4">
                <!--Logo Start-->
                <div class="tj-logo">
                    <a href="/" title="Toprak Transport">
                        <img src="/images/custom/logo.webp" alt="Logo Toprak Transport" height="91" width="300" style="height:91px;" loading="lazy"/>
                    </a>
                </div>
                <!--Logo End-->
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4 no-display-mobile" style="visibility: hidden;">
                <div class="info_box">
                    <i class="fa fa-home"></i>
                    <div class="info_text" style="display: none;">
                        <span class="info_title">Adresse</span>
                        <span>Montereau-Fault-Yonne</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4 no-display-mobile">
                <div class="info_box contactHeader">
                    <a href="/contact" title="Contact Page" style="text-decoration:none;">
                    <i class="fa fa-envelope"></i>
                    <div class="info_text">
                        <span class="info_title">Nous contacter</span>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 no-display-mobile">
                <div class="phone_info">
                    <div class="phone_icon">
                        <a href="tel:0659742684" title="Contact Téléphone"> <i class="fas fa-phone-volume"></i> </a>
                    </div>
                    <div class="phone_text">
                        <span><a href="tel:0659742684" title="Contact Téléphone">06 59 74 26 84</a></span>
                    </div>
                </div>
            </div>
            <!--Toprow Content End-->
        </div>
    </div>

    <div class="tj-nav-row">
        <div class="container">
            <div class="row">
                <!--Nav Holder Start-->
                <div class="tj-nav-holder">
                    <!--Menu Holder Start-->
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <ul class="nav navbar-nav" style="float:left;">
                                <li>
                                    <a href="/#book" title="Réserver un trajet">Réserver un trajet</a>
                                </li>
                            </ul>
                            <button type="button" class="navbar-toggle collapsed" style="margin-top:12px;" data-toggle="collapse" data-target="#tj-navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Menu</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Navigation Content Start -->
                        <div class="collapse navbar-collapse" id="tj-navbar-collapse">
                            <ul class="nav navbar-nav" style="margin-left:15px;">
                                <li>
                                    <a href="/services" title="Nos Services">Nos Services</a>
                                </li>
                                <li>
                                    <a href="/actualites" title="Actualités">Actualités</a>
                                </li>
                                <li>
                                    <a href="/about-us" title="Qui sommes nous">Qui sommes nous</a>
                                </li>
                                <li>
                                    <a href="/contact" title="Nous contacter">Nous contacter</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Navigation Content Start -->
                    </nav>
                    <!--Menu Holder End-->
                    <div class="book_btn hover-button">
                        <a href="<?= $FILE == '/index.php' ? '#book' : '/#book' ?>" title="Réservation" style="font-weight:bold;">Réservation <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                    </div>
                </div><!--Nav Holder End-->
            </div>
        </div>
    </div>
</header>
<!--Header Content End-->