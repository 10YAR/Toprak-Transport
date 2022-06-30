<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>
<?php require_once "xhr.calculate_trip.php"; ?>
    <!--Booking Form Section Start-->
    <section class="tj-user-bfrm">
        <div class="container">
            <div class="row">
                <?php if (!empty($_POST['trip_pick_place_id']) && !empty($_POST['trip_drop_place_id']) && !empty($_POST['trip_date']) && !empty($_POST['trip_time'])) {
                    $calculated_price = calculatePrice($_POST['trip_pick_place_id'], $_POST['trip_drop_place_id'], $_POST['trip_date'], $_POST['trip_time'], $_POST['retour']);
                    $preserved_data = base64_encode(json_encode(["trip_pick_place_id" => $_POST['trip_pick_place_id'], "trip_drop_place_id" => $_POST['trip_drop_place_id'], "trip_pick_address" => $_POST['trip_pick_address'], "trip_drop_address" => $_POST['trip_drop_address'], "trip_date" => $_POST['trip_date'], "trip_time" => $_POST['trip_time'], "retour" => $_POST['retour']]));
                    ?>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="tj-tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#confirm_booking" data-toggle="tab">Réservation</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="confirm_booking">
                            <form class="cb-frm" method="POST">
                                <div class="col-md-12 col-sm-12">
                                    <div class="info-field">
                                        <label>Nom et prénom</label>
                                        <span class="far fa-user"></span>
                                        <input type="text" name="nom" placeholder="Nom et prénom" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="info-field">
                                        <label>Téléphone mobile</label>
                                        <span class="icon-phone icomoon"></span>
                                        <input type="tel" name="telephone" placeholder="Téléphone mobile" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="info-field">
                                        <label>Email</label>
                                        <span class="far fa-envelope"></span>
                                        <input type="email" name="email" placeholder="Email" required/>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <input type="hidden" name="preserved_data" value="<?= $preserved_data ?>" required/>
                                    <button type="submit" class="book-btn hover-button" id="ride-bbtn">Confirmer la réservation <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="booking-summary">
                        <h3>Récapitulatif</h3>
                        <ul class="service-info">
                            <li><span>Date</span><br /><div class="end_loc info-outer"><?= frenchDate(date('l d F', strtotime(transDate($_POST['trip_date'])))) ?> à <?= str_replace(":", "h", $_POST['trip_time']) ?></div></li>
                            <li><span>Adresse de départ</span><br /><div class="startup_loc info-outer"><?= $_POST['trip_pick_address'] ?></div></li>
                            <li><span>Adresse d'arrivée</span><br /><div class="startup_loc info-outer"><?= $_POST['trip_drop_address'] ?></div></li>
                            <li><span>Arrivée prévue</span><br /><div class="startup_loc info-outer" style="text-transform: none;"><?= str_replace(":", "h", date('H:i', $calculated_price['duration'])) ?> (durée: <?= str_replace([" hour", " mins"], ["h", "min"], $calculated_price['text_duration']) ?>)</div></li>
                            <li><span>Distance</span><br /><div class="startup_loc info-outer"><?= $calculated_price['distance'] ?></div></li>
                        </ul>
                        <div class="fare-box">
                            <strong style="color:green;"><?= $calculated_price['price'] ?> € <span style="font-size: 16px;color:#777777;font-weight: 800;">TTC</span></strong>
                            <span class="trip_est" style="font-weight: 800;line-height:20px;font-size:13px;">Paiement par CB ou en espèces<br /> à la fin du trajet</span>
                        </div>
                    </div>
                </div>
                <?php }elseif (!empty($_POST['preserved_data']) && !empty($_POST['nom']) && !empty($_POST['telephone']) && !empty($_POST['email'])) {
                    $preserved_data = json_decode(base64_decode($_POST['preserved_data']), true, 512, JSON_THROW_ON_ERROR);
                    $calculated_price = calculatePrice($preserved_data['trip_pick_place_id'], $preserved_data['trip_drop_place_id'], $preserved_data['trip_date'], $preserved_data['trip_time'], $preserved_data['retour']);

                    $trip_date = frenchDate(date('l d F', strtotime(transDate($preserved_data['trip_date']))));
                    $trip_time = str_replace(":", "h", $preserved_data['trip_time']);
                    if (saveBooking($trip_date, $trip_time, $preserved_data['trip_pick_address'], $preserved_data['trip_drop_address'], $preserved_data['trip_pick_place_id'], $preserved_data['trip_drop_place_id'], $preserved_data['retour'], $_POST['nom'], $_POST['telephone'], $_POST['email'], $calculated_price['price'], $calculated_price['distance'], $calculated_price['text_duration']))
                    {
                    ?>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="tj-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#confirm_booking" data-toggle="tab">Réservation</a></li>
                                </ul>
                            </div>
                            <div class="tab-content" style="text-align: center;">
                                <i class="fas fa-check" style="color:#09c009;font-size: 4rem;"></i>
                                <h3>Merci.</h3>
                                <p style="font-size: 16px;">
                                    Nous allons vous contacter par téléphone afin de confirmer votre réservation <br />
                                    Le numéro appelant sera : 06 59 74 26 84<br />
                                    <span style="font-size: 14px;">(Ce message ne vaut pas confirmation de réservation)</span>
                                </p>
                            </div>
                        </div>
                    <?php }else { ?>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="tj-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#confirm_booking" data-toggle="tab">Réservation</a></li>
                                </ul>
                            </div>
                            <div class="tab-content" style="text-align: center;">
                                <i class="fas fa-cross" style="color:#c0092b;font-size: 4rem;"></i>
                                <h3>Une erreur s'est produite</h3>
                                <p style="font-size: 16px;">
                                    Votre réservation n'a pas pu être confirmée, veuillez <a href="/">réessayer</a>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="booking-summary">
                            <h3>Récapitulatif</h3>
                            <ul class="service-info">
                                <li><span>Date</span><br /><div class="end_loc info-outer"><?= $trip_date ?> à <?= $trip_time ?></div></li>
                                <li><span>Adresse de départ</span><br /><div class="startup_loc info-outer"><?= $preserved_data['trip_pick_address'] ?></div></li>
                                <li><span>Adresse d'arrivée</span><br /><div class="startup_loc info-outer"><?= $preserved_data['trip_drop_address'] ?></div></li>
                                <li><span>Arrivée prévue</span><br /><div class="startup_loc info-outer" style="text-transform: none;"><?= str_replace(":", "h", date('H:i', $calculated_price['duration'])) ?> (durée: <?= str_replace([" hour", " mins"], ["h", "min"], $calculated_price['text_duration']) ?>)</div></li>
                                <li><span>Distance</span><br /><div class="startup_loc info-outer"><?= $calculated_price['distance'] ?></div></li>
                            </ul>
                            <div class="fare-box">
                                <strong style="color:green;"><?= $calculated_price['price'] ?> € <span style="font-size: 16px;color:#777777;font-weight: 800;">TTC</span></strong>
                                <span class="trip_est" style="font-weight: 800;line-height:20px;font-size:13px;">Paiement par CB ou en espèces<br /> à la fin du trajet</span>
                            </div>
                        </div>
                    </div>
                <?php }else header("Location: 404.php"); ?>
            </div>
        </div>
    </section>
    <!--Booking Form Section End-->


<?php require_once "core/bandeau-footer.php"; ?>
<?php require_once "core/footer.php"; ?>