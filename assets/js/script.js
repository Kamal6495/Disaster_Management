let map1; // Declare map only once globally
const markers = [];
const emojiCache = {};
// const sharedInfoWindow1 = new google.maps.InfoWindow(); // ✅ MOVE THIS UP



document.addEventListener("DOMContentLoaded", function () {
  // Setup all nav links
  document.querySelectorAll(".nav-link").forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent full page reload
      const sectionFile = this.getAttribute("href");
      showSection(sectionFile);
    });
  });

  // Load home.php by default only once on initial load
  showSection("home.php");
});

function showSection(sectionFile) {
  const contentDiv = document.getElementById("content");

  // Show loading spinner
  contentDiv.innerHTML = '<div class="loading-spinner">Loading...</div>';

  fetch(sectionFile)
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.text();
    })
    .then((data) => {
      contentDiv.innerHTML = data;

      // Check if the loaded content contains a map element
      if (document.getElementById("map")) {
        console.log("Map detected, initializing...");
        if (typeof initMap === "function") initMap();
      }
    })
    .catch((error) => {
      console.error("Error fetching file:", error);
      contentDiv.innerHTML = "<p style='color: red;'>Failed to load content.</p>";
    });
}

/**main.js:171 As of February 21st, 2024, google.maps.Marker is deprecated. Please use google.maps.marker.AdvancedMarkerElement instead. At this time, google.maps.Marker is not scheduled to be discontinued, but google.maps.marker.AdvancedMarkerElement is recommended over google.maps.Marker. While google.maps.Marker will continue to receive bug fixes for any major regressions, existing bugs in google.maps.Marker will not be addressed. At least 12 months notice will be given before support is discontinued. Please see https://developers.google.com/maps/deprecations for additional details and https://developers.google.com/maps/documentation/javascript/advanced-markers/migration for the migration guide. */
// Initialize Google Map
function initMap() {
  const mapElement = document.getElementById("map");

  if (!mapElement) {
    console.error("Error: Map element not found.");
    return;
  }

  // if (!map) { // Prevent re-initialization
  map1 = new google.maps.Map(mapElement, {
    center: { lat: 22.9734, lng: 78.6569 },
    zoom: 5,
  });

  loadDisasterMarkers(); // Load markers after map initialization
  // }
}

function getDisasterEmoji(event_type) {
  const icons = {
    earthquake: "🌍",
    "sea and lake ice": "🌊",
    wildfire: "🔥",
    drought: "🌾",
    storm: "⛈️",
    volcanoes: "🌋",
    tsunami: "🌊",
    blizzard: "❄️",
    landslide: "🪨",
    rain: "☔",
  };

  const cleanType = event_type?.trim().toLowerCase();
  return icons[cleanType] || "❗";
}


function emojiToDataUrlCached(emoji) {
  if (emojiCache[emoji]) return emojiCache[emoji];

  const canvas = document.createElement("canvas");
  canvas.width = 64;
  canvas.height = 64;
  const ctx = canvas.getContext("2d");
  ctx.font = "48px serif";
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  ctx.fillText(emoji, canvas.width / 2, canvas.height / 2);

  const dataUrl = canvas.toDataURL();
  emojiCache[emoji] = dataUrl;
  return dataUrl;
}

function getIconSize(zoom) {
  if (zoom >= 10) return 32;
  if (zoom >= 7) return 24;
  if (zoom >= 4) return 18;
  return 14;
}

function loadDisasterMarkers() {
  fetch("/Disaster_Management/database/get_gdacs_data.php")
    .then((response) => {
      if (!response.ok)
        throw new Error(`HTTP error! Status: ${response.status}`);
      return response.json();
    })
    .then((data) => {
      if (!Array.isArray(data) || data.length === 0) {
        console.warn("No disaster data available.");
        return;
      }

      const currentZoom = map1.getZoom();
      const iconSize = getIconSize(currentZoom);

      data.forEach((disaster) => {
        if (!disaster.latitude || !disaster.longitude) return;

        // const emoji = getDisasterEmoji(disaster.event_type);
        // console.log(`Mapped event_type "${disaster.event_type}" to emoji: ${emoji}`);
        const emojiIconUrl = disaster.icon_url;

        const marker = new google.maps.Marker({
          position: {
            lat: parseFloat(disaster.latitude),
            lng: parseFloat(disaster.longitude),
          },
          map: map1,
          title: disaster.title,
          icon: {
            url: emojiIconUrl,
            scaledSize: new google.maps.Size(iconSize, iconSize),
          },
        });

        // ✅ Use a fresh InfoWindow per marker
        const infoWindow = new google.maps.InfoWindow({
          content: `
                  <h3>${disaster.title}</h3>
                 <p>Type: ${disaster.event_type} ${emojiIconUrl}</p>
                     <p><a href="${disaster.link}" target="_blank">More Info</a></p>
  `,
        });

        marker.addListener("click", () => {
          infoWindow.open(map1, marker);
        });

        markers.push({ marker, emojiIconUrl });
      });

      // // Marker clustering
      // new markerClusterer.MarkerClusterer({
      //   map: map1,
      //   markers: markers.map((m) => m.marker),
      // });

      // Adjust marker size on zoom
      map1.addListener("zoom_changed", () => {
        const newSize = getIconSize(map1.getZoom());
        markers.forEach(({ marker, emojiIconUrl }) => {
          marker.setIcon({
            url: emojiIconUrl,
            scaledSize: new google.maps.Size(newSize, newSize),
          });
        });
      });
    })
    .catch((error) => {
      console.error("Error fetching disaster data:", error);
    });
}



