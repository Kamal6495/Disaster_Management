<div class="container">
    <h2>Disaster Alert Map</h2>
    <div id="map" style="height: 500px; width: 100%;"></div>
</div>
<script src="./assets/js/script.js"></script>
<!-- <hr style="height: 20px; background: #000; border: none; margin: 20px 0;"> Thick horizontal line -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof initMap === "function") {
            initMap(); 
        } else {
            console.error("Google Maps script not loaded or initMap is undefined.");
        }
    });
</script>



<!-- Horizontal Line Separator -->
<hr style="border: none; height: 20px; background-color: #333; margin: 40px 0;">

<div class="wrapper">
    <!-- INFORMATION SECTION -->
    <div class="container">
        <div class="header text-center">
            <p class="tagline">Nature is beautiful but it can sometimes be disastrous</p>
            <h1>Understanding Disasters</h1>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/tornado.jpg" alt="Tornado">
                    <div class="card-body">
                        <h3>Tornado</h3>
                        <p>A tornado is a rapidly rotating column of air...</p>
                        <a href="./information/tornado.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/hurricane.jpg" alt="Hurricane">
                    <div class="card-body">
                        <h3>Hurricane</h3>
                        <p>In meteorology, a hurricane is a large-scale air mass...</p>
                        <a href="./information/hurricane.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/tsunami.jpg" alt="Tsunami">
                    <div class="card-body">
                        <h3>Tsunami</h3>
                        <a href="./information/tsunami.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/earthquake.jpg" alt="Earthquake">
                    <div class="card-body">
                        <h3>Earthquake</h3>
                        <a href="./information/earthquake.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/flood.jpg" alt="Flood">
                    <div class="card-body">
                        <h3>Flood</h3>
                        <a href="https://www.ready.gov/floods" class="btn btn-primary" target="_blank">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/wildfires.jpg" alt="Wildfire">
                    <div class="card-body">
                        <h3>Wildfire</h3>
                        <a href="./information/wildfires.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/fpre.jpg" alt="Financial Preparedness">
                    <div class="card-body">
                        <h3>Financial Preparedness</h3>
                        <a href="./information/fp.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <img src="./images/kpre.jpg" alt="Youth Preparedness">
                    <div class="card-body">
                        <h3>Youth Preparedness</h3>
                        <a href="./information/yp.html" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
