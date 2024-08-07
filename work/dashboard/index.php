<?php
require "../header/nav.php";
// Check if the user is not signed in
if (!isset($_SESSION['user_id'])) {
   header('Location: sign-in.php');
   exit();
}




$sql = "SELECT ac.category_name 
        FROM add_categories ac
        JOIN brand_profile bp ON ac.category_id = bp.category
        WHERE ac.category_id = :category";

$stmt = $connection->prepare($sql);
$stmt->execute(['category' => 4  ]);
$results = $stmt->fetchAll();

require_once "../php/indexquery.php";
?>


<style>
   .filter-container {
      margin-bottom: 20px;
   }

   .card-block {
      padding: 20px;
   }

   #cardsContainer .card {
      margin-bottom: 15px;
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
         <div class="col-lg-8 row m-0 p-0">
            <div class="col-sm-12">
               <div class="card card-block card-stretch card-height">
                  <?php echo $htmlContent; ?>

                  <?php foreach ($results as $row) : ?>
                     <tr>
                        <td><?php echo ($row['category_name']); ?></td>
                     </tr>
                  <?php endforeach; ?>
                  <!-- show value here -->
                  <div class="card-body">
                     <div class="filter-container d-flex justify-content-between align-items-center">
                        <select id="categoryFilter" class="form-select">
                           <option class="p-2" value="">Select Category</option>
                           <option class="p-2" value="category1">Brand</option>
                           <option value="category3">Influencer</option>
                        </select>
                        <button id="filterButton" class="btn btn-primary">Filter</button>
                     </div>
                     <div id="cardsContainer" class="mt-3">
                        <!-- Cards will be appended here -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- sahdla -->
            <?php if (empty($mergedData)) : ?>
               <p class="text-center">No data available</p>
            <?php else : ?>
               <?php foreach ($mergedData as $item) : ?>
                  <div class="col-sm-12">
                     <div class="card card-block card-stretch card-height">
                        <div class="mb-0">
                           <div class="top-bg-image">
                              <?php if ($item['type'] === 'brand') : ?>
                                 <img src="../app/uploads/<?php echo ($item['data']['bg_img']); ?>" class="img-fluid w-100" alt="group-bg">
                              <?php else : ?>
                                 <img src="../app/uploads/<?php echo ($item['data']['bg_img']); ?>" class="img-fluid w-100" alt="group-bg">
                              <?php endif; ?>
                           </div>
                           <div class="card-body text-center">
                              <div class="group-icon">
                                 <?php if ($item['type'] === 'brand') : ?>
                                    <img src="../app/uploads/<?php echo ($item['data']['logo_img']); ?>" alt="profile-img" class="rounded-circle img-fluid avatar-120">
                                 <?php else : ?>
                                    <img src="../app/uploads/<?php echo ($item['data']['profile_img']); ?>" alt="profile-img" class="rounded-circle img-fluid avatar-120">
                                 <?php endif; ?>
                              </div>
                              <div class="group-info pt-3 pb-3">
                                 <?php if ($item['type'] === 'brand') : ?>
                                    <h4><a href="../app/group-detail.html"><?php echo ($item['data']['brand_name']); ?></a></h4>
                                    <p><?php echo ($item['data']['category']); ?></p>
                                 <?php else : ?>
                                    <h4><a href="../app/group-detail.html"><?php echo ($item['data']['first_name'] . ' ' . $item['data']['last_name']); ?></a></h4>
                                    <p><?php echo ($item['data']['category']); ?></p>
                                 <?php endif; ?>
                              </div>
                              <div class="group-details d-inline-block pb-3">
                                 <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                    <li class="pe-3 ps-3">
                                       <p class="mb-0">Post</p>
                                       <h6>300</h6>
                                    </li>
                                    <li class="pe-3 ps-3">
                                       <p class="mb-0">Member</p>
                                       <h6>210</h6>
                                    </li>
                                    <li class="pe-3 ps-3">
                                       <p class="mb-0">Visit</p>
                                       <h6>1.1k</h6>
                                    </li>
                                 </ul>
                                 <div class="social-links m-3">
                                    <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                                       <li class="text-center pe-3">
                                          <a href="<?php echo ($item['data']['fb_url']); ?>" target="_blank"><img src="../assets/images/icon/08.png" class="img-fluid rounded" alt="facebook"></a>
                                       </li>
                                       <li class="text-center pe-3">
                                          <a href="<?php echo ($item['data']['website_url']); ?>" target="_blank"><img src="../assets/images/icon/09.png" class="img-fluid rounded" alt="Twitter"></a>
                                       </li>
                                       <li class="text-center pe-3">
                                          <a href="<?php echo ($item['data']['insta_url']); ?>" target="_blank"><img src="../assets/images/icon/10.png" class="img-fluid rounded" alt="Instagram"></a>
                                       </li>
                                       <li class="text-center pe-3">
                                          <a href="<?php echo ($item['data']['youtube_url']); ?>" target="_blank"><img src="../assets/images/icon/12.png" class="img-fluid rounded" alt="Youtube"></a>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <button type="submit" class="btn btn-primary d-block w-100">Visit</button>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php endif; ?>

         </div>

         <!-- HTML Output -->
         <div class="col-lg-4">
            <!-- Brands Card -->
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Top Brands</h4>
                  </div>
               </div>
               <div class="card-body">
                  <ul class="suggested-page-story m-0 p-0 list-inline">
                     <?php foreach ($brands as $brand) : ?>
                        <li class="">
                           <div class="d-flex align-items-center mb-3">
                              <img src="../assets/images/page-img/42.png" alt="story-img" class="rounded-circle img-fluid avatar-50">
                              <div class="stories-data ms-3">
                                 <h5><?php echo htmlspecialchars($brand['brand_name']); ?></h5>
                                 <p class="mb-0"><?php echo htmlspecialchars($brand['category']); ?></p>
                              </div>
                           </div>
                           <img src="../app/uploads/<?php echo htmlspecialchars($brand['logo_img']); ?>" class="img-fluid rounded" alt="Brand Logo">
                        </li>
                     <?php endforeach; ?>
                  </ul>
               </div>
            </div>

            <!-- Influencers Card -->
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Top Influencers</h4>
                  </div>
               </div>
               <div class="card-body">
                  <ul class="suggested-page-story m-0 p-0 list-inline">
                     <?php foreach ($influencers as $influencer) : ?>
                        <li class="">
                           <div class="d-flex align-items-center mb-3">
                              <img src="../assets/images/page-img/42.png" alt="story-img" class="rounded-circle img-fluid avatar-50">
                              <div class="stories-data ms-3">
                                 <h5><?php echo htmlspecialchars($influencer['first_name']) . ' ' . htmlspecialchars($influencer['last_name']); ?></h5>
                                 <p class="mb-0"><?php echo htmlspecialchars($influencer['category']); ?></p>
                              </div>
                           </div>
                           <img src="../app/uploads/<?php echo htmlspecialchars($influencer['profile_img']); ?>" class="img-fluid rounded" alt="Influencer Image">
                        </li>
                     <?php endforeach; ?>
                  </ul>
               </div>
            </div>
         </div>

         <!-- <div class="col-sm-12 text-center">
            <img src="../assets/images/page-img/page-load-loader.gif" alt="loader" style="height: 100px;">
         </div> -->
      </div>
   </div>
</div>
<!-- Wrapper End-->
<?php
require "../header/footer.php"
?>
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