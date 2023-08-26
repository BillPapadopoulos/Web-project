<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'web_database');
?>

<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<html>
<title>Update Products</title>
<head>
  <link rel="stylesheet" href="/web_database/map/admin/adm.css">
</head>


<body>
  <!-- Εδώ ορίζουμε το menu bar της ιστοσελίδας, δηλώνοντας όλα τα πιθανά link - pages στο interface του χρήστη -->
  <div class="menu-bar">
  <ul class="Starter Buttons">
     <li><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li class="pressed"><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li><a href=#>LeaderBoard</a></li>
     <li><a href="/web_database/map/admin/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>

  <div class="file-upload">
  <form action="update_products.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
  </form>
</div>


</body>
</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/"; // Φάκελος στον οποίο θα αποθηκευθούν τα αρχεία
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Ελέγχουμε αν το αρχείο έχει επέκταση .sql
    if ($fileType != "json") {
        echo '<div class="error-message">Sorry, only JSON files are allowed.</div>';
        $uploadOk = 0;
    }
    
    // Εάν όλα είναι εντάξει, ανεβάζουμε το αρχείο
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo '<div class="success-message">The file ' . basename($_FILES["fileToUpload"]["name"]) . ' has been successfully uploaded.</div>';
            // Εδώ μπορείτε να προχωρήσετε στην εκτέλεση του SQL αρχείου στη βάση δεδομένων
        } else {
            echo '<div class="error-message">Sorry, there was an error uploading your file.</div>';
        }
    }
    
    /* Ανάλυση του αρχείου Products_final.json
    $productsJson = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
    $productsData = json_decode($productsJson, true);

    // Ανάλυση του αρχείου Prices_final.json
    $pricesJson = file_get_contents("Prices_final.json");
    $pricesData = json_decode($pricesJson, true);

    if ($productsData && $pricesData) {
        // Σύνδεση με τη βάση δεδομένων
        $conn = mysqli_connect('localhost', 'root', '', 'web_database');
        
        foreach ($productsData as $product) {
            // Ελέγχουμε αν το προϊόν υπάρχει ήδη στη βάση
            $productId = $product['id'];
            $productName = $product['name'];
            $productExistsQuery = "SELECT product_id FROM product WHERE product_id = $productId";
            // Εκτελούμε το query και ελέγχουμε το αποτέλεσμα

            if ($productExists) {
                // Ενημέρωση των τιμών για το προϊόν
                foreach ($pricesData as $priceEntry) {
                  if ($priceEntry['name'] === $productName) {
                      $priceDate = $priceEntry['prices'][0]['date']; // Προσαρμόστε τη λογική για το date
                      $newPrice = $priceEntry['prices'][0]['price']; // Προσαρμόστε τη λογική για την τιμή
      
                      $updatePriceQuery = "UPDATE price_variety SET price = $newPrice WHERE product_id = $productId AND price_date = '$priceDate'";
                      // Εκτελούμε το query για την ενημέρωση της τιμής στη βάση
                  }
              }
            } else {
                // Προσθήκη του νέου προϊόντος στη βάση
                // Καθώς και των τιμών από το Prices_final.json
            }
        }
    } else {
        echo '<div class="error-message">Invalid JSON format for Products or Prices.</div>';
    }*/
}
?>

