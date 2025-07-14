const map = L.map("map").setView([45.21904, 14.620103], 15);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Store markers in an array to manage them
const markers = [];

// Initial marker with popup opened
const initialMarker = L.marker([45.21904, 14.620103])
    .addTo(map)
    .bindPopup("<b>KEZELE APARTMENTS</b><br>Jadranovo, Croatia")
    .openPopup();
markers.push(initialMarker);

// Other markers with popups, but not opened by default
const secondMarker = L.marker([45.231214, 14.611842])
    .addTo(map)
    .bindPopup("<b>Obala Beach</b>");
markers.push(secondMarker);

const thirdMarker = L.marker([45.219648, 14.617096])
    .addTo(map)
    .bindPopup("<b>Havišće Beach</b>");
markers.push(thirdMarker);

const fourthMarker = L.marker([45.219749, 14.610159])
    .addTo(map)
    .bindPopup("<b>Lokvišće Beach</b>");
markers.push(fourthMarker);

const fifthMarker = L.marker([45.215038, 14.622995])
    .addTo(map)
    .bindPopup("<b>Vodna Beach</b>");
markers.push(fifthMarker);

// Optional: Functions to manage markers
function removeMarker(index) {
    const marker = markers[index];
    if (marker) {
        map.removeLayer(marker);
        markers.splice(index, 1);
    }
}

function removeAllMarkers() {
    markers.forEach((marker) => map.removeLayer(marker));
    markers.length = 0;
}
