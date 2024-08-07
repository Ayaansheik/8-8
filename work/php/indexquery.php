<?php
// Get the session user ID
$sessionUserId = $_SESSION['user_id'];

try {
   // Prepare and execute the query to get user_type
   $stmt = $connection->prepare("SELECT user_type FROM register WHERE user_id = ?");
   $stmt->execute([$sessionUserId]);
   $userType = $stmt->fetchColumn();

   // Initialize the variable to hold the HTML content
   $htmlContent = '';

   if ($userType) {
      // Prepare and execute the appropriate query based on user_type
      if ($userType === 'brand') {
         $stmt = $connection->prepare("SELECT 1 FROM brand_profile WHERE user_id = ?");
      } elseif ($userType === 'influencer') {
         $stmt = $connection->prepare("SELECT 1 FROM `create-creator-profile` WHERE user_id = ?");
      } else {
         throw new Exception("User type not recognized.");
      }

      $stmt->execute([$sessionUserId]);
      if (!$stmt->fetchColumn()) {
         // Profile does not exist, set HTML content
         $htmlContent = '<div class="card-header d-flex justify-content-center">
                                <div class="header-title">
                                    <h4 class="card-title">Congratulations! Now <a href="../app/create-profile.php">Create Profile</a> Page</h4>
                                </div>
                            </div>';
      } else {
         // Profile already exists, set message
         //  $htmlContent = 'You have already created your profile.';
      }
   } else {
      // Handle case where user_type is not found
      $htmlContent = 'User not found.';
   }
} catch (PDOException $e) {
   // Handle potential errors
   $htmlContent = "Error: " . $e->getMessage();
}

?>

<?php 


// Fetch brand data
$brandQuery = $connection->prepare('SELECT `brand_id`, `bg_img`, `logo_img`, `brand_name`, `category`, `register_date`, `location`, `user_name`, `user_email`, `user_phone`, `gender`, `brand_descr`, `fb_url`, `insta_url`, `youtube_url`, `website_url`, `user_id` FROM `brand_profile`');
$brandQuery->execute();
$brands = $brandQuery->fetchAll();

// Fetch creator data
$creatorQuery = $connection->prepare('SELECT `profile_id`, `profile_img`, `first_name`, `last_name`, `city`, `gender`, `marital_status`, `age`, `country`, `category`, `description`, `bg_img`, `fb_url`, `insta_url`, `youtube_url`, `website_url`, `user_id` FROM `create-creator-profile`');
$creatorQuery->execute();
$creators = $creatorQuery->fetchAll();

// Initialize an empty array to hold the merged data
$mergedData = [];

// Determine the larger of the two arrays to ensure all records are included
$maxLength = max(count($brands), count($creators));

for ($i = 0; $i < $maxLength; $i++) {
   if (isset($brands[$i])) {
      $mergedData[] = ['type' => 'brand', 'data' => $brands[$i]];
   }
   if (isset($creators[$i])) {
      $mergedData[] = ['type' => 'creator', 'data' => $creators[$i]];
   }
}

try {
 

   // Fetch top 2 brands
   $stmtBrands = $connection->prepare("SELECT `brand_name`, `category`, `logo_img` FROM `brand_profile` LIMIT 2");
   $stmtBrands->execute();
   $brands = $stmtBrands->fetchAll();

   // Fetch top 2 influencers
   $stmtInfluencers = $connection->prepare("SELECT `first_name`, `last_name`, `category`, `profile_img` FROM `create-creator-profile` LIMIT 2");
   $stmtInfluencers->execute();
   $influencers = $stmtInfluencers->fetchAll();

} catch (PDOException $e) {
   // Handle potential errors
   $error = "Error: " . $e->getMessage();
}
// $connection = null;
?>