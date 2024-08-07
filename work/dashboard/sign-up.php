<?php
require "../connection/connection.php";

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type']; // This will be either 'brand' or 'influencer'
    $status = "Pending";

    // Check if email already exists
    $stmt = $connection->prepare("SELECT COUNT(*) FROM register WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error_message = 'Email already exists. Please use a different email address.';
    } else {
        // Insert new user
        $stmt = $connection->prepare("INSERT INTO register (username, email, phone, category, address, password, user_type, status) VALUES (:username, :email, :phone, :category, :address, :password, :user_type, :status)");
        $stmt->bindParam(':username', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            // Redirect to the sign-in page after successful registration
            header('Location: sign-in.php');
            exit(); // Ensure script termination after redirection
        } else {
            $error_message = 'Failed to register user.';
        }
    }
}


$category_query = "SELECT * FROM `add_categories`";
$category_query_prepare = $connection->prepare($category_query);
$category_query_prepare->execute();
$add_vaccine = $category_query_prepare->fetchAll(PDO::FETCH_ASSOC);

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

                    <div class="col-md-6 bg-white pt-3 pb-lg-0 pb-3">
                        <h1 class="mb-0 mx-3">Sign Up</h1>
                        <p class="mx-3">Register Yourself to Access Influencer-Hub.</p>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-brand-tab" data-bs-toggle="tab" data-bs-target="#nav-brand" type="button" role="tab" aria-controls="nav-brand" aria-selected="true">Brand</button>
                                <button class="nav-link" id="nav-creator-tab" data-bs-toggle="tab" data-bs-target="#nav-creator" type="button" role="tab" aria`-controls="nav-creator" aria-selected="false">Creator</button>
                                <button class="nav-link" id="nav-creator-tab" data-bs-toggle="tab" data-bs-target="#nav-creator" type="button" role="tab" aria`-controls="nav-creator" aria-selected="false">admin</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-brand" role="tabpanel" aria-labelledby="nav-brand-tab">
                                <div class="sign-in-from">
                                    <form class="mt-3" action="sign-up.php" method="POST">
                                        <input type="hidden" name="user_type" value="brand">
                                        <div class="form-group">
                                            <label class="form-label" for="brand_name">Company Name</label>
                                            <input type="text" class="form-control mb-0" id="brand_name" name="name" pattern="^[a-zA-Z\s]{1,100}$" title="Company name should only contain letters and spaces, and be 1-100 characters long." required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="brand_email">Email address</label>
                                            <input type="email" class="form-control mb-0" id="brand_email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address." required>
                                            <?php if (!empty($error_message) && strpos($error_message, 'Email') !== false): ?>
                                                <small class="text-danger"><?php echo $error_message; ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label" for="brand_phone">Number</label>
                                                <input type="text" class="form-control" id="brand_phone" name="phone" pattern="^\d{10,15}$" title="Phone number should be between 10 to 15 digits." required>
                                            </div>
                                            <div class="col">
                                                <label class="form-label" for="brand_category">Category</label>
                                                
                                                
                                               
                                                <select class="form-select mb-3" id="brand_category" name="category" required>
                                                <?php foreach ($add_vaccine as $category) : ?>
                                                    <option value="<?= $category['category_id']?>"><?= $category['category_name'] ?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="brand_address">Address</label>
                                            <input type="text" class="form-control mb-0" id="brand_address" name="address" pattern="^[a-zA-Z0-9\s,.-]{1,200}$" title="Address can contain letters, numbers, spaces, and ,.- characters, and be 1-200 characters long." required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="brand_password">Password</label>
                                            <input type="password" class="form-control mb-0" id="brand_password" name="password" required>
                                        </div>
                                        <div class="d-inline-block w-100">
                                        <button type="submit" class="btn btn-primary float-end" name="register">Register</button>
                                        </div>
                                      
                                        <div class="sign-info">
                  <span class="dark-color d-inline-block line-height-2">Already have an account? <a href="sign-in.php">Sign in</a></span>
                  
                </div>

                                        
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-creator" role="tabpanel" aria-labelledby="nav-creator-tab">
                                <div class="sign-in-from">
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger mx-3"><?php echo $error_message; ?></div>
                                    <?php endif; ?>
                                    <form class="mt-3" action="sign-up.php" method="POST">
                                        <input type="hidden" name="user_type" value="influencer">
                                        <div class="form-group">
                                            <label class="form-label" for="creator_name">Name</label>
                                            <input type="text" class="form-control mb-0" id="creator_name" name="name" pattern="^[a-zA-Z\s]{1,100}$" title="Name should only contain letters and spaces, and be 1-100 characters long." required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="creator_email">Email address</label>
                                            <input type="email" class="form-control mb-0" id="creator_email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address." required>
                                            <?php if (!empty($error_message) && strpos($error_message, 'Email') !== false): ?>
                                                <small class="text-danger"><?php echo $error_message; ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label" for="creator_phone">Number</label>
                                                <input type="text" class="form-control" id="creator_phone" name="phone" pattern="^\d{10,15}$" title="Phone number should be between 10 to 15 digits." required>
                                            </div>
                                            <div class="col">
                                                <label class="form-label" for="creator_category">Category</label>
                                                <select class="form-select mb-3" id="creator_category" name="category" required>
                                                    <option value="">Choose Category</option>
                                                    <option value="Clothing">Clothing</option>
                                                    <option value="Electronics">Electronics</option>
                                                    <option value="Books">Books</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="creator_address">Address</label>
                                            <input type="text" class="form-control mb-0" id="creator_address" name="address" pattern="^[a-zA-Z0-9\s,.-]{1,200}$" title="Address can contain letters, numbers, spaces, and ,.- characters, and be 1-200 characters long." required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="creator_password">Password</label>
                                            <input type="password" class="form-control mb-0" id="creator_password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                                    </form>
                              
                                </div>
                            </div>


                            <div class="tab-pane fade" id="nav-creator" role="tabpanel" aria-labelledby="nav-creator-tab">
                                <div class="sign-in-from">
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger mx-3"><?php echo $error_message; ?></div>
                                    <?php endif; ?>
                                    <form class="mt-3" action="sign-up.php" method="POST">
                                        <input type="hidden" name="user_type" value="admin">
                                        <div class="form-group">
                                            <label class="form-label" for="creator_name">Name</label>
                                            <input type="text" class="form-control mb-0" id="creator_name" name="name" pattern="^[a-zA-Z\s]{1,100}$" title="Name should only contain letters and spaces, and be 1-100 characters long." required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="creator_email">Email address</label>
                                            <input type="email" class="form-control mb-0" id="creator_email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address." required>
                                            <?php if (!empty($error_message) && strpos($error_message, 'Email') !== false): ?>
                                                <small class="text-danger"><?php echo $error_message; ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label" for="creator_phone">Number</label>
                                                <input type="text" class="form-control" id="creator_phone" name="phone" pattern="^\d{10,15}$" title="Phone number should be between 10 to 15 digits." required>
                                            </div>
                                            <div class="col">
                                                <label class="form-label" for="creator_category">Category</label>
                                                <select class="form-select mb-3" id="creator_category" name="category" required>
                                                    <option value="">Choose Category</option>
                                                    <option value="Clothing">Clothing</option>
                                                    <option value="Electronics">Electronics</option>
                                                    <option value="Books">Books</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="creator_address">Address</label>
                                            <input type="text" class="form-control mb-0" id="creator_address" name="address" pattern="^[a-zA-Z0-9\s,.-]{1,200}$" title="Address can contain letters, numbers, spaces, and ,.- characters, and be 1-200 characters long." required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="creator_password">Password</label>
                                            <input type="password" class="form-control mb-0" id="creator_password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                                    </form>
                              
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="../assets/js/libs.min.js"></script>
    <script src="../assets/js/socialv.js?v=4.0.0"></script>
</body>
</html>
