<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
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
    <!-- nav-bar -->
    <nav class="navbar">
     <!-- LOGO -->
     <div class="logo">ACS</div>
     <!-- NAVIGATION MENU -->
     <ul class="nav-links">
       <!-- USING CHECKBOX HACK -->
       <input type="checkbox" id="checkbox_toggle" />
       <label for="checkbox_toggle" class="hamburger">&#9776;</label>
       <!-- NAVIGATION MENUS -->
       <div class="menu">
         <li><a href="/index.php">Home</a></li>
         <li><a href="/">About</a></li>
         <li><a href="logout.php">Logout</a></li>
       </div>
     </ul>
   </nav>
   <!--  -->
   <!--Mask-->
   <div id="intro" class="view">

<div class="mask rgba-black-strong">
    <div class="container-fluid d-flex align-items-center justify-content-center h-100">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-md-10">
                <!-- Heading -->
                <h2 class="display-4 font-weight-bold white-text pt-5 mb-2">Welcome to this Prototype System</h2>
                <!-- Divider -->
                <hr class="hr-light">
            </div>
        </div>
    </div>
</div>

</div>
<!--/.Mask-->
   <!--  -->
   <main class="mt-5">
        <div class="container">

            <!--Section: Best Features-->
            <section id="best-features" class="text-center">

                <!-- Heading -->
                <h2 class="mb-5 font-weight-bold">Features of this prototype</h2>

                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-md-3 mb-1">
                        <i class="fa fa-lock fa-4x orange-text"></i>
                        <h4 class="my-4 font-weight-bold">Encrypted Password</h4>
                        <p class="grey-text">Passwod are encryoted for data protection</p>
                    </div>
                    <div class="col-md-3 mb-1">
                        <i class="fa fa-key fa-4x orange-text"></i>
                        <h4 class="my-4 font-weight-bold">Password Strength Indicator</h4>
                        <p class="grey-text">Allows user to set strong pasword through password policy guidance</p>
                    </div>
                    <!--Grid column-->
                    <!--Grid column-->
                    <div class="col-md-3 mb-5">
                        <i class="fa fa-unlock-alt fa-4x orange-text"></i>
                        <h4 class="my-4 font-weight-bold">Secured Login</h4>
                        <p class="grey-text">This sytem rovides hassle-free secured login</p>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-3 mb-1">
                        <i class="fa fa-robot fa-4x orange-text"></i>
                        <h4 class="my-4 font-weight-bold">Captcha Feature</h4>
                        <p class="grey-text">This system uses captcha feature for bot verification.</p>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </section>
    <!-- //form section end -->
    <!-- Reacptcha link -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Javascript Link -->
    <script src = "js/script.js" ></script>
</body>

</html>