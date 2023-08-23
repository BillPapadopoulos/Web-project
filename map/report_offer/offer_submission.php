<?php
  session_start();
  $conn = mysqli_connect('localhost','root','', 'web_database');

  $selectedShopId = isset($_GET['selected_shop']) ? intval($_GET['selected_shop']) : null;


?>
<!DOCTYPE html>
<html>
  <title>Make a new offer</title>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet"
href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
<link rel="stylesheet" href="offer_submission.css">
<script
src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
<script src="offer_submission.js"></script>
  
<script>
    var selectedShopId = <?php echo json_encode($selectedShopId); ?>;
</script>

</head>
<body>

  <div class="menu-bar">
   <ul class="Starter Buttons">
     <li><a href="/web_database/map/map.php">Home</a></li>
     <li><a href=#>Search Offer by Category</a></li>
     <li class="pressed"><a href="/web_database/map/report_offer/report_offer.php">Report an Offer</a></li>
     <li><a href="/web_database/map/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/user_settings/settings.php">User : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>

<div class="form">
        <form name="form_discount_register" class="form_discount_register" id="form_discount_register" action="/web_database/map/report_offer/offer_registration.php" method="post">
            <div class="select-dropdown">
            <select name="category" id="categoryDropdown" onchange="fetchSubcategories(this.value);">
            <option value="" selected="selected">Choose category</option>
                </select>
            </div>
            <br><br>
            <div class="select-dropdown">
                <select name="subcategory" id="subcategory" onchange="fetchProducts(this.value);">
                    <option value="" selected="selected">Choose subcategory</option>
                </select>
            </div>
            <br><br>
            <div class="select-dropdown">
                <select name="product" id="product">
                    <option value="" selected="selected">Choose product</option>
                </select>
            </div>
            <br><br>
            <div class="select-dropdown">
            <select name="shop" id="shopDropdown">
             <option value="" selected="selected">Choose shop</option>
            </select>
            </div>  
            <br><br>
            <label for="price"><b>Price of product: </b></label>
            <br><br>
            <input id="price" name="price">
              
            <br><br>
            <button type="submit"><b>Offer Registration</b></button>          
        </form>
    </div>

</body>
</html>
