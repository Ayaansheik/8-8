<?php
session_start();
require "../connection/connection.php";

// Redirect to index.php if user is already logged in
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    if (empty($email) || empty($password)) {
      $error_message = 'Please fill in both fields';
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
      $error_message = 'Invalid email format';
    } else {
      // Fetch the user data only after the POST request is made
      $query = "SELECT * FROM register WHERE user_type = admin";
      $stmt = $connection->prepare($query);
      $stmt->bindParam(':user_type', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }}

      ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SocialV | Responsive Bootstrap 4 Admin Dashboard Template</title>

  <link rel="shortcut icon" href="../assets/images/favicon.ico" />
  <link rel="stylesheet" href="../assets/css/libs.min.css">
  <link rel="stylesheet" href="../assets/css/socialv.css?v=4.0.0">
  <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/vendor/remixicon/fonts/remixicon.css">
  <link rel="stylesheet" href="../assets/vendor/vanillajs-datepicker/dist/css/datepicker.min.css">
  <link rel="stylesheet" href="../assets/vendor/font-awesome-line-awesome/css/all.min.css">
  <link rel="stylesheet" href="../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
</head>

<body>
  <div id="loading">
    <div id="loading-center"></div>
  </div>

  <div class="wrapper">
    <section class="sign-in-page">
      <div id="container-inside">
        <div id="circle-small"></div>
        <div id="circle-medium"></div>
        <div id="circle-large"></div>
        <div id="circle-xlarge"></div>
        <div id="circle-xxlarge"></div>
      </div>
      <div class="container p-0">
        <div class="row no-gutters">
          <div class="col-md-6 text-center pt-5">
            <div class="sign-in-detail text-white">
              <a class="sign-in-logo mb-5" href="#"><img src="../assets/images/logo-full.png" class="img-fluid" alt="logo"></a>
              <div class="sign-slider overflow-hidden">
                <ul class="swiper-wrapper list-inline m-0 p-0">
                  <li class="swiper-slide">
                    <img src="../assets/images/login/1.png" class="img-fluid mb-4" alt="logo">
                    <h4 class="mb-1 text-white">Find new friends</h4>
                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                  </li>
                  <li class="swiper-slide">
                    <img src="../assets/images/login/2.png" class="img-fluid mb-4" alt="logo">
                    <h4 class="mb-1 text-white">Connect with the world</h4>
                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                  </li>
                  <li class="swiper-slide">
                    <img src="../assets/images/login/3.png" class="img-fluid mb-4" alt="logo">
                    <h4 class="mb-1 text-white">Create new events</h4>
                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
            <div class="sign-in-from">
              <h1 class="mb-0">Admin Login</h1>
              <p>Enter your email address and password to access admin panel.</p>
              <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
              <?php endif; ?>
              <form class="mt-4" action="sign-in.php" method="POST">
                <div class="form-group">
                  <label class="form-label" for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control mb-0" id="exampleInputEmail1" name="email" placeholder="Enter email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address.">
                </div>
                <div class="form-group">
                  <label class="form-label" for="exampleInputPassword1">Password</label>
                  <a href="pages-recoverpw.php" class="float-end">Forgot password?</a>
                  <input type="password" class="form-control mb-0" id="exampleInputPassword1" name="password" placeholder="Password" required>
                </div>
                <div class="d-inline-block w-100">
                  
                  <button type="submit" class="btn btn-primary float-end">Sign in</button>
                </div>
               
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Backend Bundle JavaScript -->
  <script src="../assets/js/libs.min.js"></script>
  <!-- slider JavaScript -->
  <script src="../assets/js/slider.js"></script>
  <!-- masonry JavaScript -->
  <script src="../assets/js/masonry.pkgd.min.js"></script>
  <!-- SweetAlert JavaScript -->
  <script src="../assets/js/enchanter.js"></script>
  <!-- SweetAlert JavaScript -->
  <script src="../assets/js/sweetalert.js"></script>
  <!-- app JavaScript -->
  <script src="../assets/js/charts/weather-chart.js"></script>
  <script src="../assets/js/app.js"></script>
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>
  <script src="../assets/js/lottie.js"></script>
</body>

</html>