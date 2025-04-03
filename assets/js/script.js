document.addEventListener("DOMContentLoaded", function () {
  showSection("home.php"); // Load home.php by default

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
    })
    .catch((error) => {
      contentDiv.innerHTML = "<p>Error loading content.</p>";
      console.error("Error fetching file:", error);
    });
}

//MAP SECTION
// MAP SECTION

let map;
function initMap() {
  const mapElement = document.getElementById("map");

  if (!mapElement) {
    console.error("Error: Map element not found.");
    return;
  }

  map = new google.maps.Map(mapElement, {
    center: { lat: 0, lng: 0 },
    zoom: 2,
  });

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
          map,
          title: disaster.title,
        });

        const infoWindow = new google.maps.InfoWindow({
          content: `<h3>${disaster.title}</h3>
                    <p>Type: ${disaster.type}</p>
                    <p><a href="${disaster.source}" target="_blank">More Info</a></p>`,
        });

        marker.addListener("click", () => {
          infoWindow.open(map, marker);
        });
      });
    })
    .catch((error) => console.error("Error fetching disaster data:", error));
}
