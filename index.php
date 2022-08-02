<?php
    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    include 'config.php';
    $msg = "";

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
            }
        } else {
            header("Location: index.php");
        }
    }


    if (isset($_POST['submit'])) {
        // Captcha verification
        // Google reCAPTCHA API keys settings 
        $secretKey  = '6Le6SqIgAAAAACwj8-z1Wwu7KjJePR_dHD_Tpsqi';  
        // Email settings 
        $recipientEmail = 'suraj@ismt.edu.np'; 
        $postData = $statusMsg = ''; 
        $status = 'error';
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);;
        // Validate reCAPTCHA checkbox 
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
        
            // Verify the reCAPTCHA API response 
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
            
            // Decode JSON data of API response 
            $responseData = json_decode($verifyResponse); 
            
            // If the reCAPTCHA API response is valid 
            if($responseData->success)
            {                 
        
                if (mysqli_num_rows($result) === 1) 
                    {
                        $row = mysqli_fetch_assoc($result);

                        if (empty($row['code'])) 
                        {
                            $_SESSION['SESSION_EMAIL'] = $email;
                            mysqli_query($conn,"delete from loginlogs where ipAddress='$ip_address'");
                            header("Location: welcome.php");
                        } 
                        else 
                        {
                            $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
                        }
                    } 
                    else{
                        $msg="<div class='alert alert-info'>First enter valid login details</div>";
                        
                    }
            } 
            else
            { 
                $msg = "<div class='alert alert-danger'>Robot Verification Failed</div>"; 
            }    
    
        }
        else
        { 
            $msg = "<div class='alert alert-danger'>Please check recaptcha box</div>"; 
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
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"rel="stylesheet"/>
    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
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
                            <img src="images/loginImg.jpg" alt="">
                        </div>
                    </div>
                    <div class="content-box">
                        <h2>Login Now</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                            <!-- Captcha -->
                            <div class="g-recaptcha" data-sitekey="6Le6SqIgAAAAACMRUlQ-k7TtlAb58TXQot06sWwg"></div>
                            <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>
                        <div class="Link-text">
                            <p>Don't have an account?</p>
                            <a href="register.php">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src = "js/script.js" ></script>
</body>

</html>