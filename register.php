
<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';
    // Connecting with databse
    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        // Duplicate email verificastion
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
        } 
        else 
        {
            // Captcha verification
            // Google reCAPTCHA API keys settings 
            $secretKey  = '6Le6SqIgAAAAACwj8-z1Wwu7KjJePR_dHD_Tpsqi'; 
            // Email settings 
            $recipientEmail = 'suraj@ismt.edu.np'; 
            $postData = $statusMsg = ''; 
            $status = 'error';

            // Validate reCAPTCHA checkbox 
            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
     
                // Verify the reCAPTCHA API response 
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
                 
                // Decode JSON data of API response 
                $responseData = json_decode($verifyResponse); 
                 
                // If the reCAPTCHA API response is valid 
                if($responseData->success){ 
                // Password verificsation from database
                    if ($password === $confirm_password) {
                        $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
                        $result = mysqli_query($conn, $sql);

                        // Creating Email verification link
                        if ($result) 
                        {
                            echo "<div style='display: none;'>";
                            //Create an instance; passing `true` enables exceptions
                            $mail = new PHPMailer(true);

                            try {
                                    //Server settings
                                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                    $mail->isSMTP();                                            //Send using SMTP
                                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                    $mail->Username   = 'suraj@ismt.edu.np';                     //SMTP username
                                    $mail->Password   = 'Pokharel@123';                               //SMTP password
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                                    //Recipients
                                    $mail->setFrom('suraj@ismt.edu.np');
                                    $mail->addAddress($email); //Add a recipient

                                    //Content
                                    $mail->isHTML(true);  //Set email format to HTML
                                    $mail->Subject = 'no-reply';
                                    $mail->Body    = 'Please find your verification link below</b><a href="http://localhost/login/?verification='.$code.'">http://localhost/login/?verification='.$code.'</a>';
                                    $mail->send();
                                    echo 'Message has been sent';
                                } 
                                catch (Exception $e) 
                                {
                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                }
                            echo "</div>";
                            $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
                        }

                        else 
                        {
                            $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                        }

                    } 
                    else 
                    {
                        // Error message if user donot provide correct password twice
                        $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
                    }
                }
                else
                { 
                    // Error message if resposnseData in not verified
                    $msg = "<div class='alert alert-danger'>Robot Verification Failed</div>";
                } 
            }
            else
            { 
                // Error message if user tries to register without robot verification.
                $msg = "<div class='alert alert-danger'>Please check recaptcha box</div>";
            } 

        }
    }

?>



<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form - ACS</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"content="Login Form" />
    <!-- //Meta tag Keywords -->

    <!-- Links -->
    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome Link-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"rel="stylesheet"/>
    <!--CSS Style sheet -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!--Font Awesome Link -->
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <!-- //Liinks -->

</head>

<body>

    <!-- form section start -->
    <section class="form-register">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="form-box align-self">
                        <div class="left_grid_info">
                            <img src="images/signUp2.jpg" alt="">
                        </div>
                    </div>
                    <div class="content-box">
                        <h2>Register Now</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" id="myInput" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="password" class="password" name="password" id="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <!-- Password Strength Indicator -->
                            <span id="StrengthDisp" class="badge displayBadge">Weak</span>
                            <!-- Password strength Indicator Text -->
                            <div class="password_criterian_wrapper remove ps-2 text-muted">
                                <ul type="none">                       
                                <li class="criteria length_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Use more than 8 characters</li></span>
                                <li class="criteria lowercase_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Lowercase Characters (i.e. a-z)</li></span>
                                <li class="criteria uppercase_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Uppercase Characters (i.e. A-Z)</li></span>
                                <li class="criteria number_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Numbers (i.e. 0-9)</li></span>
                                <li class="criteria symbol_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Symbols (eg @#$%)</li></span>
                                </ul>
                            </div>
                            <!-- Google ReCaptcha V2-->
                            <div class="g-recaptcha" data-sitekey="6Le6SqIgAAAAACMRUlQ-k7TtlAb58TXQot06sWwg"></div>
                            <button name="submit" id="btnRegister" class="btn" type="submit">Register</button>
                        </form>
                        <div class="Link-text">
                            <p>Already have an account?</p>
                            <a href="index.php">Login</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section end -->
    <!-- Reacptcha link -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Javascript Link -->
    <script src = "js/script.js" ></script>
</body>

</html>