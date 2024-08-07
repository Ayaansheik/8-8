<?php
require "../header/nav.php";

// Check if the user is not signed in
if (!isset($_SESSION['user_id'])) {
   header('Location: sign-in.php');
   exit();
};

/// Fetch user data
$fetch_query = "SELECT user_type FROM `register` WHERE user_id = :user_id";
$fetch_prepare = $connection->prepare($fetch_query);
$fetch_prepare->bindParam(":user_id", $_SESSION['user_id']);
$fetch_prepare->execute();
$fetch_data = $fetch_prepare->fetch(PDO::FETCH_ASSOC);

if ($fetch_data['user_type'] !== 'influencer') {
    header("Location: ../dashboard/index.php");
    exit();
}



// Check if the profile exists
if ($fetch_data['user_type'] == 'influencer') {
    $profile_query = "SELECT * FROM `create-creator-profile` WHERE user_id = :user_id";
    $profile_prepare = $connection->prepare($profile_query);
    $profile_prepare->bindParam(":user_id", $_SESSION['user_id']);
    $profile_prepare->execute();
    if (!$profile_prepare->fetch(PDO::FETCH_ASSOC)) {
        header("Location: create-profile.php");
        exit();
    }
} else {
    header("Location: ../dashboard/index.php");
    exit();
}

$fetch_query = "SELECT * FROM `create-creator-profile` WHERE user_id = :user_id";
$fetch_prepare = $connection->prepare($fetch_query);
$fetch_prepare->bindParam(":user_id", $_SESSION['user_id']);
$fetch_prepare->execute();
$influencerProfile = $fetch_prepare->fetch(PDO::FETCH_ASSOC);

// Handle file upload
if (isset($_POST['upload'])) {
   if (isset($_FILES['uploadPhoto']) && $_FILES['uploadPhoto']['error'] === UPLOAD_ERR_OK) {
       $upload_dir = "../app/uploads/";

       if (!file_exists($upload_dir)) {
           mkdir($upload_dir, 0755, true);
       }

       $file_name = basename($_FILES['uploadPhoto']['name']);
       $file_tmp = $_FILES['uploadPhoto']['tmp_name'];
       $file_path = $upload_dir . $file_name;

       if (move_uploaded_file($file_tmp, $file_path)) {
           try {
               $insert_query = "INSERT INTO `images` (`image_path`, `user_id`) VALUES (:image_path, :user_id)";
               $insert_prepare = $connection->prepare($insert_query);
               $insert_prepare->bindParam(':image_path', $file_name);
               $insert_prepare->bindParam(':user_id', $influencerProfile['profile_id']);
               $insert_prepare->execute();

               echo "File uploaded successfully.";
           } catch (PDOException $e) {
               echo "Error: " . $e->getMessage();
           }
       } else {
           echo "File upload failed.";
       }
   }
}
// Handle like button click
if (isset($_POST['like'])) {
   $image_id = $_POST['image_id'];
   try {
      $update_query = "UPDATE images SET likes = likes + 1 WHERE image_id = :image_id";
      $update_prepare = $connection->prepare($update_query);
      $update_prepare->bindParam(':image_id', $image_id);
      $update_prepare->execute();
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit();
   } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
   }
}

// Fetch all images
try {
   $fetch_query_img = "SELECT images.*, `create-creator-profile`.first_name FROM images 
                       JOIN `create-creator-profile` ON images.user_id = `create-creator-profile`.profile_id";
   $fetch_prepare_img = $connection->prepare($fetch_query_img);
   $fetch_prepare_img->execute();
   $images = $fetch_prepare_img->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}

?>

<style>
   .upload-btn {
      background-color: #f0f4ff;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      cursor: pointer;
      display: flex;
      align-items: center;
      font-size: 16px;
      color: #333;
   }

   .upload-btn img {
      margin-right: 10px;
   }

   .upload-btn:hover {
      background-color: #dbe2ff;
   }
</style>


