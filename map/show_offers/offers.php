<?php
session_start();
//establish connection with database
    $conn = mysqli_connect('localhost','root','', 'web_database');
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
<link rel="stylesheet" href="offers.css">
<script
src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
</head>
<body>

  <div class="menu-bar">
   <ul class="Starter Buttons">
     <li><a href="/web_database/map/map.php">Home</a></li>
     <li><a href=#>Search Offer by Category</a></li>
     <li><a href=#>Report an Offer</a></li>
     <li class="pressed"><a href="offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/user_settings/settings.php">User : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div class="container">

  <form  class="myform">
  <select onchange="showOffer(this.value)">
  <option>Select a category:</option>
  <option>All categories</option>
  <option>Baby Products</option>
  <option>Drinks - refreshments</option>
  <option>Cleaning</option>
  <option>Food</option>
  </select>
  </form>
  <br>
  <div id="txtHint"><b>Available offers will show up here.</b></div>

  <?php //<div id="mapid"></div> ?>
  <script src="map.js"></script>

  </body>
</html>

