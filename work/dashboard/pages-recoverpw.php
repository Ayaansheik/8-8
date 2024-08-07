
<?php
require "../connection/connection.php";
?>
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $randomOTP = rand(1111, 9999);

    // Flag to indicate if the email was found
    $emailFound = false;

    foreach ($user as $users) {
        if ($users['email'] === $email) {
            $emailFound = true;
            break;
        }
    }

    if ($emailFound) {
     //Create an instance; passing `true` enables exceptions
     $mail = new PHPMailer(true);

     try {
         //Server settings
         $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
         $mail->isSMTP(); //Send using SMTP
         $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
         $mail->SMTPAuth = true; //Enable SMTP authentication
         $mail->Username = 'syedajaweriajamil@gmail.com'; //SMTP username
         $mail->Password = 'cmfa kkkv ycpc isua'; //SMTP password
         $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
         $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

         //Recipients
         $mail->setFrom('syedajaweriajamil@gmail.com', 'Influencers Hub');
         $mail->addAddress($email, 'Influencers Hub'); //Add a recipient
         // $mail->addAddress('ellen@example.com');               //Name is optional
         $mail->addReplyTo($email, 'Information');
         // $mail->addCC('cc@example.com');
         // $mail->addBCC('bcc@example.com');

         //Attachments
         // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
         // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

         //Content
         $mail->isHTML(true); //Set email format to HTML
         $mail->Subject = 'OTP for Registration for Influencers Hub';
         $mail->Body = "To verify, please enter the verification code: <b>$randomOTP</b> <p>Kindly do not share your OTP with anyone else once you are done with the registration.</p>";
         // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

         $mail->send();
         echo 'Message has been sent';
     } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
     }
        $_SESSION['user_otp'] = $randomOTP;
        $_SESSION['email'] = $email;
        header('location:forget-password.php');
    } else {
        echo "<script>alert('Kindly Enter the same Email as your Account')</script>";
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
                            <p>Enter your email address and we'll send you an email with instructions to reset your password.</p>
                            <form class="mt-4">
                                <div class="form-group">
                                    <label class="form-label" for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control mb-0" name="email" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="d-inline-block w-100">
                                   <button type="submit" class="btn btn-primary float-right" name="reset">Reset Password</button>
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