<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Unisson_Disability
 */

?>
</main>

<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-unisson app-md">
                <img src="<?php echo get_template_directory_uri();?>/./images/logo.svg" alt="">
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <ul class="footer-top-list">
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">NDIS</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <p class="footer-call"><a href="tel:1300 266 222">1300 266 222</a></p>
                    <p class="info">
                        <span>6 West Street</span>
                        <span>Pymble NSW 2073</span>
                        <span>PO Box 474</span>
                        <span>Gordon NSW 2072</span>
                    </p>
                    <p class="info">
                        <span>F: <a href="tel:(02) 9496 8701">(02) 9496 8701</a></span>
                        <span>E: <a href="mailto:hello@unisson.org.au">hello@unisson.org.au</a></span>
                    </p>
                </div>
                <div class="col-lg-5 ml-lg-auto">
                    <div class="lets-connect">
                        <h4>Let's connect</h4>
                        <div class="social-icons">
                            <a href="#"><img src="<?php echo get_template_directory_uri();?>/./images/icons/facebook.svg" alt=""></a>
                            <a href="#"><img src="<?php echo get_template_directory_uri();?>/./images/icons/youtube.svg" alt=""></a>
                            <a href="#"><img src="<?php echo get_template_directory_uri();?>/./images/icons/linkedin.svg" alt=""></a>
                            <a href="#"><img src="<?php echo get_template_directory_uri();?>/./images/icons/instagram.svg" alt=""></a>
                            <a href="#"><img src="<?php echo get_template_directory_uri();?>/./images/icons/twitter.svg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bot">
        <div class="container">
            <div class="footer-logos dis-md">
                <div class="footer-ndis">
                    <div class="logo">
                        <img src="<?php echo get_template_directory_uri();?>/./images/logo-ndis.svg" alt="">
                    </div>
                    <p class="text">Registered NDIS Provider</p>
                </div>
                <div class="footer-unisson">
                    <img src="<?php echo get_template_directory_uri();?>/./images/logo.svg" alt="">
                </div>
            </div>
            <div class="footer-bot-text">
                <div class="footer-ndis app-md">
                    <div class="logo">
                        <img src="<?php echo get_template_directory_uri();?>/./images/logo-ndis.svg" alt="">
                    </div>
                    <p class="text">Registered NDIS Provider</p>
                </div>
                <h2 class="copyright">&copy; Copyright 2022 Unisson Disability</h2>
                <ul class="footer-bot-list">
                    <li><a href="#">Terms &amp; Conditions</a></li>
                    <li><a href="#">Privacy policy</a></li>
                    <li><a href="#">Refund policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
    integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" crossorigin="anonymous"></script>
<script src="<?php echo get_template_directory_uri();?>/js/app.js"></script>
<?php wp_footer(); ?>
</body>

</html>