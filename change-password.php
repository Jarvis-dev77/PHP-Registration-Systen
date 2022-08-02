<?php

$msg = "";

include 'config.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

            if ($password === $confirm_password) {
                $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    header("Location: index.php");
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
    }
} else {
    header("Location: forgot-password.php");
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
                            <img src="images/password.jpg" alt="">
                        </div>
                    </div>
                    <div class="content-box">
                        <h2>Change Password</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="password" class="password" name="password" id="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <!-- Strength Indicator -->
                            <span id="StrengthDisp" class="badge displayBadge">Weak</span>
                            <!-- Indicator Text -->
                            <div class="password_criterian_wrapper remove ps-2 text-muted">
                                <ul type="none">                       
                                <li class="criteria length_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Use more than 8 characters</li></span>
                                <li class="criteria lowercase_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Lowercase Characters (i.e. a-z)</li></span>
                                <li class="criteria uppercase_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Uppercase Characters (i.e. A-Z)</li></span>
                                <li class="criteria number_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Numbers (i.e. 0-9)</li></span>
                                <li class="criteria symbol_criteria"><span class="icon_wrapper me-3"><i class="fa-solid fa-circle-xmark text-danger"></i></span><span>Include Symbols (eg @#$%)</li></span>
                                </ul>
                            </div>
                            <!-- Captcha -->
                            <div class="g-recaptcha" data-sitekey="6Le6SqIgAAAAACMRUlQ-k7TtlAb58TXQot06sWwg"></div>
                            <button name="submit" id="btnRegister" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="Link-text">
                            <p>Back to! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script src = "js/script.js" ></script>

</body>

</html>