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
<link rel="stylesheet" href="settings.css">
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
     <li><a href=#>Available Offers</a></li>
     <li class="pressed"><a href="settings.php">User : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>
  <?php //<div id="mapid"></div> ?>
  <script src="map.js"></script> 

  <div class="container">
       <!-- after we include the php file, we add action option with the entire php/html file because we saw that on a video :p--> 
      <form class="form" action="change_credentials_legit.php" method="POST">
        <!-- this is the form used for the change credentials page --> 
        <div class="form__input-group">
          <input type="text" required id="updatedUsername" class="form__input" autofocus placeholder="Username" name="updatedUsername"> 
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
          <input type="password" required id="updatedPassword" class="form__input" autofocus placeholder="Password" name="updatedPassword"
           pattern="(?=.*\d)(?=.*[@$!%*#?&amp])(?=.*[A-Z]).{8,}" title="Password must contain 8 characters, at least one number, one uppercase letter, and one special character." />
          <div class="form__input-error-message"></div>
        </div>
        <button class="form__button" type="submit" id="button" name="update" value="update">Update Credentials</button>

        
    </form>
   </div>

</body>
</html>