<?php
session_start(); 

$offerId = $_POST['offerId'];
$action = $_POST['action'];

$connection = mysqli_connect('localhost', 'root', '', 'web_database');
if (!$connection) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . mysqli_connect_error()]));
}

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$query = "SELECT user_id FROM user WHERE user_username = ?"; // Assuming your users table is named 'users'
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

// Check if the user has already taken an action on this offer
$query = "SELECT action FROM user_like_dislike WHERE user_id = ? AND offer_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ii", $userId, $offerId);
$stmt->execute();
$stmt->bind_result($previousAction);
$hasPreviousAction = $stmt->fetch();
$stmt->close();

// Handle the action based on the previous state
if ($hasPreviousAction) {
    if ($previousAction == $action) {
        // User clicked the same action again (undoing their action)
    $query = ($action == 'like') ? "UPDATE offer SET likes = likes - 1 WHERE offer_id = ?" : "UPDATE offer SET dislikes = dislikes - 1 WHERE offer_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $offerId);
    $stmt->execute();
    $stmt->close();

    // Delete the record for the user's action
    $deleteQuery = "DELETE FROM user_like_dislike WHERE user_id = ? AND offer_id = ?";
    $deleteStmt = $connection->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $userId, $offerId);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Get the new like/dislike count
    $query = "SELECT likes, dislikes FROM offer WHERE offer_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $offerId);
    $stmt->execute();
    $stmt->bind_result($likesCount, $dislikesCount);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(['success' => true, 'likesCount' => $likesCount, 'dislikesCount' => $dislikesCount]);
    exit;
    } else {
        // User is changing their action (e.g., from like to dislike)
        $query = "UPDATE offer 
                SET likes = IF(action = 'like', likes - 1, likes + 1), 
                dislikes = IF(action = 'dislike', dislikes - 1, dislikes + 1) 
                WHERE offer_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $offerId);
        $stmt->execute();
        $stmt->close();

        // Update the record for the user's action
        $updateActionQuery = "UPDATE user_like_dislike SET action = ? WHERE user_id = ? AND offer_id = ?";
        $updateStmt = $connection->prepare($updateActionQuery);
        $updateStmt->bind_param("sii", $action, $userId, $offerId);
        $updateStmt->execute();
        $updateStmt->close();

        
    }
} else {
    // User is taking an action for the first time
    $query = ($action == 'like') ? "UPDATE offer SET likes = likes + 1 WHERE offer_id = ?" : "UPDATE offer SET dislikes = dislikes + 1 WHERE offer_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $offerId);
    $stmt->execute();
    $stmt->close();

    // Insert a record for the user's action
    $insertQuery = "INSERT INTO user_like_dislike (user_id, offer_id, action) VALUES (?, ?, ?)";
    $insertStmt = $connection->prepare($insertQuery);
    $insertStmt->bind_param("iis", $userId, $offerId, $action);
    $insertStmt->execute();
    $insertStmt->close();
}

// Get the new like/dislike count
$query = "SELECT likes, dislikes FROM offer WHERE offer_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $offerId);
$stmt->execute();
$stmt->bind_result($likesCount, $dislikesCount);
$stmt->fetch();
$stmt->close();

echo json_encode(['success' => true, 'likesCount' => $likesCount, 'dislikesCount' => $dislikesCount]);

?>