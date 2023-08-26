<?php
session_start();
//establish connection with database
    $conn = mysqli_connect('localhost','root','', 'web_database');
?>
<!DOCTYPE html>
<html>
  <title>Admin Settings</title>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet"
href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
<link rel="stylesheet" href="/web_database/map/admin/adm.css">
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
     <li class="pressed"><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>
  <?php //<div id="mapid"></div> ?>
  <script src="map.js"></script> 
  <div class="profile-settings">
    
    
    <?php
    $username = $_SESSION['user_name']; //this is the username of the logged in user


    $sql = "select * from user where user_username = '$username'";  

    $result = mysqli_query($conn, $sql); 
    
    while ($row = mysqli_fetch_assoc($result)) {
      //table of username credentials
      echo "<table>";
      echo "<tr><th>Admin name: </th><td>" . $row['user_username'] . "</td></tr>"; //username
      echo "<tr><th>Email: </th><td>" . $row['email'] . "</td></tr>"; //email
      echo "<tr><th>Offers: </th><td>" . $row['offers'] . "</td></tr>"; //istoriko prosforwn
      echo "<tr><th>Likes: </th><td>" . $row['likes'] . "</td></tr>"; //likes
      echo "<tr><th>Dislikes: </th><td>" . $row['dislikes'] . "</td></tr>"; //dislikes
      echo "<tr><th>Total Score: </th><td>" . $row['total_score'] . "</td></tr>"; //total score
      echo "<tr><th>Monthly Score: </th><td>" . $row['monthly_score'] . "</td></tr>"; //monthly score
      echo "<tr><th>Monthly Tokens: </th><td>" . $row['premonth_tokens'] . "</td></tr>"; //monthly tokens
      echo "<tr><th>Total Tokens: </th><td>" . $row['total_tokens'] . "</td></tr>"; //total tokens
      echo "</table><br><br>";
      // Adds a line break between tables
    } 

      mysqli_close($conn);
    ?>
    
  </div>

</body>
</html>