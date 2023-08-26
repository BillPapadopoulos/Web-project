<?php
session_start();
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
<link rel="stylesheet" href="filteredmap.css">
<script
src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
</head>
<body>

<div class="menu-bar">
   <ul class="Starter Buttons">
     <li><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li><a href=#>LeaderBoard</a></li>
     <li class="pressed"><a href="/web_database/map/admin/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>
  
  <div id="mapid"></div>
  <script src="/web_database/map/admin/show_offers/dataScript.js"></script>  <!-- data is defined in a separate script -->
  <script src="/web_database/map/admin/show_offers/filteredmap.js"></script>
  <script src="/web_database/map/admin/show_offers/offers.js"></script>
  
  
</body>
</html>