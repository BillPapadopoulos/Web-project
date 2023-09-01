<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost','root','', 'web_database');

if(isset($_GET['category_id'])) {
    $category_id = (int)($_GET['category_id']);

    $query = "SELECT subcategory_id, subcategory_name FROM subcategory WHERE category_id = $category_id";
    $result = $conn->query($query);
    $subcategories = [];

    while($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    echo json_encode($subcategories);
}
?>
