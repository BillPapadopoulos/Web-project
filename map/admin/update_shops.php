<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'web_database');
?>

<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<html>
<title>Update Shops</title>
<head>
  <link rel="stylesheet" href="/web_database/map/admin/adm.css">
</head>


<body>
  <!-- Εδώ ορίζουμε το menu bar της ιστοσελίδας, δηλώνοντας όλα τα πιθανά link - pages στο interface του χρήστη -->
  <div class="menu-bar">
  <ul class="Starter Buttons">
     <li><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li class="pressed"><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li><a href="/web_database/map/admin/leaderboard/leaderboard.php">Leaderboard</a></li>
     <li><a href="/web_database/map/admin/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>

  <div class="file-upload">
  <form action="update_shops.php" method="post" enctype="multipart/form-data">
    <div class="header">
      <h2><b>Upload your .json file to insert new shops data<b></h2>
    </div>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit" class="button-style">
  </form>
</div>

<div class="or">
<h2><b>or<b><h2>
</div>

<div class="delete-bar">
    <button id="deleteDataButton" class="button-style">Delete All Shop Data</button>
</div>

<script>
     document.getElementById("deleteDataButton").addEventListener("click", function() {
            var result = confirm("Are you sure you want to delete all shop data?");
    });

    function deleteShops(shopId) {
    if (confirm('Are you sure you want to delete all shops?')) { //confirm is alert function with true false response
        fetch(`delete_shops_final.php?shop_id=${shopId}`)
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                alert('Shops deleted successfully');
                location.reload(); // reload the page to reflect the change
            } else {
                alert('Failed to delete shops. Please try again.');
            }
        })
        .catch(error => {
            console.error('There was an error deleting shops:', error);
        });
    }
}

</script>
</body>
</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/"; // Store uploaded files
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // .json expand
    if ($fileType != "json") {
        echo '<div class="error-message">Sorry, only JSON files are allowed.</div>';
        $uploadOk = 0;
    }
    
    // Evrthing ok, upload
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo '<div class="success-message">The file ' . basename($_FILES["fileToUpload"]["name"]) . ' has been successfully uploaded.</div>';
        }else{
            echo '<div class="error-message">Sorry, there was an error uploading your file.</div>';
        }
    }
    
  
}


?>

