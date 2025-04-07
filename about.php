<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Disaster Management Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #e1bee7);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        h1, h2 {
            color: #4a148c;
        }
        ul li::marker {
            color: #4a148c;
        }
        .section {
            padding: 60px 20px;
            background-color: #e3f2fd;
            margin-bottom: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .section:hover {
            transform: translateY(-5px);
            background-color: #bbdefb;
        }
        .hero {
            background: url('https://images.unsplash.com/photo-1602661144736-72a1a6c6f836?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') center/cover;
            color: white;
            padding: 100px 20px;
            text-align: center;
            border-radius: 20px;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #555;
        }
        .swiper {
            width: 100%;
            height: 400px;
            margin-bottom: 40px;
            border-radius: 15px;
            overflow: hidden;
        }
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            .swiper {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero mb-5">
            <h1>Disaster Management Platform</h1>
            <p class="lead">Empowering Communities, Governments & Organizations for a Safer Tomorrow</p>
        </div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
           
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1575916167835-a26dc9a826fd?q=80&w=1710&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Earthquake"></div>
                <div class="swiper-slide"><img src="https://media.istockphoto.com/id/2169351425/photo/flooding-in-florida-caused-by-tropical-storm-from-hurricane-debby-suburb-houses-in-laurel.jpg?s=1024x1024&w=is&k=20&c=ihD9YyPvKq-zuXE0Q7v8CsuCgagxUi8n9hfDjD5YxZo=" alt="Flood"></div>
                <div class="swiper-slide"><img src="https://media.istockphoto.com/id/2186685950/photo/forest-wildfire-at-night.jpg?s=1024x1024&w=is&k=20&c=t9wCi9IVqGi5RuXrYCAwRT0ab8xKqsXIYXaQiSyRiY0=" alt="Wildfire"></div>
                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1454789476662-53eb23ba5907?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxjb2xsZWN0aW9uLXBhZ2V8M3wzMTE2NDg1fHxlbnwwfHx8fHw%3D" alt="Hurricane"></div>
                <div class="swiper-slide"><img src="https://media.istockphoto.com/id/182006434/photo/tsunami-waves.jpg?s=1024x1024&w=is&k=20&c=eUHlcf1_mdMhICXVbSHHW5gSdOaJGgqQ-LxYeJOQxEA=" alt="Tsunami"></div>
            
            </div>
        </div>

        <div class="section">
            <h2>🌍 Introduction</h2>
            <p>The Disaster Management Platform is an innovative system designed to track, analyze, and notify users about disasters in real-time. It serves as a bridge between disaster data and those who need to respond—governments, NGOs, and the general public—helping reduce response times and save lives.</p>
        </div>

        <div class="section">
            <h2>⚠️ Importance of Disaster Management</h2>
            <p>Effective disaster management ensures that lives are protected, damages are minimized, and recovery is swift. Its key benefits include:</p>
            <ul>
                <li>✅ Saving lives through early detection and rapid alerts.</li>
                <li>✅ Minimizing economic and environmental loss.</li>
                <li>✅ Ensuring timely aid and support from relevant agencies.</li>
                <li>✅ Raising awareness and educating communities about disaster risks.</li>
                <li>✅ Helping governments plan and implement better infrastructure and response systems.</li>
            </ul>
        </div>

        <div class="section">
            <h2>🎯 Why This Platform Was Built</h2>
            <p>Natural disasters often strike without warning, and the absence of reliable, real-time data delays emergency responses. This platform solves that by offering:</p>
            <ul>
                <li>🌐 A global map with live disaster updates.</li>
                <li>📊 Smart analytics for prediction and historical pattern analysis.</li>
                <li>📱 Integrated communication via SMS, email, and push notifications.</li>
                <li>🤝 Relief coordination with government bodies like NDRF, SDRF, and international NGOs.</li>
            </ul>
        </div>

        <div class="section">
            <h2>⚙️ How It Works</h2>
            <p>The platform fetches and processes live data from APIs (NASA, Google Maps, OpenWeatherMap). It displays this information in an interactive and accessible interface that includes:</p>
            <ul>
                <li>🗺️ Real-time alerts with severity indicators on a dynamic map.</li>
                <li>🔔 Location-based alert system for personalized updates.</li>
                <li>📂 Search and filter tools to refine results by region, disaster type, and time.</li>
                <li>📆 Timeline slider to visualize past events and trends.</li>
            </ul>
        </div>

        <div class="section">
            <h2>👥 Who Can Use It?</h2>
            <ul>
                <li>🏛️ <strong>Government Officials</strong>: to plan and coordinate timely response strategies.</li>
                <li>🧑‍🚒 <strong>Relief Agencies</strong>: to initiate emergency action with real-time guidance.</li>
                <li>🧍‍♀️ <strong>Citizens</strong>: to stay informed and act safely during emergencies.</li>
                <li>📊 <strong>Researchers</strong>: to study trends and propose new mitigation techniques.</li>
            </ul>
        </div>

        <div class="section">
            <h2>✅ Conclusion</h2>
            <p>The Disaster Management Platform combines technology, data, and communication to create a safer, smarter response system. By providing real-time alerts, integrated relief connections, and predictive insights, it transforms how we respond to disasters—making a real difference when every second counts.</p>
        </div>

        <div class="footer">
            &copy; 2025 Disaster Management Platform | Built for Resilience and Preparedness
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
</body>
</html>
