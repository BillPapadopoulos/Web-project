<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet"
href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
<link rel="stylesheet" href="map.css">
<script
src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
</head>
<body>


  
  <div class="menu-bar">
   <ul class="Starter Buttons">
     <li class="home"><a href=#></a>Home</li>
     <li><a href=#></a>Search Offer by Category</li>
     <li><a href=#></a>Report an Offer</li>
     <li><a href=#></a>Available Offers</li>
     <li class="user"><a href=#></a>User : <?php echo $_SESSION['user_name']; ?> <br>Settings</li>
    </ul>
  </div>
  <div id="mapid"></div>
  <script src="map.js"></script>

</body>
</html>