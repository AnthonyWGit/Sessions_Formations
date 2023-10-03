var map = L.map('map').setView([51.505, -0.09], 13); //Leaflet Init

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


// function onMapClick(e) 
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

  const popup2 = L.popup().setContent("Lieu de déroulement de la session");
  const market = L.marker().bindPopup(popup2);
  var click = false
// map.on('click', onMapClick);
if (!click)
{
    map.on('click', onMapClickM);
    console.log(click)
}


