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

<style>
    .form__input-group {
      position: relative;
    }

    .form__input-group input {
      padding-right: 35px; /* Χώρος από τα δεξιά για το κουμπί */
    }

    .form__input-group button {
      position: absolute;
      top: 50%;
      right: 10px; /*αποσταση απο δεξια*/
      transform: translateY(-50%);
    }

    .form__input-group button img {
      height: 18px;
      width: 20px;
    }
  </style>

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
      <form class="form" action="change_credentials_legit.php" onsubmit = "return checkForBlank()" method="POST">
        <!-- this is the form used for the change credentials page --> 
        <div class="form__input-group">
          <input type="text"  id="updatedUsername" class="form__input" autofocus placeholder="Username" name="updatedUsername"> 
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
          <input type="password"  id="updatedPassword" class="form__input" autofocus placeholder="Password" name="updatedPassword"
           pattern="(?=.*\d)(?=.*[@$!%*#?&amp])(?=.*[A-Z]).{8,}" title="Password must contain 8 characters, at least one number, one uppercase letter, and one special character." />
          <button type="button" id="togglePassword">
            <img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />
          </button>
          <div class="form__input-error-message"></div>
        </div>
        <button class="form__button" type="submit" id="button" name="update" value="update">Update Credentials</button>       
    </form>
   </div>
   <script>
    function checkForBlank()
    {
      var username = document.getElementById('updatedUsername').value;
      var password = document.getElementById('updatedPassword').value;

      if(username.trim() == "" && password.trim() == "") {
          alert("Both fields cannot be empty.");
          return false;
      }
    } 
  </script>
  
  <script>
  // Συνάρτηση για toggle εμφάνισης/απόκρυψης του κωδικού
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('updatedPassword');
    const toggleButton = document.getElementById('togglePassword');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleButton.innerHTML = '<img src="/web_database/map/user_settings/show_pass.png" alt="Toggle Password" />';
    } else {
      passwordInput.type = 'password';
      toggleButton.innerHTML = '<img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />';
    }
  }

  // Συνδέστε την συνάρτηση togglePasswordVisibility με το κουμπί
  const toggleButton = document.getElementById('togglePassword');
  toggleButton.addEventListener('click', togglePasswordVisibility);
</script>


</body>
</html>