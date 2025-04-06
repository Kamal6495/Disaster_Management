let map1; // Declare map only once globally

showSection("home.php");  // Load home.php by default

document.addEventListener("DOMContentLoaded", function () {


  document.querySelectorAll(".nav-link").forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent page reload
      const sectionFile = this.getAttribute("href"); // Get PHP file name
      showSection(sectionFile);
    });
  });
});

function showSection(sectionFile) {
  const contentDiv = document.getElementById("content");

  // Show loading spinner
  contentDiv.innerHTML = '<div class="loading-spinner"></div>';

  fetch(sectionFile)
    .then((response) => response.text())
    .then((data) => {
      contentDiv.innerHTML = data; // Load new content

      // Check if the loaded content contains a map element
      if (document.getElementById("map")) {
        console.log("Map detected, initializing...");
        initMap();
      }
    })
    .catch((error) => {
      //contentDiv.innerHTML = "<p>Error loading content.</p>";
      console.error("Error fetching file:", error);
    });
}

// Initialize Google Map
function initMap() {
  const mapElement = document.getElementById("map");

  if (!mapElement) {
    console.error("Error: Map element not found.");
    return;
  }

  // if (!map) { // Prevent re-initialization
  map1 = new google.maps.Map(mapElement, {
      center: { lat: 0, lng: 0 },
      zoom: 2,
    });

    loadDisasterMarkers(); // Load markers after map initialization
  // }
}

// Fetch and add disaster markers
function loadDisasterMarkers() {
  fetch("/Disaster_Management/database/get_disasters.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      if (!Array.isArray(data) || data.length === 0) {
        console.warn("No disaster data available.");
        return;
      }

      data.forEach((disaster) => {
        if (!disaster.latitude || !disaster.longitude) {
          console.warn("Skipping invalid disaster data:", disaster);
          return;
        }

        const marker = new google.maps.Marker({
          position: {
            lat: parseFloat(disaster.latitude),
            lng: parseFloat(disaster.longitude),
          },
          map: map1, // Ensure `map1` is defined elsewhere in your code
          title: disaster.title,
        });

        const infoWindow = new google.maps.InfoWindow({
          content: `
            <h3>${disaster.title}</h3>
            <p>Type: ${disaster.type}</p>
            <p><a href="${disaster.source}" target="_blank">More Info</a></p>
          `,
        });

        marker.addListener("click", () => {
          infoWindow.open(map1, marker);
        });
      });
    })
    .catch((error) => {
      console.error("Error fetching disaster data:", error);
    });
}
/**main.js:171 As of February 21st, 2024, google.maps.Marker is deprecated. Please use google.maps.marker.AdvancedMarkerElement instead. At this time, google.maps.Marker is not scheduled to be discontinued, but google.maps.marker.AdvancedMarkerElement is recommended over google.maps.Marker. While google.maps.Marker will continue to receive bug fixes for any major regressions, existing bugs in google.maps.Marker will not be addressed. At least 12 months notice will be given before support is discontinued. Please see https://developers.google.com/maps/deprecations for additional details and https://developers.google.com/maps/documentation/javascript/advanced-markers/migration for the migration guide. */