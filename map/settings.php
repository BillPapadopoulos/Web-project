<?php
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
<link rel="stylesheet" href="map.css">
<script
src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
</head>
<body>

  <div class="menu-bar">
   <ul class="Starter Buttons">
     <li class="home"><a href="map.php">Home</a></li>
     <li><a href=#>Search Offer by Category</a></li>
     <li><a href=#>Report an Offer</a></li>
     <li><a href=#>Available Offers</a></li>
     <li class="pressed"><a href="settings.php">User : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>
  <div id="mapid"></div>
  <script src="map.js"></script>
  <div class="profile-settings">
    <?php
    
    session_start();
    //credentials of the logged in user
    $username= $_POST['user_name'];
    $password= $_POST['pass_word'];


    mysqli_close($conn);
    ?>
  </div>

</body>
</html>

