<?php
$conn = new mysqli("localhost", "root", "", "web_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a page parameter in the URL like leaderboard.php?page=2
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //default page 1 
$offset = ($page - 1) * 10; // calculates the starting point for the SQL query based on the current page.

$stmt = $conn->prepare("
SELECT user_username, total_score, (total_tokens - premonth_tokens) as tokens_this_month, total_tokens
FROM user
ORDER BY total_score DESC
LIMIT 10 OFFSET ?");
$stmt->bind_param('i', $offset);
$stmt->execute();

$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    echo $row['user_username'] . " - Score: " . $row['total_score'] . " - Tokens this Month: " . $row['tokens_this_month'] . " - Total Tokens: " . $row['total_tokens'] . "<br>";
}

$stmt->close();
$conn->close();
?>
