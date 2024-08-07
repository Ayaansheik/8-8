<?php
require "../connection/connection.php";
?>

<?php  
    // Check if the user is a brand
    $query = "SELECT * FROM `register-brands` WHERE email = :email";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the user is not found in the brands table, check in the creators table
    if (!$user) {
        $query = "SELECT * FROM `register-creator` WHERE email = :email";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

if(isset($_POST['continue']))
{
  $email = $_SESSION['email'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];

  $new_hash_password = password_hash($password,PASSWORD_BCRYPT);
if($password === $confirmpassword)
{
  $forgot_password_query = "UPDATE `register-brands` SET `password`= :password WHERE email = :email";
  $forgot_password_prepare = $connection->prepare($forgot_password_query);
  $forgot_password_prepare->bindParam(':password',$new_hash_password);
  $forgot_password_prepare->bindParam(':email',$email);
  if ($forgot_password_prepare->execute()) {
    // Password updated successfully
    header('location:login.php');
} else {
    // Database error occurred
    echo "Database Error: " . implode(":", $forgot_password_prepare->errorInfo());
}

}else{
  echo "<script>alert('Kindly enter correct confirm password')</script>";
}
}


if(isset($_POST['continue']))
{
  $email = $_SESSION['email'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];

  $new_hash_password = password_hash($password,PASSWORD_BCRYPT);
if($password === $confirmpassword)
{
  $forgot_password_query = "UPDATE `register-creator` SET `password`= :password WHERE email = :email";
  $forgot_password_prepare = $connection->prepare($forgot_password_query);
  $forgot_password_prepare->bindParam(':password',$new_hash_password);
  $forgot_password_prepare->bindParam(':email',$email);
  if ($forgot_password_prepare->execute()) {
    // Password updated successfully
    header('location:login.php');
} else {
    // Database error occurred
    echo "Database Error: " . implode(":", $forgot_password_prepare->errorInfo());
}

}else{
  echo "<script>alert('Kindly enter correct confirm password')</script>";
}
}

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
  <body class=" ">
    <!-- loader Start -->
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>
    <!-- loader END -->
    
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
                            <div class="sign-slider overflow-hidden ">
                                <ul class="swiper-wrapper list-inline m-0 p-0 ">
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
                            <h1 class="mb-0">Reset Password</h1>
                            <p>Enter your New Password.</p>
                            <form class="mt-4">
                                <div class="form-group">
                                    <label class="form-label" for="exampleInputEmail1">New Password</label>
                                    <input type="password" class="form-control mb-0" name="password" id="exampleInputEmail1" placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="exampleInputEmail1">Confirm Password</label>
                                    <input type="password" class="form-control mb-0" name="confirmpassword" id="exampleInputEmail1" placeholder="Confirm Password">
                                </div>
                                <div class="d-inline-block w-100">
                                   <button type="submit" class="btn btn-primary float-right" name="continue">Confirm</button>
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