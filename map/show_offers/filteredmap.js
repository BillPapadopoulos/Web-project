//map creation with openstreetmaps
  
  var mapOptions = {
    zoom: 40,
    center: L.latLng([21.7380288,38.24957])
  } //set center for initial map
  var mymap = L.map('mapid',mapOptions); 
  
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
  
  //this function chooses the name field and the coordinates for each shop from the data array. it also makes a marker for each shop
  
  var featuresLayer = new L.GeoJSON(data, {
    onEachFeature: function (feature, marker) {
      marker.bindPopup("<h4>" + feature.properties.name + "<h5>" + feature.geometry.coordinates + "</h4>");
    }
  });
  featuresLayer.addTo(mymap); 
  //this is the search bar for the map
  
  let controlSearch = new L.Control.Search({
    position: "topright",
    layer: featuresLayer,
    propertyName: "name",
    initial: false,
    zoom: 30,
    marker: false
  });
  //when the search is successful, the map coordinates you to the shop, then a pop up appears with basic shop info
  
  controlSearch.on('search:locationfound', function(e) {
  
    e.layer.openPopup().openOn(mymap);
  
  }).on('search:collapsed', function(e) {
    featuresLayer.resetStyle(layer);
  });
  
  mymap.addControl(controlSearch);
  
  // This function fetches the shops based on the category and displays them on the map.
  function displayShopsWithOffers(category) {
    // Clear previous markers
    mymap.eachLayer(function(layer) {
        if (layer instanceof L.Marker) {
            mymap.removeLayer(layer);
        }
    });
    
    // Fetch shops with offers in the specified category
    fetch(`get_shops_with_offers.php?category=${category}`)
    .then(response => response.json())
    .then(data => {
        data.forEach(shop => {
            // You will need to adjust this if the structure of your returned data is different
            L.marker([shop.latitude, shop.longitude])
                .addTo(mymap)
                .bindPopup(shop.name);
        });
    });
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

// On page load, fetch the shops with offers for the given category
document.addEventListener("DOMContentLoaded", function() {
    let category = getURLParameter('category');
    if(category) {
        displayShopsWithOffers(category);
    }
});
