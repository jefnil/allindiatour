<!-- 
    !============= Footer Area Start ===========!
 -->
<section class="rt-site-footer" data-scrollax-parent="true">
    
        <div class="footer-subscripbe-box wow fade-in-bottom">
           <div class="container">
               <div class="row">
                   <div class="col-xl-8 col-lg-10 mx-auto text-center">
                        <div class="rt-section-title-wrapper" style="box-shadow: 0px 0px 15px 3px rgb(148 148 148);border-radius:10px; padding: 20px;margin: 20px;" >
							<div class="rt-section-title-wrapper">
								<h2 class="title-color rt-section-title">
									Enquiry Form
								</h2><!-- /.rt-section-title -->
							</div><!-- /.rt-section-title-wrapper- -->
                    <form action="#" class="rt-form rt-line-form" id="enquiry-form" method="POST">
                        <input type="text" placeholder="Name" name="form_name" class="form-control rt-mb-30">
                        <input type="email" placeholder="Email" name="form_email" class="form-control rt-mb-30">
                        <input type="text" placeholder="Mobile Number" name="form_mobile" class="form-control rt-mb-30">
                        <textarea placeholder="Message" class="form-control rt-mb-30" name="form_message"></textarea>
                        <!-- Submit button with reCAPTCHA trigger -->
                        <button class="g-recaptcha rt-btn rt-gradient pill text-uppercase rt-mb-30" 
                            data-sitekey="6Ld3rdoiAAAAALzi60mPIyOMEjnpJuyFRWjPTaAM" 
                            data-callback='onSubmit' 
                            data-action='submit'>Submit</button>
                    </form>
                    <?php
                    // Google reCAPTCHA API keys settings  
                    $secretKey     = '6Ld3rdoiAAAAAHPume28BHwY_IPnNN0XUaOxqztf';  
                      
                    // Email settings  
                    $recipientEmail = 'tours@allindiatours.com';  
                    $ccEmail = "witbuzteam@gmail.com";
                      
                    // Assign default values 
                    $postData = $valErr = $statusMsg = ''; 
                    $status = 'error'; 
                     
                    // If the form is submitted 
                    if(isset($_POST['form_email'])){  
                        // Retrieve value from the form input fields 
                        $postData = $_POST;  
                        
                        $form_name = trim($_POST['form_name']);  
                        $form_email = trim($_POST['form_email']);  
                        $form_mobile = trim($_POST['form_mobile']);  
                        $form_message = trim($_POST['form_message']);  
                      
                        // Validate input fields  
                        if(empty($form_name)){  
                            $valErr .= 'Please enter your name.<br/>';  
                        }  
                        if(empty($form_email) || filter_var($form_email, FILTER_VALIDATE_EMAIL) === false){  
                            $valErr .= 'Please enter a valid email.<br/>';  
                        }  
                        if(empty($form_mobile) || !preg_match('/^[0-9]{10}+$/', $form_mobile)){  
                            $valErr .= 'Please enter a valid mobile number.<br/>';  
                        } 
                        if(empty($form_message)){  
                            $valErr .= 'Please enter message.<br/>';  
                        } 
                      
                        // Check whether submitted input data is valid  
                        if(empty($valErr)){  
                            // Validate reCAPTCHA response  
                            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){  
                      
                                // Google reCAPTCHA verification API Request  
                                $api_url = 'https://www.google.com/recaptcha/api/siteverify';  
                                $resq_data = array(  
                                    'secret' => $secretKey,  
                                    'response' => $_POST['g-recaptcha-response'],  
                                    'remoteip' => $_SERVER['REMOTE_ADDR']  
                                );  
                      
                                $curlConfig = array(  
                                    CURLOPT_URL => $api_url,  
                                    CURLOPT_POST => true,  
                                    CURLOPT_RETURNTRANSFER => true,  
                                    CURLOPT_POSTFIELDS => $resq_data  
                                );  
                      
                                $ch = curl_init();  
                                curl_setopt_array($ch, $curlConfig);  
                                $response = curl_exec($ch);  
                                curl_close($ch);  
                      
                                // Decode JSON data of API response in array  
                                $responseData = json_decode($response);  
                      
                                // If the reCAPTCHA API response is valid  
                                if($responseData->success){ 
                                    // Send email notification to the site admin  
                                    $to = $recipientEmail;  
                                    $subject = 'New Enquiry Request Submitted';  
                                    $htmlContent = "  
                                        <h4>Enquiry request details</h4>  
                                        <p><b>Name: </b>".$form_name."</p>  
                                        <p><b>Email: </b>".$form_email."</p>  
                                        <p><b>Mobile: </b>".$form_mobile."</p>  
                                        <p><b>Message: </b>".$form_message."</p>  
                                    ";  
                                      
                                    // Always set content-type when sending HTML email  
                                    $headers = "MIME-Version: 1.0" . "\r\n";  
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";  
                                    // Sender info header  
                                    $headers .= 'From:'.$form_name.' <'.$form_email.'>' . "\r\n";
                                    $headers .= 'Cc:'.$ccEmail."\r\n";

                                    // Send email  
                                    @mail($to, $subject, $htmlContent, $headers);  
                                      
                                    $status = 'success';  
                                    $statusMsg = 'Thank you! Your contact request has been submitted successfully.';  
                                    $postData = '';  
                                }else{  
                                    $statusMsg = 'The reCAPTCHA verification failed, please try again.';  
                                }  
                            }else{  
                                $statusMsg = 'Something went wrong, please try again.';  
                            }  
                        }else{  
                            $valErr = !empty($valErr)?'<br/>'.trim($valErr, '<br/>'):'';  
                            $statusMsg = 'Please fill all the mandatory fields:'.$valErr;  
                        }  
                    }  
                      
                    if(!empty($statusMsg)) {
                    ?>
                        <p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
                    <?php
                    }
                    ?>
                        </div><!-- /.rt-section-title-wrapper -->
                   </div><!-- /.col-lg-7 -->
               </div><!-- /.row -->
               <div class="rt-dot-divider"></div><!-- /.rt-dot-divider -->
           </div><!-- /.container -->
        </div><!-- /.footer-subscripbe-box -->
        <div class="rt-shape-emenetns-1" data-scrollax="properties: { translateY: '340px' }"></div><!-- /.rt-shape-emenetns-1 -->   
    <div class="footer-top rtbgprefix-cover" style="background: -webkit-linear-gradient(147deg, #000000 0%, #434343 74%);
    background-color: #000000;
    background-image: linear-gradient(147deg, #000000 0%, #434343 74%);">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="rt-single-widget wow fade-in-bottom" data-wow-duration="1s">
                        <h3 class="rt-footer-title">Company Info</h3><!-- /.rt-footer-title -->
                        <p style="color:#fff;text-align:justify;">Welcome tours brings unparalleled creativity and luxe personalization to 
						every vivid detail of your event. Our dynamic team specialize in uniquely personalized 
						events that integrate client brands with incredibly sensory details, bringing dream
						designs to vibrant life.</p>

                    </div><!-- /.rt-single-widge -->
                </div><!-- /.col-lg-3-->
                
                <div class="col-lg-3 col-md-6">
                    <div class="rt-single-widget wow fade-in-bottom" data-wow-duration="2s">
                        <h3 class="rt-footer-title">
                           Address
                        </h3>
                        <ul class="rt-usefulllinks">
                        
                            <li><a href="#"># 150 Anna Salai Mount Road,
Chennai – 600 002. India.
(Diagonally Opp Spencer’s shopping mall & Opp  Bus stop of Quaid-E-Millath Arts College)
(Off Anna Salai — Mount Road)</a></li>
                            <li><a href="#">Tel: + 91 44 2846 0677</a></li>
                            <li><a href="#">Whatsapp: +91 94443 70030</a></li>
                            <li><a href="#">Email: tours@allindiatours.com</a></li>
                        </ul><!-- /.rt-usefulllinks -->
                    </div><!-- end single widget -->
                </div><!-- /.col-lg-3-->
				<div class="col-lg-3 col-md-6">
                    <div class="rt-single-widget wow fade-in-bottom" data-wow-duration="1.5s">
                        <h3 class="rt-footer-title">VARIOUS BRANCHES</h3>
                        <ul class="rt-usefulllinks">
                            <li><a href="#">Mumbai</a></li>
                            <li><a href="#">Delhi</a></li>
                            <li><a href="#">Bengaluru</a></li>
                            <li><a href="#">Cochin</a></li>
                            
                        </ul>
                    </div><!-- /.rt-single-widget -->
                </div><!-- /.col-lg-3-->
                <div class="col-lg-3 col-md-6">
                    <div class="rt-single-widget wow fade-in-bottom" data-wow-duration="2.5s">
                        <h3 class="rt-footer-title">
                            Location
                        </h3>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7772.940857065531!2d80.272176!3d13.069345!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8b7dc16a2d87c425!2sWelcome%20Tours%20and%20Travels%20Chennai%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1649792918308!5m2!1sen!2sin" width="300" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div><!-- end single widget -->
                </div><!-- /.col-lg-3-->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.footer-top -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                <div class="copy-text wow fade-in-bottom" data-wow-duration="1s">
                    Copyright © 2022.All Rights Reserved By <a href="#">Witbuz</a>
                </div><!-- /.copy-text -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="rt-footer-social wow fade-in-bottom" data-wow-duration="1.5s">
                        <ul>
                            <li><a href="#"><img src="assets/images/brands/card-1.png" alt="cardimage" draggable="false"></a></li>
                            <li><a href="#"><img src="assets/images/brands/card-2.png" alt="cardimage" draggable="false"></a></li>
                            <li><a href="#"><img src="assets/images/brands/card-3.png" alt="cardimage" draggable="false"></a></li>
                            <li><a href="#"><img src="assets/images/brands/card-4.png" alt="cardimage" draggable="false"></a></li>
                            <li><a href="#"><img src="assets/images/brands/card-5.png" alt="cardimage" draggable="false"></a></li>
                            
                        </ul>
                    </div><!-- /.rt-footer-social -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.footer-bottom -->
</section>
<script>
$(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
});
</script>

<!-- ==================Start Js Link===================== -->
<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-2.2.4.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/jquery.easing.1.3.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/instafeed.min.js"></script>
<script src="assets/js/waypoints.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.scrollUp.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/TweenMax.min.js"></script>
<script src="assets/js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&amp;key=AIzaSyCy7becgYuLwns3uumNm6WdBYkBpLfy44k"></script>
<script src="assets/js/wow.js"></script>
<script src="assets/js/jquery.overlayScrollbars.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/jquery.appear.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/slider-range.js"></script>
<script src="assets/js/vivus.min.js"></script>
<script src="assets/js/tippy.all.min.js"></script>
<script src="assets/js/app.js"></script>


<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
   function onSubmit(token) {
     document.getElementById("enquiry-form").submit();
   }
   
   function onSubmit(token) {
     document.getElementById("contact-form").submit();
   }
 </script>
<!-- ==================End Js Link===================== -->

</body>


</html>