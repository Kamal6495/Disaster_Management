<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relief Information</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #e0f7fa, #e8f5e9);
      font-family: 'Segoe UI', sans-serif;
      color: #2c3e50;
    }

    h2, h4 {
      font-weight: 700;
    }

    .section {
      background-color: #e0f7ff;
      padding: 3rem 2rem;
      border-radius: 1rem;
      margin-bottom: 2rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
    }

    .section:hover {
      transform: translateY(-5px);
    }

    .card {
      border: none;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 1rem;
      transition: all 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
      background-color: #e74c3c;
      border: none;
    }

    .btn-danger:hover {
      background-color: #c0392b;
    }

    select.form-select-lg {
      font-size: 1.1rem;
      padding: 0.75rem;
    }

    @media (max-width: 768px) {
      h2 {
        font-size: 1.75rem;
      }
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="text-center mb-5">🌍 Disaster Relief Information & Assistance</h2>

    <div class="row g-4">
      <!-- NDRF Info -->
      <div class="col-md-6">
        <div class="section h-100">
          <h4 class="text-primary">🛡️ NDRF – National Disaster Response Force</h4>
          <p class="mt-3">The <strong>NDRF</strong> is India's national force for large-scale disaster response, rescue operations, and emergency services.</p>
          <ul>
            <li>Operates under Ministry of Home Affairs</li>
            <li>Specialists in floods, quakes, and CBRN ops</li>
            <li>Nationwide deployment across zones</li>
          </ul>
        </div>
      </div>

      <!-- SDRF Info -->
      <div class="col-md-6">
        <div class="section h-100">
          <h4 class="text-success">🚨 SDRF – State Disaster Response Force</h4>
          <p class="mt-3"><strong>SDRF</strong> is the first responder in state-specific emergencies. It works in coordination with local and national bodies.</p>
          <ul>
            <li>State-run and trained in rescue techniques</li>
            <li>Operates in disaster-prone regions</li>
            <li>Supports evacuation, medical aid, logistics</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Relief Website Redirect -->
    <div class="section text-center">
      <h4 class="mb-4 text-danger">🔗 Visit Official Relief Agency Website</h4>
      <form id="reliefRedirectForm">
        <div class="row justify-content-center mb-3">
          <div class="col-md-6">
            <select class="form-select form-select-lg" id="reliefType" required>
              <option value="">-- Select Relief Force --</option>
              <option value="https://ndrf.gov.in/">NDRF (National Disaster Response Force)</option>
              <option value="https://sdma.uk.gov.in/pages/display/84-sdrf">SDRF (State Disaster Response Force)</option>
            </select>
          </div>
        </div>
        <button type="button" id="visitReliefBtn" class="btn btn-danger btn-lg mt-2 d-none">🌐 Visit Website</button>
      </form>
    </div>
  </div>

  <script>
    document.getElementById("reliefType").addEventListener("change", function () {
      const selected = this.value;
      const button = document.getElementById("visitReliefBtn");

      if (selected) {
        button.classList.remove("d-none");
        button.onclick = function () {
          window.open(selected, '_blank');
        };
      } else {
        button.classList.add("d-none");
      }
    });
  </script>
</body>
</html>