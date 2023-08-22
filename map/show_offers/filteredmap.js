var mapOptions = {
  zoom: 40,
  center: L.latLng([21.7380288, 38.24957])
}

var mymap = L.map('mapid', mapOptions); 
mymap.addLayer(L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png'));
mymap.locate({setView: true, zoom: 30}); 

let markersLayer = L.layerGroup().addTo(mymap); // Initialize markersLayer here

function onLocationFound(e) {            
  var radius = e.accuracy;             
  var redIcon = L.icon({
    iconUrl: '/web_database/red_marker/red_marker.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
  });

  L.marker(e.latlng, {icon: redIcon}).addTo(mymap)
  .bindPopup("Your location").openPopup();

  L.circle(e.latlng, radius).addTo(mymap);
}

mymap.on('locationfound', onLocationFound);

let featuresLayer = new L.GeoJSON(undefined, {  // Initialize featuresLayer
    onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.name);
    }
}).addTo(mymap);

let controlSearch = new L.Control.Search({
  position: "topright",
  layer: featuresLayer,
  propertyName: "name",
  initial: false,
  zoom: 30,
  marker: false
});

controlSearch.on('search:locationfound', function(e) {
  e.layer.openPopup().openOn(mymap);
}).on('search:collapsed', function(e) {
  featuresLayer.resetStyle(e.layer);  // Assuming this line is to reset style after search collapse.
});

mymap.addControl(controlSearch);

function displayShopsWithOffers(category) {
  markersLayer.clearLayers();

  fetch(`get_shops_with_offers.php?category=${category}`)
  .then(response => response.json())
  .then(data => {
      data.forEach(shop => {
        console.log(shop.name); // debug
          L.marker([shop.latitude, shop.longitude])
              .bindPopup(shop.name) //shows in the pop up
              .addTo(markersLayer);  // Attach the markers to the markersLayer
      });
  })
  .catch(error => {
      console.error('There was an error fetching the data:', error);
  });
}

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

document.addEventListener("DOMContentLoaded", function() {
  let category = getURLParameter('category');
  if(category) {
      displayShopsWithOffers(category);
  }
});
