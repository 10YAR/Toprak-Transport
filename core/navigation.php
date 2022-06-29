<header class="tj-header">
    <!--Header Content Start-->
    <div class="container">
        <div class="row">
            <!--Toprow Content Start-->
            <div class="col-md-3 col-xs-12 col-sm-4">
                <!--Logo Start-->
                <div class="tj-logo">
                    <img src="../images/custom/logo.png" alt="Logo Toprak Transport" style="height:91px;" />
                </div>
                <!--Logo End-->
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4 no-display-mobile" style="visibility: hidden;">
                <div class="info_box">
                    <i class="fa fa-home"></i>
                    <div class="info_text">
                        <span class="info_title">Adresse</span>
                        <span>Montereau-Fault-Yonne</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-4 no-display-mobile">
                <div class="info_box">
                    <a href="mailto:info@toprak-transport.fr" style="text-decoration:none;">
                    <i class="fa fa-envelope"></i>
                    <div class="info_text">
                        <span class="info_title">Nous contacter</span>
                        <span><a href="mailto:info@toprak-transport.fr" style="text-decoration: none;">info@toprak-transport.fr</a></span>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 no-display-mobile">
                <div class="phone_info">
                    <div class="phone_icon">
                        <a href="tel:0659742684"> <i class="fas fa-phone-volume"></i> </a>
                    </div>
                    <div class="phone_text">
                        <span><a href="tel:0659742684">06.59.74.26.84</a></span>
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
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tj-navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Menu</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Navigation Content Start -->
                        <div class="collapse navbar-collapse" id="tj-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="/">Réserver un taxi</a>
                                </li>
                                <li>
                                    <a href="/services.html">Nos Services</a>
                                </li>
                                <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="../faq.html">FAQ</a></li>
                                        <li><a href="../payment-confirmation.html">Confirm Payment</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="/aboutus.php">Qui sommes nous</a>
                                </li>
                                <li>
                                    <a href="/contact.php">Nous contacter</a>
                                </li>

                            </ul>
                        </div>
                        <!-- Navigation Content Start -->
                    </nav>
                    <!--Menu Holder End-->
                    <div class="book_btn hover-button">
                        <a href="<?= $FILE == '/index.php' ? '#book' : '/#book' ?>">Réservation <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                    </div>
                </div><!--Nav Holder End-->
            </div>
        </div>
    </div>
</header>
<!--Header Content End-->