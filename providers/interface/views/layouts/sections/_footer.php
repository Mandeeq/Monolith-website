<?php
use yii\helpers\Url;

$basePath = \yii::$app->request->baseUrl . '/providers/interface/assets/admin/';
?>

<!-- Footer -->
<footer class="footer-area">
    <div class="container">
        <div class="row justify-content-between">
            <!-- Logo and Contact -->
            <div class="col-xl-3 col-sm-6 col-md-3 col-lg-3">
                <div class="single-footer-widget footer_1">
                    <img src="<?= $basePath ?>assets/img/logo.png" alt="Logo" />
                    <p>+880 253 356 263</p>
                    <span>burires@contact.com</span>
                    <div class="social_icon">
                        <a href="#" class="single_social_icon"><i class="fab fa-facebook-square"></i></a>
                        <a href="#" class="single_social_icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-xl-3 col-sm-6 col-md-2 col-lg-3">
                <div class="single-footer-widget footer_2">
                    <h4>Quick links</h4>
                    <div class="contact_info">
                        <ul>
                            <li><a href="<?= Url::to(['/site/about']) ?>">About</a></li>
                            <li><a href="<?= Url::to(['/menu/index']) ?>">Menu</a></li>
                            <li><a href="<?= Url::to(['/reservation/index']) ?>">Reservation</a></li>
                            <li><a href="<?= Url::to(['/blog/index']) ?>">Blog</a></li>
                            <li><a href="<?= Url::to(['/site/breakfast']) ?>">Breakfast</a></li>
                            <li><a href="<?= Url::to(['/site/lunch']) ?>">Lunch</a></li>
                            <li><a href="<?= Url::to(['/site/dinner']) ?>">Dinner</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-xl-3 col-sm-6 col-md-4 col-lg-3">
                <div class="single-footer-widget footer_3">
                    <h4>Subscribe newsletter</h4>
                    <form action="#">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Email Address"
                                    onfocus="this.placeholder=''" onblur="this.placeholder='Email Address'"/>
                                <div class="input-group-append">
                                    <button class="btn" type="button"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p>Subscribe newsletter to get all updates about discount and offers.</p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright_part_text">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="footer-text m-0">
                        &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with 
                        <i class="ti-heart" aria-hidden="true"></i> by 
                        <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END Footer -->
