<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'web_database');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "SET foreign_key_checks = 0");

// SQL to delete all rows from product table
$delete_query = "DELETE FROM product";
if (mysqli_query($conn, $delete_query)) {
    echo "All records deleted successfully.";
} else {
    echo "Error deleting records: " . mysqli_error($conn);
}

// Re-enable foreign key checks
mysqli_query($conn, "SET foreign_key_checks = 1");

mysqli_close($conn);
?>