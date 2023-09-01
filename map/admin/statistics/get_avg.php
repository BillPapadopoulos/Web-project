<?php
if (isset($_GET['subcategory_id'])) {
    $subcategory_id = $_GET['subcategory_id'];

    // Include your database connection code here
    $conn = mysqli_connect('localhost', 'root', '', 'web_database');

    // Fetch the average price data from the database
    $query = "SELECT DAY(price_date) as day, AVG(price) as average_price
              FROM price_variety
              WHERE price_variety.subcat_id = $subcategory_id
              GROUP BY day";
              
    $result = mysqli_query($conn, $query);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
