<?php
require "../header/nav.php";


$fetch_query = "SELECT * FROM `brand_profile`";
$fetch_prepare = $connection->prepare($fetch_query);
$fetch_prepare->execute();
$brandProfiles = $fetch_prepare->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows


$category_query = "SELECT * FROM `add_categories`";
$category_query_prepare = $connection->prepare($category_query);
$category_query_prepare->execute();
$add_vaccine = $category_query_prepare->fetchAll(PDO::FETCH_ASSOC);

?>


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
        <img src="../assets/images/page-img/profile-bg7.jpg" class="img-fluid w-100" alt="header-bg">
        <div class="title-on-header">
            <div class="data-block">
                <h2>All Brands</h2>
            </div>
        </div>
    </div>
</div>
<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container">
        <div class="col-sm-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="filter-container d-flex justify-content-between align-items-center">
                        <select id="categoryFilter" class="form-select">
                            <?php foreach ($add_vaccine as $category) : ?>
                                <option value="<?= $category['category_id']?>"><?= $category['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button id="filterButton" class="btn btn-primary">Filter</button>
                    </div>
                    <div id="cardsContainer" class="mt-3">
                        <!-- Cards will be appended here -->
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid gap-3 d-grid-template-1fr-19">                   
            <div class="row">
                <?php foreach ($brandProfiles as $data) { ?>
                    <div class="card mb-0">
                        <div class="top-bg-image">
                            <img src="../app/uploads/<?php echo htmlspecialchars($data['bg_img']); ?>" class="img-fluid w-auto hight-auto" alt="group-bg" >
                        </div>
                        <div class="card-body text-center">
                            <div class="group-icon">
                            <img src="../app/uploads/<?php echo htmlspecialchars($data['logo_img']); ?>"  alt="profile-img" class="rounded-circle img-fluid avatar-120">
                            </div>
                            <div class="group-info pt-3 pb-3">
                                <h4><a href="../app/group-detail.html"><?php echo htmlspecialchars($data['brand_name']); ?></a></h4>
                                <p><?php echo htmlspecialchars($data['category']); ?></p>
                            </div>
                            <div class="group-details d-inline-block pb-3">
                                <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Post</p>
                                        <h6>30</h6>
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Member</p>
                                        <h6>30</h6>
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Visit</p>
                                        <h6>50</h6>
                                    </li>
                                </ul>
                            </div>
                            <div class="group-member mb-3">
                                <div class="iq-media-group">
                                    <!-- Add appropriate images and links for group members if needed -->
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary d-block w-100">Join</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
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
</footer>
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
<!-- offcanvas start -->
<div class="offcanvas offcanvas-bottom share-offcanvas" tabindex="-1" id="share-btn" aria-labelledby="shareBottomLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="shareBottomLabel">Share</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="d-flex flex-wrap align-items-center">
            <!-- Add social media sharing buttons as needed -->
        </div>
    </div>
</div>
</body>
</html>