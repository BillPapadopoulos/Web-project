<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'web_database');

// Check connection.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//select shops with offers
$query = "SELECT DISTINCT o.shop_id, s.lat, s.lon
FROM offer o 
JOIN shop s ON o.shop_id = s.shop_id;";
$result = mysqli_query($conn, $query);

$shopsWithOffers = [];
while ($row = mysqli_fetch_assoc($result)) {
  $shopsWithOffers[] = ['shop_id' => $row['shop_id'], 'lat' => $row['lat'], 'lon' => $row['lon']];
}

// Convert the array to JSON
$shopsJson = json_encode($shopsWithOffers);

?>

<!DOCTYPE html>
<html>
  <title>e-katanalotis offers</title>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet"
href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
<link rel="stylesheet" href="/web_database/map/admin/map.css">
<script
src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
</head>
<body>

  <div class="menu-bar">
   <ul class="Starter Buttons">
     <li class="pressed"><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li><a href="/web_database/map/admin/leaderboard/leaderboard.php">Leaderboard</a></li>
     <li><a href="/web_database/map/admin/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>

  

  <div id="mapid"></div>
  <script>
    var shopsWithOffers = <?php echo $shopsJson; ?>;
    console.log(shopsWithOffers);
  </script>
  <script src="data.js"></script>
  <script src="map.js"></script>


</body>
</html>

