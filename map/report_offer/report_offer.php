<?php
session_start();
$conn = mysqli_connect('localhost','root','', 'web_database');
?>
<!DOCTYPE html>
<html>
<title>e-katanalotis offers</title>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
    <link rel="stylesheet" href="report_offer.css">
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.2/leaflet-search.min.js"></script>
</head>

<body>
    <div class="menu-bar">
        <ul class="Starter Buttons">
            <li><a href="/web_database/map/map.php">Home</a></li>
            <li><a href="#">Search Offer by Category</a></li>
            <li class="pressed"><a href="report_offer.php">Report an Offer</a></li>
            <li><a href="/web_database/map/show_offers/offers.php">Available Offers</a></li>
            <li><a href="/web_database/map/user_settings/settings.php">User : <?php echo $_SESSION['user_name']; ?>
                    <br>Settings</a></li>
        </ul>
    </div>
    <div id="mapid"></div>
    <script>
        var mapOptions = {
            zoom: 40,
            center: L.latLng([21.7380288, 38.24957]) // Default center, can be changed or removed
        }
        let mymap = L.map('mapid', mapOptions);
        mymap.addLayer(L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png'));

        // Call locate when the map is initialized
        mymap.locate({
            setView: true,
            zoom: 30
        });

        function onLocationFound(e) {
            var radius = e.accuracy;
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            console.log('Location found:', e.latlng);  
            var redIcon = L.icon({
                iconUrl: '/web_database/red_marker/red_marker.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34]
            });


            L.marker(e.latlng, {icon: redIcon}).addTo(mymap)
                .bindPopup("Your location").openPopup();

            L.circle(e.latlng, radius).addTo(mymap);

            fetchNearbyShops(e.latlng.lat, e.latlng.lng);
        }

        function fetchNearbyShops(lat, lng) {
            fetch('fetch_nearby_shops.php?lat=' + lat + '&lng=' + lng)
            .then(response => response.json())
            .then(shops => {
              console.log("Shops data:", shops);
              shops.forEach(shop => {
                var new_location = new L.LatLng(shop.lat, shop.lon);
                var place = shop.Details;
                var shop_id = shop.ID;
                var marker = new L.Marker(new_location, {
                    title: place
                });
                var message = 'Name: ' + place + '<br>ID: ' + shop_id;
                marker.bindPopup(message + '<br><button class="submit_button_offer" onclick="submitOfferForShop(' + shop_id + ')">Submit Offer</button>');
                marker.addTo(mymap);
                });
              })
          .catch(error => {
            console.error("Error fetching nearby shops:", error);
          });
        }


        function submitOfferForShop(shopId) {
            window.location.href = 'offer_submission.php?selected_shop=' + shopId;
        }

        mymap.on('locationfound', onLocationFound);
        mymap.on('locationerror', function (error) {
            alert('Error fetching location: ' + error.message);
        });

        


    </script>

</body>

</html>
