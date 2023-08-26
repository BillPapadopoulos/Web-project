<?php
session_start();

// Connect to the database.
$connection = mysqli_connect('localhost', 'root', '', 'web_database');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_GET['offer_id'])) {
    echo "Invalid offer ID.";
    exit;
}

$offer_id = $_GET['offer_id'];

$query = "DELETE FROM offer WHERE offer_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $offer_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "failure";
}

$stmt->close();
$connection->close();
?>
