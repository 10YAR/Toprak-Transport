<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>

			<!--Header Banner Content Start-->
			<section class="tj-banner">
				<div class="container">
					<div class="row">
						<!--Header Banner Caption Content Start-->
						<div class="col-md-12 col-sm-12">
							<div class="banner-caption">
								<div class="banner-inner bounceInRight animated delay-2s">
									<strong>Toprak Transport</strong>
									<h2>Votre Taxi en Seine-et-Marne</h2>
									<!--Header Banner Button Content Start-->		
									<div class="banner-btns">
										<a href="#book" class="btn-style-1">Réserver &nbsp; <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
									</div>
									<!--Header Banner Button Content End-->		
								</div>
							</div>
						</div>
						<!--Header Banner Caption Content End-->		
					</div>
				</div>
			</section>
			<!--Header Banner Content End-->
			
			<!--Banner Form 2 Content Start-->
			<section class="tj-banner-form2">
                <div id="book"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<!--Banner Form 2 Nav Start-->
							<div class="tj-form2-tabs">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#one-way" data-toggle="tab" role="Aller simple" onclick="changeType(false)">Aller simple</a></li>
									<li><a href="#two-way" data-toggle="tab" role="Aller retour" onclick="changeType(true)">Aller-retour</a></li>
								</ul>
							</div>
							<!--Banner Form 2 Nav End-->
							<!--Form Tab Content Start-->
							<div class="tab-content">
								<!--Banner Form 2 Tab One Way Section Start-->
								<div class="tab-pane active" id="one-way">
									<!--Banner Form 2 Content Start-->
									<form method="POST" class="trip-frm2 booking-frm" action="/reservation">
										<div class="col-md-12 col-sm-12">
											<h4>Départ</h4>
											<div class="field-box">
												<span class="fas fa-search"></span>
												<input id="autocomplete_depart" type="text" placeholder="Entrez une adresse" required />
                                                <input type="hidden" name="trip_pick_address" id="trip_pick_address" />
                                                <input type="hidden" name="trip_pick_place_id" id="trip_pick_place_id" />
											</div>
										</div>
										<div class="col-md-12 col-sm-12">
											<h4>Arrivée</h4>
											<div class="field-box">
												<span class="fas fa-search"></span>
												<input id="autocomplete_arrivee" type="text" placeholder="Entrez une adresse" required />
                                                <input type="hidden" name="trip_drop_address" id="trip_drop_address" />
                                                <input type="hidden" name="trip_drop_place_id" id="trip_drop_place_id" />
											</div>
										</div>
                                        <div class="col-md-6 col-sm-6">
                                            <h4>Quand ?</h4>
                                            <div class="field-box booking-frm">
                                                <span class="fas fa-calendar-alt trip_icons_nomobile"></span>
                                                <input id="flatpickr_date" class="flatpickr-input active" type="text" name="trip_date" placeholder="Sélectionner la date.." style="-webkit-appearance: none;" readonly required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <h4>À quelle heure ?</h4>
                                            <div class="field-box booking-frm">
                                                <span class="far fa-clock trip_icons_nomobile"></span>
                                                <input id="flatpickr_time" class="flatpickr-input active" type="text" name="trip_time" placeholder="Selectionnez l'heure.." style="-webkit-appearance: none;" readonly required />
                                            </div>
                                        </div>
										<div class="col-md-9 col-sm-9 trip_price_container">
                                            <div id="trip_error"></div>
											<div class="field-box"></div>
                                            <input id="input_aller_retour" type="hidden" name="retour" value="false" />
                                            <span id="mark_tarif"></span>
                                            <br />
                                            <span id="mark_distance"></span>
                                            <br />
                                            <span id="mark_duration"></span>
										</div>
										<div class="col-md-3 col-sm-3">
											<button type="submit" class="search-btn hover-button" id="trip_continue_button" disabled="disabled">Continuer <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
										</div>
									</form>
									<!--Banner Form 2 Content End-->
								</div>
								<!--Banner Form 2 Tab One Way Section End-->
							</div>
							<!--Form Tab Content End-->
						</div>
					</div>
				</div>
			</section>
			<!--Banner Form 2 Content End-->
			<!--Booking Services Section Start-->
			<section class="tj-book-services">
				<div class="container">
					<div class="row">
						<!--Booking Services Heading Start-->
						<div class="col-md-12 col-sm-12">
							<div class="tj-heading-style">
								<h3 style="text-transform: unset;">Voyagez en 3 étapes</h3>
								<p>Réservez d'abord, payez une fois arrivé à destination (par CB ou Espèces)</p>
							</div>
						</div>
						<!--Booking Services Heading End-->
						<!--Booking Services Box Start-->
						<div class="col-md-4 col-sm-4">
							<div class="service-box">
								<div class="icon-outer">
									<span style="font-weight:800">1</span>
									<i class="far fa-edit"></i>
								</div>
								<div class="service-caption">
									<h3>Réservation</h3>
									<p>Réservez votre trajet sur le site</p>
									<a href="#book">Réserver <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
						<!--Booking Services Box End-->
						<!--Booking Services Box Start-->
						<div class="col-md-4 col-sm-4">
							<div class="service-box">
								<div class="icon-outer">
									<span style="font-weight:800">2</span>
									<i class="far fa-thumbs-up"></i>
								</div>
								<div class="service-caption">
									<h3>Confirmation</h3>
									<p>Nous vous recontactons par téléphone pour confirmer votre réservation</p>
									<a href="#book">Réserver <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
						<!--Booking Services Box End-->
						<!--Booking Services Box Start-->
						<div class="col-md-4 col-sm-4">
							<div class="service-box">
								<div class="icon-outer">
									<span style="font-weight:800">3</span>
									<i class="fas fa-taxi"></i>
								</div>
								<div class="service-caption">
									<h3>Profitez du Voyage</h3>
									<p>Vous profitez de votre voyage en toute sérénité</p>
									<a href="#book">Réserver <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
						<!--Booking Services Box End-->
					</div>
				</div>
			</section>
			<!--Booking Services Section End-->
			
			<!--Facts Style 2 Section Start-->
			<section class="tj-facts2">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-3">
							<div class="fact-outer">
								<i class="far fa-smile"></i>
								<div class="fact-desc">
									<h3 class="fact-num">100</h3>
									<strong>%</strong>
									<span>Satisfactions</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-3">
							<div class="fact-outer">
								<i class="fas fa-tachometer-alt"></i>
								<div class="fact-desc">
                                    <h3 class="fact-num">1500</h3>
									<strong>+</strong>
									<span>Trajets</span>
								</div>
							</div>
						</div>
                        <div class="col-md-3 col-sm-3">
                            <div class="fact-outer">
                                <i class="fas fa-briefcase"></i>
                                <div class="fact-desc">
                                    <h3 class="fact-num">8</h3>
                                    <strong>+</strong>
                                    <span>Années d'expérience</span>
                                </div>
                            </div>
                        </div>
						<div class="col-md-3 col-sm-3">
							<div class="fact-outer">
								<i class="far fa-map"></i>
								<div class="fact-desc">
                                    <h3 class="fact-num">500</h3>
                                    <strong>+</strong>
									<span>Destinations</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--Facts Style 2 Section End-->

			<!--App Section Start-->
			<section class="tj-app">
				<div class="container">
					<div class="row">
						<!--App Info Section Start-->
						<div class="col-md-6 col-sm-7">
							<div class="app-info">
								<div class="tj-heading-style">
									<h3>4 raisons de nous choisir</h3>
								</div>

								<ul class="feature-list">
									<li><i class="fa fa-check" aria-hidden="true"></i>Réservation rapide et facile</li>
									<li><i class="fa fa-check" aria-hidden="true"></i>Tarif donné à l'avance, pas de surprises !</li>
									<li><i class="fa fa-check" aria-hidden="true"></i>Chauffeurs expérimentés et professionnels</li>
									<li><i class="fa fa-check" aria-hidden="true"></i>Véhicules en parfait état et contrôlés pour votre sécurité</li>
								</ul>
								<div class="app-links">
                                    <div class="book_btn">
                                        <a href="#book">Réserver <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                                    </div>
								</div>
							</div>
						</div>
						<!--App Info Section End-->
						<!--App Banner Section Start-->
						<div class="col-md-6 col-sm-5">
							<div class="app-banner-wrap">
								<div class="outer-circle">
									<div class="inner-circle">
										<div class="inner-circle2">
											<img src="images/custom/photo_eiffel.webp" alt="trajet Paris Tour Eiffel" loading="lazy" style="width: 100%;"/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--App Banner Section End-->
					</div>
                    <div class="row" style="padding: 0 1.5rem 0 1.5rem;font-size: 1.6rem;margin-top: 30px;">
                        <h4 style="color:#dd3751;">Réserver un chauffeur de taxi en Seine-et-Marne c'est facile !</h4>
                        <p>
                            En effet, grâce au <a href="#book">module de réservation</a> de notre page dédiée, vous n'êtes plus qu'à quelques clics. Dans un premier temps, grâce à cet outil, vous pouvez obtenir les frais de déplacement vers et depuis tous les secteurs de la Seine-et-Marne. Cela vous donne une vue en temps réel du prix à payer, rendant votre voyage plus serein.
                        </p>
                        <p>
                            Notre équipe d'excellents chauffeurs expérimentés dans la conduite de passagers est à votre service, y compris les prestations annexes, pour vous assurer en toute sécurité et monotonie tous vos trajets d'un point à un autre, qu'il s'agisse d'une gare ou d'un aéroport.
                        </p>
                        <p>
                            Le chauffeur promet de vous ramener à temps à votre destination. Votre sécurité est leur priorité numéro un, et si les choses ne semblent pas se dérouler comme prévu en cours de route, les chauffeurs sont toujours à la recherche de solutions appropriées.
                        </p>

                        <h4 style="color:#dd3751;margin-top:30px;">Toprak Transport : Votre taxi dans le département de la Seine-et-Marne (77)</h4>
                        <p>
                            Vous cherchez un taxi en Seine-et-Marne ?
                            Nous sommes votre interlocuteur privilégié pour tous vos besoins en taxi dans le département de la Seine-et-Marne. Toprak Transport est votre meilleur choix ! Nous assurons le transport 7 jours sur 7 dans les communes de Fontainebleau (77920), Melun (77000), Montereau-Fault-Yonne (77130), Barbizon (77630), Avon (77210), Nemours (77140), Dammarie-les-lys (77190), Le Mée-sur-Seine (77285), Lieusaint (77127), Bois-le-Roi (77590), Cannes-Ecluse (77130), Donnemarie-Dontilly (77520), Coulommiers (77120), Bagneaux-sur-Loing (77016), Bailly-Romainvilliers (77018), Barbey (77021) ou ailleurs dans le département.
                        </p>

                        <p>
                            Voyager peut être stressant, laissez-nous nous occuper du transport pour vous afin que vous puissiez vous concentrer sur votre temps libre. Que ce soit pour les affaires ou les loisirs, nous vous emmènerons là où vous devez aller.
                            Nos chauffeurs professionnels et courtois seront heureux de vous aider à porter vos bagages et de vous donner des conseils sur la Seine-et-Marne. Réservez un taxi avec Toprak Transport aujourd'hui !
                        </p>

                        <h4 style="color:#dd3751;margin-top:30px;">Réservez votre taxi pour rejoindre ou quitter l'aéroport</h4>
                        <p>
                            Vous devez vous rendre à l'aéroport ? Pas de problème ! Toprak Transport peut vous y conduire rapidement et en toute sécurité. Nous savons à quel point il est important d'arriver à l'heure à votre vol, c'est pourquoi nous ferons en sorte que vous arriviez à l'aéroport avec suffisamment de temps.
                        </p>
                        <p>
                            Nous sommes fiers de notre ponctualité et de notre sécurité, afin que vous puissiez vous détendre et profiter de votre voyage. Pour couronner le tout, nos tarifs sont très compétitifs, vous pouvez donc être sûr d'en avoir pour votre argent.
                        </p>

                        <h4 style="color:#dd3751;margin-top:30px;">Déplacez-vous en toute sécurité dans la Seine-et-Marne !</h4>
                        <p>
                            Toprak Transport s'engage à fournir à ses clients une expérience de transport sûre, fiable et confortable. Avec notre équipe de chauffeurs professionnels et nos véhicules modernes, nous pouvons garantir la ponctualité et le professionnalisme pour tous vos besoins de transport.
                        </p>
                        <p>
                            Nous offrons une variété de services, y compris le transport scolaire, les voyages d'affaires et le transport médical, dans toute la Seine-et-Marne.
                        </p>
                    </div>
				</div>
			</section>
			<!--App Section End-->
			
			<section class="tj-form-map" style="padding-top:30px;">
				<div class="container">
					<div class="row" style="display: flex;justify-content: center;">
						<!--<div class="col-md-6 col-sm-6 no-padr">
							<div id="tj-map2" class="tj-map2"></div>
						</div>-->
						<div class="col-md-8 col-sm-8 no-padl">
							<div class="form-box">
								<div class="form_desc">
									<h3>Besoin de nous contacter ?</h3>
									<p>Nous nous engageons à vous répondre sous 48 heures
                                        <br />
                                        Vous pouvez aussi nous contacter par téléphone au <a href="tel:0659742684" style="text-decoration:none;">06.59.74.26.84</a></p>
								</div>
								<form method="POST" class="contact_frm" action="contact-confirmation.php">
									<div class="frm-field">
										<div class="field-inner">
											<input type="text" name="nom" id="username" placeholder="Nom" required/>
										</div>
										<div class="field-inner">
											<input type="email" name="email" id="user_email" placeholder="Email" required/>
										</div>
									</div>
                                    <div class="frm-field">
                                            <input type="tel" name="phone" id="phone" placeholder="Téléphone portable" required/>
                                    </div>
									<div class="frm-field">
										<textarea name="message" id="send_msg" placeholder="Message" required></textarea>
                                        <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
									</div>
									<button type="submit" id="sumbit_btn" name="contact_form" value="envoyer" class="submit-btn" style="margin-top:0;">Envoyer <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
    <script type="text/javascript">
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
<?php require_once "core/footer.php"; ?>