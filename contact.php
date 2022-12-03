<?php include "header1.php" ?>


<div class="rt-breadcump rt-breadcump-height">
    <div class="rt-page-bg rtbgprefix-cover" style="background-image: url(assets/images/backgrounds/bredcump.png)">
    </div><!-- /.rt-page-bg -->
    <div class="container">
        <div class="row rt-breadcump-height">
            <div class="col-12">
                <div class="breadcrumbs-content">
                    <h3>Contact Us</h3>
                    <div class="breadcrumbs">
                        <span class="divider"><i class="icofont-home"></i></span>
                        <a href="#" title="Home">Home</a>
                        <span class="divider"><i class="icofont-simple-right"></i></span>
                        Contact Us

                    </div><!-- /.breadcrumbs -->
                </div><!-- /.breadcrumbs-content -->
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.rt-bredcump -->


<section class="contact-area">
    <div class="rt-design-elmnts rtbgprefix-contain" style="background-image: url(assets/images/all-img/abt_vec_3.png)">

    </div><!-- /.rt-design-elmnts -->
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="rt-section-title-wrapper">
                    <h2 class="rt-section-title">
                        <span>Contact us</span>
                        
                        Get In Touch
                    </h2><!-- /.rt-section-title -->
                    <p>Any kind of travel information don't hesitate to contact with us for imiditate
                    customer support. We are love to hear from you</p>
                    <div class="section-title-spacer"></div><!-- /.section-title-spacer -->
                    <form action="#" class="rt-form rt-line-form" id="contact-form" method="POST">
                        <input type="text" placeholder="Name" name="form_name" class="form-control rt-mb-30">
                        <input type="email" placeholder="Email" name="form_email" class="form-control rt-mb-30">
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
                        $form_message = trim($_POST['form_message']);
                      
                        // Validate input fields
                        if(empty($form_name)) {
                            $valErr .= 'Please enter your name.<br/>';
                        }
                        if(empty($form_email) || filter_var($form_email, FILTER_VALIDATE_EMAIL) === false) {
                            $valErr .= 'Please enter a valid email.<br/>';
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
                                    $subject = 'New Contact Form Submitted';  
                                    $htmlContent = "  
                                        <h4>Contact request details</h4>  
                                        <p><b>Name: </b>".$form_name."</p>  
                                        <p><b>Email: </b>".$form_email."</p>  
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
            </div><!-- /.col-lg-9 -->
        </div><!-- /.row -->
        <div class="section-title-spacer"></div><!-- /.section-title-spacer -->
    </div><!-- /.container -->
</section>


<section class="rt-map-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mx-auto col-md-6">
                <div class="rt-single-icon-box icon-center text-center justify-content-center shdoaw-style wow fadeInUp">
                    <div class="icon-thumb">
                        <img src="assets/images/icons-image/con-1.png" alt="box-icon" draggable="false">
                    </div><!-- /.icon-thumb -->
                    <div class="iconbox-content">
                        <h5>Our Address</h5>
                        <p>
						Welcome Tours And Travels chennai pvt ltd,<br>
						# 150 Anna Salai Mount Road,<br>
						Chennai – 600 002. India
						</p>
                    </div><!-- /.iconbox-content -->
                </div><!-- /.rt-single-icon-box -->
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4 mx-auto col-md-6">
                <div class="rt-single-icon-box icon-center text-center justify-content-center shdoaw-style wow fadeInUp" data-wow-duration="1.5s">
                    <div class="icon-thumb">
                        <img src="assets/images/icons-image/con-2.png" alt="box-icon" draggable="false">
                    </div><!-- /.icon-thumb -->
                    <div class="iconbox-content">
                        <h5>Phone & Email</h5>
                        <p>Tel: + 91 44 2846 0677<br>
Whatsapp: +91 94443 70030
<br>
                        <a href="mailto:tours@allindiatours.com">tours@allindiatours.com</a></p>
                    </div><!-- /.iconbox-content -->
                </div><!-- /.rt-single-icon-box -->
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4 mx-auto col-md-6">
                <div class="rt-single-icon-box icon-center text-center justify-content-center shdoaw-style wow fadeInUp" data-wow-duration="2s">
                    <div class="icon-thumb">
                        <img src="assets/images/icons-image/con-3.png" alt="box-icon" draggable="false">
                    </div><!-- /.icon-thumb -->
                    <div class="iconbox-content">
                        <h5>Stay In Touch</h5>
                        <ul class="rt-social rt-circle-style">
                            
                            <li><a href="https://www.facebook.com/welcometoursindia/"><i class="icofont-facebook"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UCaCKA_KHb86HPqcggVKk5Bg"><i class="icofont-youtube"></i></a></li>
                            <li><a href="https://www.instagram.com/welcome_tours_and_travels/"><i class="icofont-instagram"></i></a></li>
                        </ul>
                    </div><!-- /.iconbox-content -->
                </div><!-- /.rt-single-icon-box -->
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    <div class="googleMap">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.470351117924!2d80.26998741416926!3d13.069349916263548!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a526617091d06ad%3A0x8b7dc16a2d87c425!2sWelcome%20Tours%20and%20Travels%20Chennai%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1651165577945!5m2!1sen!2sin" width="100%" height="582" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>



<?php include "footer.php" ?>












