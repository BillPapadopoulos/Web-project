<?php
$connection = mysqli_connect('localhost', 'root', '', 'web_database');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$categoryMapping = [
    'Cleaning' => 'Καθαριότητα',
    'Drinks-Refreshments' => 'Ποτά - Αναψυκτικά',
    'Personal Care' => 'Προσωπική φροντίδα',
    'Food' => 'Τρόφιμα',
];

$category = $_GET['category'];
$greekCategoryName = $categoryMapping[$category]; // Use the mapping you provided earlier

$query = "SELECT DISTINCT s.* 
          FROM shop s 
          JOIN offer o ON s.shop_id = o.shop_id 
          JOIN product p ON o.product_name = p.product_name 
          WHERE p.category_name = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $greekCategoryName);
$stmt->execute();

$result = $stmt->get_result();

$shops = [];
while ($row = $result->fetch_assoc()) {
    $shops[] = [
    'shop_id'=> $row['shop_id'],
    'name' => $row['shop_name'],
    'latitude' => $row['lat'], 
    'longitude' => $row['lon']
    ];
}
echo json_encode($shops);
$stmt->close();
$connection->close();
?>
