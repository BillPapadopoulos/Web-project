<?php
session_start();
$conn = mysqli_connect('localhost','root','', 'web_database');




$X=21.7543673;
$Y=38.21940422;

  $query="  SELECT lat, lon, shop_name, shop_id FROM shop 
  WHERE ((SQRT(POWER(".$X."-lon, 2) + POWER(".$Y."-lat,2)))*100000)<1500";

  $result = $conn->query($query); 
  while($row = $result->fetch_array())
{

  $data[] = array("lat"=>$row["lat"], "lon"=>$row["lon"], "Details"=>$row['shop_name'], "ID"=>$row["shop_id"]);
}

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
<link rel="stylesheet" href="report_offer.css">
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
     <li class="pressed"><a href="report_offer.php">Report an Offer</a></li>
     <li><a href="/web_database/map/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/user_settings/settings.php">User : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>
  <div id="mapid"></div>
  <script>

    
    
var mapOptions = {
  zoom: 40,
  center: L.latLng([21.7380288,38.24957])
} //set center for initial map
let mymap = L.map('mapid',mapOptions); 

mymap.addLayer(L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png'));


//this is the initial position when the app opens

mymap.locate({setView: true, zoom: 30}); 

  
  function onLocationFound(e) {            
      var radius = e.accuracy;             
      var redIcon = L.icon({
        iconUrl: '/web_database/red_marker/red_marker.png',
        iconSize: [25, 41], // size of the icon
        iconAnchor: [12, 41], // point of the icon which will correspond to marker's location
        popupAnchor: [1, -34] // point from which the popup should open relative to the iconAnchor
      });
      

      L.marker(e.latlng,{icon: redIcon}).addTo(mymap)
      .bindPopup("Your location").openPopup();

      L.circle(e.latlng, radius).addTo(mymap);
    }


    mymap.on('locationfound', onLocationFound);
    ////////////////////////////////////////////////////////////////////////////////////////////////////
  

      var city = L.layerGroup();
        var data = <?php echo json_encode($data); ?>;
        for (var i = 0; i < data.length; i++) {
          var new_location = new L.LatLng(data[i].lat, data[i].lon);
          var place = data[i].Details;
          var shop_id = data[i].ID;
          var marker = new L.Marker(new_location, {
            title: place
          });
          var message = 'Name: ' +place+'<br>ID: '+shop_id;
          marker.bindPopup(message+'<br><button class="submit_button_offer" onclick="window.location.href=\'offer_submission.php\';">Submit Offer</button>');
          city.addLayer(marker);
        
          
        }

      mymap.addLayer(city);




  </script>

</body>
</html>