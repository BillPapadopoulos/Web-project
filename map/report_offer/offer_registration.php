<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'web_database');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Capture form data
$product_id = mysqli_real_escape_string($conn, $_POST['product']);

// Get the product_name using product_id
$product_query = "SELECT product_name FROM product WHERE product_id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_name = $row['product_name'];
} else {
    die("Product not found");
}

$shop_id = mysqli_real_escape_string($conn, $_POST['shop']);
$price = mysqli_real_escape_string($conn, $_POST['price']);

// Retrieve the username from session
$user_username = mysqli_real_escape_string($conn, $_SESSION['user_name']);
echo "Username: " . $user_username;

// Set default values for likes, dislikes, register_date, etc.
$likes = 0;
$dislikes = 0;
$register_date = date('Y-m-d');

// Disable foreign key checks (use with caution)
mysqli_query($conn, "SET foreign_key_checks = 0");

// SQL to insert new data
$stmt = $conn->prepare("INSERT INTO offer (product_name, shop_id, user_username, price, likes, dislikes, register_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sisdiis", $product_name, $shop_id, $user_username, $price, $likes, $dislikes, $register_date);

if ($stmt->execute()) {
    mysqli_query($conn, "SET foreign_key_checks = 1"); // Re-enable foreign key checks
    header("Location: report_offer.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

mysqli_close($conn);
?>
