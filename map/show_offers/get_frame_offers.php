<?php

// Mapping English category names to their corresponding Greek names.
$categoryMapping = [
  'Cleaning' => 'Καθαριότητα',
  'Drinks-Refreshments' => 'Ποτά - Αναψυκτικά',
  'Personal Care' => 'Προσωπική φροντίδα',
  'Food' => 'Τρόφιμα',
];

// Establish a connection with the database.
$connection = mysqli_connect('localhost', 'root', '', 'web_database');

// Check connection.
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_GET['category'])) {
  echo "Invalid category.";
  exit;
}

if ($_GET['category'] == 'All Categories') {
  $query = "SELECT o.*, s.shop_name FROM offer o
            JOIN shop s ON o.shop_id = s.shop_id";
} else {
  if (!isset($categoryMapping[$_GET['category']])) {
      echo "Invalid category.";
      exit;
  }
  $greekCategoryName = $categoryMapping[$_GET['category']];
  $query = "SELECT o.*, s.shop_name FROM offer o 
            JOIN product p ON o.product_name = p.product_name 
            JOIN shop s ON o.shop_id = s.shop_id
            WHERE p.category_name = ?";
}

$stmt = $connection->prepare($query);

if ($_GET['category'] != 'All Categories') {
  $stmt->bind_param("s", $greekCategoryName);
}

$stmt->execute();

$result = $stmt->get_result();

// Display the results.
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Offer ID</th>
            <th>Product Name</th>
            <th>Shop Name</th>
            <th>User</th>
            <th>Price</th>
            <th>Likes</th>
            <th>Dislikes</th>
            <th>Register Date</th>
            <th>Availability</th>
          </tr>";
          
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["offer_id"] . "</td>
                <td>" . $row["product_name"] . "</td>
                <td>" . $row["shop_name"] . "</td>
                <td>" . $row["user_username"] . "</td>
                <td>" . $row["price"] . "</td>
                <td id='like-count-" . $row["offer_id"] . "'>" . $row["likes"] . "</td>
                <td id='dislike-count-" . $row["offer_id"] . "'>" . $row["dislikes"] . "</td>
                <td>" . $row["register_date"] . "</td>
                <td>" . $row["availability"] . "</td>
                <td>
                  <button class='like-dislike-button' onclick='likeDislike(" . $row["offer_id"] . ", \"like\")'>👍</button>
                  <button class='like-dislike-button' onclick='likeDislike(" . $row["offer_id"] . ", \"dislike\")'>👎</button>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No offers available for this category.";
}

$stmt->close();
$connection->close();

?>
<style>
    .like-dislike-button {
        cursor: pointer;
        width: 20px; /* Adjust the size as needed */
        height: 20px; /* Adjust the size as needed */
        margin-right: 10px; /* Add spacing between the buttons */
        display: inline-block; /* Display buttons inline */
    }
</style>

<script>
  src = "offers.js"
</script>