<div class="right-sidebar-panel p-0">
   <div class="card shadow-none">
      <div class="card-body p-0">
         <div class="media-height p-3" data-scrollbar="init">
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/01.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Anna Sthesia</h6>
                  <p class="mb-0">Just Now</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/02.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Paul Molive</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/03.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Anna Mull</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/04.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Paige Turner</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/11.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Bob Frapples</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/02.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Barb Ackue</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-online">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/03.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Greta Life</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-away">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/12.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Ira Membrit</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center mb-4">
               <div class="iq-profile-avatar status-away">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/01.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Pete Sariya</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
            <div class="d-flex align-items-center">
               <div class="iq-profile-avatar">
                  <img class="rounded-circle avatar-50" src="../assets/images/user/02.jpg" alt="">
               </div>
               <div class="ms-3">
                  <h6 class="mb-0">Monty Carlo</h6>
                  <p class="mb-0">Admin</p>
               </div>
            </div>
         </div>
         <div class="right-sidebar-toggle bg-primary text-white mt-3">
            <i class="ri-arrow-left-line side-left-icon"></i>
            <i class="ri-arrow-right-line side-right-icon"><span class="ms-3 d-inline-block">Close
                  Menu</span></i>
         </div>
      </div>
   </div>
</div>
</div>
<div id="content-page" class="content-page">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-body profile-page p-0">
                  <div class="profile-header">
                     <div class="position-relative">
                        <img src="../app/uploads/<?php echo htmlspecialchars($influencerProfile['bg_img']); ?>" class=" img-fluid"  style="width: 1000px; height:500px;">
                     </div>
                     <div class="user-detail text-center mb-3">
                        <div class="profile-img">
                           <img src="../app/uploads/<?php echo htmlspecialchars($influencerProfile['profile_img']); ?>" class="rounded-circle img-fluid avatar-120" />
                        </div>
                        <div class="profile-detail">
                           <h3 class=""><?php echo htmlspecialchars($influencerProfile['first_name']); ?></h3>
                        </div>
                     </div>
                     <div class="profile-info p-3 d-flex align-items-center justify-content-between position-relative">
                        <div class="social-links">
                           <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                              <li class="text-center pe-3">
                                 <a href="<?php echo ($influencerProfile['fb_url']); ?>" target="_blank"><img src="../assets/images/icon/08.png" class="img-fluid rounded" alt="facebook"></a>
                              </li>
                              <li class="text-center pe-3">
                                 <a href="<?php echo ($influencerProfile['website_url']); ?>" target="_blank"><img src="../assets/images/icon/09.png" class="img-fluid rounded" alt="Twitter"></a>
                              </li>
                              <li class="text-center pe-3">
                                 <a href="<?php echo ($influencerProfile['insta_url']); ?>" target="_blank"><img src="../assets/images/icon/10.png" class="img-fluid rounded" alt="Instagram"></a>
                              </li>
                              <li class="text-center pe-3">
                                 <a href="<?php echo ($influencerProfile['youtube_url']); ?>" target="_blank"><img src="../assets/images/icon/12.png" class="img-fluid rounded" alt="Youtube"></a>
                              </li>

                           </ul>
                        </div>
                        <div class="social-info">
                           <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                              <li class="text-center ps-3">
                                 <h6>Posts</h6>
                                 <p class="mb-0">69</p>
                              </li>

                           </ul>
                           <button type="submit" class="btn btn-primary mb-2"><i class="ri-add-line me-1"></i>Request</button>
                              <a href="update.php?=<?php echo $_SESSION['user_id']; ?>" class="btn btn-primary m-2">Edit Profile</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-body p-0">
                  <div class="user-tabing">
                     <ul class="nav nav-pills d-flex align-items-center justify-content-center profile-feed-items p-0 m-0">
                        <li class="nav-item col-12 col-sm-3 p-0">
                           <a class="nav-link active" href="#pills-timeline-tab" data-bs-toggle="pill" data-bs-target="#timeline" role="button">Timeline</a>
                        </li>
                        <li class="nav-item col-12 col-sm-3 p-0">
                           <a class="nav-link" href="#pills-about-tab" data-bs-toggle="pill" data-bs-target="#about" role="button">About</a>
                        </li>
                        <li class="nav-item col-12 col-sm-3 p-0">
                           <a class="nav-link" href="#pills-pricing-tab" data-bs-toggle="pill" data-bs-target="#pricing" role="button">Pricing</a>
                        </li>

                        <li class="nav-item col-12 col-sm-3 p-0">
                           <a class="nav-link" href="#pills-photos-tab" data-bs-toggle="pill" data-bs-target="#photos" role="button">Photos</a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-sm-12">
            <div class="tab-content">
               <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                  <div class="card-body p-0">
                     <div class="row">
                        <div class="col-lg-4">
                           <div class="card">
                              <div class="card-body">
                                 <a href="#"><span class="badge badge-pill bg-primary font-weight-normal ms-auto me-1"><i class="ri-star-line"></i></span> 27 Items for yoou</a>
                              </div>
                           </div>
                           <div class="card">
                              <div class="card-header d-flex justify-content-between">
                                 <div class="header-title">
                                    <h4 class="card-title">Photos</h4>
                                 </div>
                                 <div class="card-header-toolbar d-flex align-items-center">
                                    <p class="m-0"><a href="javacsript:void();">Add Photo </a></p>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <ul class="profile-img-gallary p-0 m-0 list-unstyled">
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g1.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g2.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g3.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g4.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g5.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g6.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g7.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g8.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                    <li class=""><a href="#"><img src="../assets/images/page-img/g9.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                 </ul>
                              </div>
                           </div>

                        </div>
                        <div class="col-lg-8">
                <div id="post-modal-data" class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <form method="post" action="profile.php" enctype="multipart/form-data">
                                <label for="background_img" class="form-label h4">Upload Photo</label>
                                <input type="file" class="form-control" id="background_img" name="uploadPhoto">
                        </div>
                        <button type="submit" class="btn btn-primary" name="upload">
                            Upload
                        </button>

                        </form>
                    </div>
                </div>
                <?php foreach ($images as $fetch_img) : ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="post-item">
                                <div class="user-post-data py-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="me-3">
                                            <img class="rounded-circle img-fluid" src="../assets/images/user/04.jpg" alt="User Image">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <div class="">
                                                    <h5 class="mb-0 d-inline-block">
                                                        <a href="profile.php" class=""><?php echo ($fetch_img['first_name']); ?></a>
                                                    </h5>
                                                    <p class="mb-0">8 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-post">
                                    <a href="../app/uploads/<?php echo htmlspecialchars($fetch_img['image_path']); ?>">
                                        <img src="../app/uploads/<?php echo htmlspecialchars($fetch_img['image_path']); ?>" alt="Post Image" class="img-fluid w-100" />
                                    </a>
                                </div>
                                <div class="comment-area mt-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="like-block position-relative d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="like-data">
                                                    <form method="post" action="profile.php">
                                                        <input type="hidden" name="image_id" value="<?php echo $fetch_img['image_id']; ?>">
                                                        <button type="submit" name="like" class="btn btn-link p-0">
                                                            <img src="../assets/images/icon/01.png" class="img-fluid" alt="Like Icon">
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="total-like-block ms-2 me-3">
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" role="button">
                                                            <?php echo htmlspecialchars($fetch_img['likes']); ?> Likes
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">
                                            <a href="javascript:void();" data-bs-toggle="offcanvas" data-bs-target="#share-btn" aria-controls="share-btn">
                                                <i class="ri-share-line"></i>
                                                <span class="ms-1">Share</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="about" role="tabpanel">
                  <div class="card">
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-3">
                              <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                                 <li>
                                    <a class="nav-link active" href="#v-pills-basicinfo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-basicinfo-tab" role="button">Contact and Basic
                                       Info</a>
                                 </li>

                                 <!-- <li>
                                          <a class="nav-link" href="#v-pills-work-tab" data-bs-toggle="pill"
                                             data-bs-target="#v-pills-work-tab" role="button">Work and Education</a>
                                       </li>
                                       <li>
                                          <a class="nav-link" href="#v-pills-lived-tab" data-bs-toggle="pill"
                                             data-bs-target="#v-pills-lived-tab" role="button">Places You've Lived</a>
                                       </li> -->
                                 <li>
                                    <a class="nav-link" href="#v-pills-details-tab" data-bs-toggle="pill" data-bs-target="#v-pills-details-tab" role="button">Details About You</a>
                                 </li>
                              </ul>
                           </div>
                           <div class="col-md-9 ps-4">
                              <div class="tab-content">
                                 <div class="tab-pane fade active show" id="v-pills-basicinfo-tab" role="tabpanel" aria-labelledby="v-pills-basicinfo-tab">

                                    <h4 class="mt-3">Social Media Handles</h4>
                                    <hr>
                                    <div class="row">
                                       <div class="col-3">
                                          <h6>Facebook</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0"><a href="<?php echo ($influencerProfile['fb_url']); ?>" target="_blank"><?php echo htmlspecialchars($influencerProfile['fb_url']); ?></a></p>
                                       </div>
                                       <div class="col-3">
                                          <h6>Instagram</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0"><a href="<?php echo htmlspecialchars($influencerProfile['insta_url']); ?>" target="_blank"><?php echo htmlspecialchars($influencerProfile['insta_url']); ?></a></p>
                                       </div>
                                       <div class="col-3">
                                          <h6>Youtube</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0"><a href="<?php echo htmlspecialchars($influencerProfile['youtube_url']); ?>" target="_blank"><?php echo htmlspecialchars($influencerProfile['youtube_url']); ?></a></p>
                                       </div>
                                       <div class="col-3">
                                          <h6>Twitter</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0"><a href="<?php echo htmlspecialchars($influencerProfile['website_url']); ?>" target="_blank"><?php echo htmlspecialchars($influencerProfile['website_url']); ?></a></p>
                                       </div>
                                    </div>

                                 </div>

                                 <div class="tab-pane fade" id="v-pills-details-tab" role="tabpanel" aria-labelledby="v-pills-details-tab">
                                    <h4 class="mb-3">About You</h4>
                                    <p><?php echo ($influencerProfile['description']); ?></p>
                                    <h4 class="mt-3">Basic Information</h4>
                                    <hr>
                                    <div class="row">


                                       <div class="col-3">
                                          <h6>Gender</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0"><?php echo htmlspecialchars($influencerProfile['gender']); ?></p>
                                       </div>
                                       <div class="col-3">
                                          <h6>interested in</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0">Designing</p>
                                       </div>
                                       <div class="col-3">
                                          <h6>language</h6>
                                       </div>
                                       <div class="col-9">
                                          <p class="mb-0">English, French</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="pricing" role="tabpanel">
                  <div id="content-page" class="content-page">
                     <div class="container">
                        <div class="row  ">
                           <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="card">
                                 <div class="card-body border text-center rounded">
                                    <span class="text-uppercase">Basic</span>
                                    <div class="d-flex align-items-center justify-content-center">
                                       <h2 class="mb-4 display-3">$26</h2>
                                       <small class=" text-muted">/ Month</small>
                                    </div>
                                    <ul class="list-unstyled line-height-4 mb-0">
                                       <li>Lorem ipsum dolor sit amet</li>
                                       <li>Consectetur adipiscing elit</li>
                                       <li>Integer molestie lorem at massa</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="card bg-primary text-white">
                                 <div class="card-body border text-center rounded">
                                    <span class="text-uppercase">Basic</span>
                                    <div class="d-flex align-items-center justify-content-center">
                                       <h2 class="mb-4 display-3 text-white">$99</h2>
                                       <small class="text-white-50">/ Month</small>
                                    </div>
                                    <ul class="list-unstyled line-height-4 mb-0 ">
                                       <li>Lorem ipsum dolor sit amet</li>
                                       <li>Consectetur adipiscing elit</li>
                                       <li>Integer molestie lorem at massa</li>
                                    </ul>
                                    <a href="#" class="btn btn-light text-dark btn-block mt-5">Start Starter</a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="card">
                                 <div class="card-body border text-center rounded">
                                    <span class="text-uppercase">Basic</span>
                                    <div class="d-flex align-items-center justify-content-center">
                                       <h2 class="mb-4 display-3">$39</h2>
                                       <small class=" text-muted">/ Month</small>
                                    </div>
                                    <ul class="list-unstyled line-height-4 mb-0">
                                       <li>Lorem ipsum dolor sit amet</li>
                                       <li>Consectetur adipiscing elit</li>
                                       <li>Integer molestie lorem at massa</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="card">
                                 <div class="card-body border text-center rounded">
                                    <span class="text-uppercase">Basic</span>
                                    <div class="d-flex align-items-center justify-content-center">
                                       <h2 class="mb-4 display-3">$25</h2>
                                       <small class=" text-muted">/ Month</small>
                                    </div>
                                    <ul class="list-unstyled line-height-4 mb-0">
                                       <li>Lorem ipsum dolor sit amet</li>
                                       <li>Consectetur adipiscing elit</li>
                                       <li>Integer molestie lorem at massa</li>
                                    </ul>
                                    <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                                 </div>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="photos" role="tabpanel">
                  <div class="card">
                     <div class="card-body">
                        <h2>Photos</h2>
                        <div class="friend-list-tab mt-2">
                           <ul class="nav nav-pills d-flex align-items-center justify-content-left friend-list-items p-0 mb-2">
                              <li>
                                 <a class="nav-link active" data-bs-toggle="pill" href="#pill-photosofyou" data-bs-target="#photosofyou">Photos of You</a>
                              </li>
                              <li>
                                 <a class="nav-link" data-bs-toggle="pill" href="#pill-your-photos" data-bs-target="#your-photos">Your Photos</a>
                              </li>
                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane fade active show" id="photosofyou" role="tabpanel">
                                 <div class="card-body p-0">
                                    <div class="d-grid gap-2 d-grid-template-1fr-13">
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/../assets/images/page-img/51.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/52.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/53.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/54.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/55.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/56.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/57.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/58.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/59.jpg" class="img-fluid rounded" alt="image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/60.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/61.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/62.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/63.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/64.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/65.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/51.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/52.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/53.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/54.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/55.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/56.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/57.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/58.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/59.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="your-photos" role="tabpanel">
                                 <div class="card-body p-0">
                                    <div class="d-grid gap-2 d-grid-template-1fr-13 ">
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/51.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/52.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/53.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/54.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/55.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/56.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/57.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/58.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/59.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                       <div class="">
                                          <div class="user-images position-relative overflow-hidden">
                                             <a href="#">
                                                <img src="../assets/images/page-img/60.jpg" class="img-fluid rounded" alt="Responsive image">
                                             </a>
                                             <div class="image-hover-data">
                                                <div class="product-elements-icon">
                                                   <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                      <li><a href="#" class="pe-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                      <li><a href="#" class="pe-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                   </ul>
                                                </div>
                                             </div>
                                             <a href="#" class="image-edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-sm-12 text-center">
            <img src="../assets/images/page-img/page-load-loader.gif" alt="loader" style="height: 100px;">
         </div>
      </div>
   </div>
