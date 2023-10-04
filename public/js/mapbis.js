var map = L.map('map').locate({setView: true, maxZoom: 16}); //If geolock is activated set map on user 
 //Leaflet Init

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


// function onMapClick(e)  popup on click
// {
// popup
//     .setLatLng(e.latlng)
//     .setContent(`You clicked the map at ${e.latlng.toString()}`)
//     .openOn(map);
//     L.marker(e.latlng).addTo(map);
// }


var lc = L.control //Leafleat addon use
  .locate({
    position: "topright",
    strings: {
      title: "Votre position"
    },
  })
  .addTo(map);

  var click = false
  var mapElement = document.getElementById('map');
  var marqueurs = JSON.parse(mapElement.getAttribute('data-marqueurs'));
  console.log(marqueurs);
  // Loop through the marqueurs object and add markers to the map
  for (var i = 0; i < marqueurs.length; i++) {
    var id = Object.keys(marqueurs[i])[0]; // Get the ID from the object key
    var coordinates = marqueurs[i][id].split(' '); // Split the coordinates into lat and lng
    var lat = parseFloat(coordinates[0]);
    var lng = parseFloat(coordinates[1]);
  
    // Create a marker and add it to the map
    var marker = L.marker([lat, lng]).addTo(map);
  
    // You can customize the marker or add a popup here if needed
    marker.bindPopup('Lieu de la session 1' + id);
  }
  
  


