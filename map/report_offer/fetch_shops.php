<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost','root','', 'web_database');

$query = "SELECT shop_id, shop_name FROM shop";  
$result = $conn->query($query);
$shops = [];

while($row = $result->fetch_assoc()) {
    $shops[] = $row;
}

echo json_encode($shops);
?>
