<?php
require "../header/nav.php";

// Check if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}

// Fetch user data
$fetch_query = "SELECT user_type FROM `register` WHERE user_id = :user_id";
$fetch_prepare = $connection->prepare($fetch_query);
$fetch_prepare->bindParam(":user_id", $_SESSION['user_id']);
$fetch_prepare->execute();
$fetch_data = $fetch_prepare->fetch(PDO::FETCH_ASSOC);

if ($fetch_data['user_type'] !== 'brand') {
    header("Location: ../dashboard/index.php");
    exit();
}


// Check if the profile exists
if ($fetch_data['user_type'] == 'brand') {
    $profile_query = "SELECT * FROM `brand_profile` WHERE user_id = :user_id";
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
// Fetch brand profile information
try {
    $fetch_query = "SELECT * FROM `brand_profile` WHERE user_id = :user_id";
    $fetch_prepare = $connection->prepare($fetch_query);
    $fetch_prepare->bindParam(":user_id", $_SESSION['user_id']);
    $fetch_prepare->execute();
    $brandProfile = $fetch_prepare->fetch(PDO::FETCH_ASSOC);

    if (!$brandProfile) {
        echo "Brand profile not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

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
                $insert_query = "INSERT INTO `images` (`image_path`, `user_id`,`likes`) VALUES (:image_path, :user_id, :likes)";
                $insert_prepare = $connection->prepare($insert_query);
                $insert_prepare->bindParam(':image_path', $file_name);
                $insert_prepare->bindParam(':user_id', $brandProfile['brand_id']);
                $insert_prepare->bindParam(':likes', $likes);
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
    $fetch_query_img = "SELECT images.*, brand_profile.brand_name FROM `images` 
                        JOIN `brand_profile` ON images.user_id = brand_profile.brand_id";
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
</div> <!-- Page Content  -->
<div class="header-for-bg">
    <div class="background-header position-relative">
        <img src="../app/uploads/<?php echo htmlspecialchars($brandProfile['bg_img']); ?>" alt="Profile Image" class=" img-fluid img-rounded" alt="header-bg" style="width: 100%; height: 50vh; object-fit: cover;">

    </div>
</div>
<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                    <div class="group-info d-flex align-items-center">
                        <div class="me-3">
                            <img class="rounded-circle img-fluid avatar-130" src="../app/uploads/<?php echo htmlspecialchars($brandProfile['logo_img']); ?>" alt="Profile Image"style="object-fit:cover;" >
                        </div>
                        <div class="info">
                            <h4><?php echo htmlspecialchars($brandProfile['brand_name']); ?></h4>
                            <p class="mb-0"><?php echo htmlspecialchars($brandProfile['category']); ?></p>
                        </div>
                    </div>
                    <div class="group-member d-flex align-items-center mt-md-0 mt-2">
                        <div class="iq-media-group me-3">
                            <div class="social-links">
                                <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                                    <li class="text-center pe-3">
                                        <a href="#"><img src="../assets/images/icon/08.png" class="img-fluid rounded" alt="Facebook"></a>
                                    </li>
                                    <li class="text-center pe-3">
                                        <a href="#"><img src="../assets/images/icon/09.png" class="img-fluid rounded" alt="Twitter"></a>
                                    </li>
                                    <li class="text-center pe-3">
                                        <a href="#"><img src="../assets/images/icon/10.png" class="img-fluid rounded" alt="Instagram"></a>
                                    </li>
                                    <li class="text-center pe-3">
                                        <a href="#"><img src="../assets/images/icon/12.png" class="img-fluid rounded" alt="YouTube"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2"><i class="ri-add-line me-1"></i>Request</button>
                        <a href="update.php?brand_id=<?php echo $_SESSION['user_id']; ?>" class="btn btn-primary m-2">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div id="post-modal-data" class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <form method="post" action="brand-profile.php" enctype="multipart/form-data">
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
                                                        <a href="brand-profile.php" class=""><?php echo htmlspecialchars($fetch_img['brand_name']); ?></a>
                                                    </h5>
                                                    <p class="mb-0">8 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-post">
                                    <a href="../app/uploads/<?php echo htmlspecialchars($fetch_img['image_path']); ?>">
                                        <img src="../app/uploads/<?php echo htmlspecialchars($fetch_img['image_path']); ?>" alt="Post Image" class="img-fluid" style="object-fit:cover;width: 100%; height: 70vh;" />
                                    </a>
                                </div>
                                <div class="comment-area mt-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="like-block position-relative d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="like-data">
                                                    <form method="post" action="brand-profile.php">
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">About</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-inline p-0 m-0">
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="ri-map-pin-fill h4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Location</h6>
                                        <p class="mb-0"><?php echo ($brandProfile['location']); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="ri-bookmark-fill h4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Registered Date</h6>
                                        <p class="mb-0"><?php echo ($brandProfile['register_date']); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="ri-group-fill h4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Brand Info</h6>
                                        <p class="mb-0"><?php echo ($brandProfile['brand_descr']); ?></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- !-- Backend Bundle JavaScript --> 
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