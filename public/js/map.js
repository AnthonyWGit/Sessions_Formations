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

function onMapClickM(clickMarker) //If there is a marker already a click removes it and user can place a new one 
{
    if (!click) {
      market
        .setLatLng(clickMarker.latlng)
        .addTo(map);
        // clickMarker.latlng.lat = clickMarker.latlng.lat.toFixed(7)
        // clickMarker.latlng.lng = clickMarker.latlng.lng.toFixed(8)
        inputCoordinates.value = clickMarker.latlng.lat +" "+ clickMarker.latlng.lng
        console.log(clickMarker.latlng)
      click = true;
    } else {
      map.removeLayer(market);
      click = false;
    }
  }

var lc = L.control //Leafleat addon use
  .locate({
    position: "topright",
    strings: {
      title: "Votre position"
    },
  })

  .addTo(map);

//   const popup = L.popup()
//   .setLatLng([51.513, -0.09])

  const inputCoordinates = document.querySelector("#session_coordonnees")
  const popup2 = L.popup().setContent("Lieu de déroulement de la session");
  const market = L.marker().bindPopup(popup2);
  var click = false
// map.on('click', onMapClick);
if (!click)
{
    map.on('click', onMapClickM);
    console.log(click)
}


