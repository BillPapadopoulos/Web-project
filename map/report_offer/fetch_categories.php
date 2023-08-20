<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost', 'root', '', 'web_database');

$query = "SELECT category_id, category_name FROM category";
$result = $conn->query($query);
$categories = [];

while($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
?>
