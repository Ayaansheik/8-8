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

if ($fetch_data['user_type'] !== 'admin') {
    header("Location: ../dashboard/index.php");
    exit();
}

// Fetch all approved users
$query = "SELECT * FROM `register` WHERE status = 'Approved'";
$stmt = $connection->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle account deletion
if (isset($_GET['delid'])) {
    $userId = $_GET['delid'];
    $deleteQuery = "DELETE FROM register WHERE user_id = :id";
    $deleteStmt = $connection->prepare($deleteQuery);
    $deleteStmt->execute([':id' => $userId]);
    header('location:alluserdata.php');
    exit();
}
?>
<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .card-text {
        font-size: 0.875rem;
        color: #333;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .d-flex img {
        border: 2px solid #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                <i class="ri-arrow-right-line side-right-icon"><span class="ms-3 d-inline-block">Close Menu</span></i>
            </div>
        </div>
    </div>
</div>
</div>
<div id="content-page" class="content-page">
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-center">User Management</h3>
                    <div>
                        <button id="tableViewBtn" class="btn btn-primary">Table View</button>
                        <button id="cardViewBtn" class="btn btn-secondary">Card View</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div id="tableView" class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if (empty($users)) : ?>
                                <p class="text-center">No data available</p>
                            <?php else : ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Category</th>
                                            <th>Address</th>
                                            <th>User Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td><?= $user['user_id'] ?></td>
                                                <td><?= $user['username'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td><?= $user['phone'] ?></td>
                                                <td><?= $user['category'] ?></td>
                                                <td><?= $user['address'] ?></td>
                                                <td><?= $user['user_type'] ?></td>
                                                <td>
                                                    <button class="btn btn-outline-danger" onclick="confirmDelete(<?= $user['user_id'] ?>)">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="cardView" class="row" style="display:none;">
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $user) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="../assets/images/user/<?= $user['user_id'] ?>.jpg" class="rounded-circle" style="width: 60px; height: 60px;" alt="<?= $user['username'] ?>">
                                    <div class="ms-3">
                                        <h5 class="card-title mb-0"><?= $user['username'] ?></h5>
                                        <p class="text-muted mb-0"><?= $user['user_type'] ?></p>
                                    </div>
                                </div>
                                <p class="card-text mb-3">
                                    <strong>Email:</strong> <?= $user['email'] ?><br>
                                    <strong>Phone:</strong> <?= $user['phone'] ?><br>
                                    <strong>Category:</strong> <?= $user['category'] ?><br>
                                    <strong>Address:</strong> <?= $user['address'] ?>
                                </p>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-danger" onclick="confirmDelete(<?= $user['user_id'] ?>)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">No data available</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- </div> -->
<!-- Wrapper End-->
<footer class="iq-footer bg-white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="../dashboard/privacy-policy.html">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="../dashboard/terms-of-service.html">Terms of Use</a></li>
                </ul>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                Copyright 2020 <a href="#">SocialV</a> All Rights Reserved.
            </div>
        </div>
    </div>
</footer> <!-- Backend Bundle JavaScript -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
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
<script>
    // Function to open delete confirmation modal
    function confirmDelete(userId) {
        // Set the delete button's href attribute to include the user ID
        document.getElementById('confirmDeleteButton').href = 'alluserdata.php?delid=' + userId;
        // Show the modal
        $('#deleteConfirmationModal').modal('show');
    }

    // Toggle between table and card view
    document.getElementById('tableViewBtn').addEventListener('click', function() {
        document.getElementById('tableView').style.display = 'block';
        document.getElementById('cardView').style.display = 'none';
    });

    document.getElementById('cardViewBtn').addEventListener('click', function() {
        document.getElementById('tableView').style.display = 'none';
        document.getElementById('cardView').style.display = 'block';
    });

    // Function to open delete confirmation modal
    function confirmDelete(userId) {
        // Set the delete button's href attribute to include the user ID
        document.getElementById('confirmDeleteButton').href = 'alluserdata.php?delid=' + userId;
        // Show the modal
        $('#deleteConfirmationModal').modal('show');
    }
</script>
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