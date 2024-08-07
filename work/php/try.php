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
            $updatecontent = '<li class="">
                                <a href="../app/create-profile.php" class="">
                                    <i class="las la-user"></i><span>Create Profile</span>
                                </a>';
        } else {
            // Profile already exists, set message
            $updatecontent = '<li class="">
                                <a href="../app/update.php" class="">
                                    <i class="las la-user"></i><span>Update Profile</span>
                                </a>';
        }
    } else {
        // Handle case where user_type is not found
        $updatecontent = 'User not found.';
    }
} catch (PDOException $e) {
    // Handle potential errors
    $updatecontent = "Error: " . $e->getMessage();
}
