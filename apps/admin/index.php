<!DOCTYPE html>
<html lang="en">

<?php
// Check if the user already exists in tbl_user
$mysqli = new mysqli("localhost", "root", "", "db_gizi");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <meta name="google-signin-client_id" content="<?= $clientId ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

</head>
<style>
    body {
        width: 100%;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    #wave-container {
        position: relative;
        height: 100px;
        width: 100%;
    }

    #wave {
        width: 100%;
        height: 100%;
        fill: #5a8ee1;
    }

    #login-container {
        text-align: center;
        margin-top: 50px;
        padding: 20px;
        width: 100%;

        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .google-login-button {
        background-color: #5a8ee1;
        color: #fff;
        border: none;
        width: 100%;
        font-size: 16pt;
        border-radius: 5px;
    }
</style>
</head>

<body>
    <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center  ">
                <span>GiziDukasi</span>
            </a>
            <nav id="navbar" class="navbar">

            </nav>

        </div>
    </header><!-- End Header -->
    <div id="wave-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0099ff" fill-opacity="1" d="M0,128L24,160C48,192,96,256,144,282.7C192,309,240,299,288,288C336,277,384,267,432,245.3C480,224,528,192,576,165.3C624,139,672,117,720,133.3C768,149,816,203,864,202.7C912,203,960,149,1008,128C1056,107,1104,117,1152,128C1200,139,1248,149,1296,154.7C1344,160,1392,160,1416,160L1440,160L1440,0L1416,0C1392,0,1344,0,1296,0C1248,0,1200,0,1152,0C1104,0,1056,0,1008,0C960,0,912,0,864,0C816,0,768,0,720,0C672,0,624,0,576,0C528,0,480,0,432,0C384,0,336,0,288,0C240,0,192,0,144,0C96,0,48,0,24,0L0,0Z"></path>
        </svg>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div id="login-container">
                    <h1>Login Admin</h1>
                    <form action='auth.php' method="POST">
                        <div class="form-group">
                            <label>Username</label>
                            <input type='text' name='username' class='form-control'>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type='password' name='password' class='form-control'>
                        </div>
                        <div class="form-group">

                            <input type='submit' name='login' value='Login Admin' class='btn btn-success ml-auto'>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
</body>

</html>