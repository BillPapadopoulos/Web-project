<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost','root','', 'web_database');

if(isset($_GET['subcategory_id'])) {
    $subcategory_id = intval($_GET['subcategory_id']);

    $query = "SELECT product_id, product_name FROM product WHERE subcategory_id = $subcategory_id";
    $result = $conn->query($query);
    $products = [];

    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}
?>
