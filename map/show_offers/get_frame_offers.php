<?php

$categoryMapping = [
  'Cleaning' => 'Καθαριότητα',
  'Drinks-Refreshments' => 'Ποτά-Αναψυκτικά',
  'Personal Care' => 'Προσωπική φροντίδα',
  'Food' => 'Τρόφιμα',
];



if (!isset($_GET['category']) || !isset($categoryMapping[$_GET['category']])) {
  echo "Invalid category.";
  exit;
}

$englishCategoryName = $_GET['category'];
$greekCategoryName = $categoryMapping[$englishCategoryName];

$categoryName = $_GET['category'];

// Database connection
$connection = mysqli_connect('localhost', 'root', '', 'web_database');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Using JOIN to combine product and offer tables based on product_name and filter by category_name
$query = "SELECT o.* FROM offer o 
          JOIN product p ON o.product_name = p.product_name 
          WHERE p.category_name = ?";

echo "SQL Query: " . $query . "<br>";


// Prepare the SQL statement to prevent SQL injection
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $categoryName);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Offer ID</th>
            <th>Product Name</th>
            <th>Shop ID</th>
            <th>User</th>
            <th>Price</th>
            <th>Likes</th>
            <th>Dislikes</th>
            <th>Register Date</th>
            <th>Price Lower Than Preday</th>
            <th>Price Lower Than Preweek</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["offer_id"] . "</td>
                <td>" . $row["product_name"] . "</td>
                <td>" . $row["shop_id"] . "</td>
                <td>" . $row["user_username"] . "</td>
                <td>" . $row["price"] . "</td>
                <td>" . $row["likes"] . "</td>
                <td>" . $row["dislikes"] . "</td>
                <td>" . $row["register_date"] . "</td>
                <td>" . $row["price_lower_than_preday"] . "</td>
                <td>" . $row["price_lower_than_preweek"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No offers available for this category.";
}

$stmt->close();
$connection->close();

?>
