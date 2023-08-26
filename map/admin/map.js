//map creation with openstreetmaps
var goldIcon = L.icon({
  iconUrl: '/web_database/gold_marker/gold_marker.png',
  iconSize: [25, 41], // size of the icon
  iconAnchor: [12, 41], // point of the icon which will correspond to marker's location
  popupAnchor: [1, -34] // point from which the popup should open relative to the iconAnchor
});


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

//If any shop in the shopsWithOffers array has a lat and lon that matches the provided lat and lon (to 6 decimal places), the function will return true. Otherwise false.

    function hasOffers(lat, lon) {
      return shopsWithOffers.some(shop => parseFloat(shop.lat).toFixed(6) === lat.toFixed(6) && parseFloat(shop.lon).toFixed(6) === lon.toFixed(6));
    }
    

//this function chooses the name field and the coordinates for each shop from the data array. it also makes a marker for each shop

var featuresLayer = new L.GeoJSON(geojsonData, {
  onEachFeature: function (feature, layer) {
    layer.bindPopup("<h4>" + feature.properties.name + "<h5>" + feature.geometry.coordinates + "</h4>");
  },
  pointToLayer: function (feature, latlng) {
    let chosenIcon;
    
    if (hasOffers(latlng.lat, latlng.lng)) {
      console.log("Shop at", latlng, "has offers!1!1");
      chosenIcon = goldIcon;
    } else {
      console.log("Shop at", latlng, "has no offers");
      chosenIcon = new L.Icon.Default();
    }
  
    return L.marker(latlng, { icon: chosenIcon });
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