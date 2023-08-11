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
  </div>


<div class="container">

    <div class="frames">
         <div class="frame-container">
            <img src="images/frame1.jpg" alt="Frame 1"  onclick="displayFrame('Cleaning')">
            <span class="frame-text">Cleaning</span>
         </div>  
         <div class="frame-container">
            <img src="images/frame2.jpg" alt="Frame 2"  onclick="displayFrame('Drinks-Refreshments')">
            <span class="frame-text">Drinks-Refreshments</span>
         </div>  
         <div class="frame-container">   
            <img src="images/frame3.jpg" alt="Frame 3"  onclick="displayFrame('Personal Care')">
            <span class="frame-text">Personal Care</span>
         </div>  
        <div class="frame-container">
            <img src="images/frame4.jpg" alt="Frame 4"  onclick="displayFrame('Food')">
            <span class="frame-text">Food</span>
        </div>  
        <div class="frame-container">
            <img src="images/frame5.jpg" alt="Frame 5" onclick="displayFrame('All Categories')">
            <span class="frame-text">All Categories</span>
        </div>  
     </div>

        <div id="frameDisplay">
            <!-- Selected frame will be displayed here -->
        </div>
</div>

    <script src="offers.js"></script>

  
  <?php //<div id="mapid"></div> ?>
  <script src="map.js"></script>

  

  </body>
</html>