</div>
</div>
<!-- Wrapper End-->
<?php
require "../header/footer.php"
?> <!-- Backend Bundle JavaScript -->
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


<!-- offcanvas start -->

<div class="offcanvas offcanvas-bottom share-offcanvas" tabindex="-1" id="share-btn" aria-labelledby="shareBottomLabel">
   <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="shareBottomLabel">Share</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
   </div>
   <div class="offcanvas-body small">
      <div class="d-flex flex-wrap align-items-center">
         <div class="text-center me-3 mb-3">
            <img src="../assets/images/icon/08.png" class="img-fluid rounded mb-2" alt="">
            <h6>Facebook</h6>
         </div>
         <div class="text-center me-3 mb-3">
            <img src="../assets/images/icon/09.png" class="img-fluid rounded mb-2" alt="">
            <h6>Twitter</h6>
         </div>
         <div class="text-center me-3 mb-3">
            <img src="../assets/images/icon/10.png" class="img-fluid rounded mb-2" alt="">
            <h6>Instagram</h6>
         </div>
         <div class="text-center me-3 mb-3">
            <img src="../assets/images/icon/11.png" class="img-fluid rounded mb-2" alt="">
            <h6>Google Plus</h6>
         </div>
         <div class="text-center me-3 mb-3">
            <img src="../assets/images/icon/13.png" class="img-fluid rounded mb-2" alt="">
            <h6>In</h6>
         </div>
         <div class="text-center me-3 mb-3">
            <img src="../assets/images/icon/12.png" class="img-fluid rounded mb-2" alt="">
            <h6>YouTube</h6>
         </div>
      </div>
   </div>
</div>
</body>

</html>