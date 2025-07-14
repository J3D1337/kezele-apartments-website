const map = L.map('map').setView([45.219040, 14.620103], 18);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Store markers in an array to manage them
  const markers = [];

  // Add predefined markers
  const initialMarker = L.marker([45.219040, 14.620103]).addTo(map)
    .bindPopup('<b>Ulica Ive Lole Ribara 24</b><br>Jadranovo, Croatia')
    .openPopup();
  markers.push(initialMarker);

  // Function to remove a specific marker
  function removeMarker(index) {
    const marker = markers[index];
    if (marker) {
      map.removeLayer(marker);  // Remove from map
      markers.splice(index, 1); // Remove from array
    }
  }

  // Function to remove all markers
  function removeAllMarkers() {
    markers.forEach(marker => map.removeLayer(marker));
    markers.length = 0; // Clear the array
  }
