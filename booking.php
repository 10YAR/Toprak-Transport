<?php require_once "core/header.php"; ?>
<?php require_once "core/navigation.php"; ?>
<?php
if (isset($_GET['cancel'])) {
    $cancel = $_GET['cancel'];
    if (!empty($cancel)) cancelBooking($cancel);
}
?>
<section class="tj-contact-section">
    <div class="container">
        <div class="row">
            <div class="tj-heading-style">
                <h3>Votre réservation</h3>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="tj-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#confirm_booking" data-toggle="tab">Réservation</a></li>
                    </ul>
                </div>
                <div class="tab-content" style="text-align: center;">
                    <i class="fas fa-check" style="color:#09c009;font-size: 4rem;"></i>
                    <h3>C'est annulé.</h3>
                    <p style="font-size: 16px;">
                        Votre réservation a été annulée.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "core/bandeau-footer.php"; ?>
<?php require_once "core/footer.php"; ?>
