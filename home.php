<h2>Home</h2>
<p>Welcome to the Disaster Management Platform.</p>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="date">Select Disaster Date:</label>
        <input type="date" id="date" class="form-control">
    </div>
    <div class="col-md-4">
        <label for="disaster-type">Disaster Type:</label>
        <select id="disaster-type" class="form-control">
            <option value="all">All</option>
            <option value="Wildfire">Wildfire</option>
            <option value="Storm">Storm</option>
            <option value="Flood">Flood</option>
            <option value="Earthquake">Earthquake</option>
            <option value="Volcano">Volcano</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="country">Country:</label>
        <select id="country" class="form-control">
            <option value="all">All</option>
        </select>
    </div>
</div>
<div id="map"></div>
