<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Disaster Management Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #e1bee7);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        h1,
        h2 {
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

        .developer-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin: 20px;
            padding: 10px;
        }

        .developer-card {
            background: linear-gradient(to bottom right, #d1e8ff, #f2f7ff);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .dev-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .developer-card a {
            color: #0066cc;
            text-decoration: none;
        }

        .developer-card a:hover {
            text-decoration: underline;
        }

        .developer-card i {
            margin-right: 8px;
            color: #444;
        }


        .developer-card:hover {
            transform: translateY(-5px);
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

        <div class="developer-section">
            <div class="developer-card">
                <img src="dev1.jpg" alt="Developer 1" class="dev-photo">
                <h3>👨‍💻 Kamal Kant Singh</h3>
                <p><strong>Branch:</strong> Computer Science and Engineering</p>
                <p><strong>College:</strong> MNNIT Allahabad</p>
                <p><i class="fa fa-envelope"></i>
                    <a href="mailto:kamal.2024cs12@mnnit.ac.in">kamal.2024cs12@mnnit.ac.in</a>
                </p>
                <p><i class="fa fa-linkedin"></i>
                    <a href="https://www.linkedin.com/in/kamal6495" target="_blank">linkedin.com/in/kamal6495</a>
                </p>
                <p><i class="fa fa-github"></i>
                    <a href="https://github.com/kamal6495" target="_blank">github.com/kamal6495</a>
                </p>
            </div>

            <div class="developer-card">
                <img src="dev2.jpeg" alt="Developer 2" class="dev-photo">
                <h3>👩‍💻 Prashant Kumar Singh</h3>
                <p><strong>Branch:</strong> Computer Science and Engineering</p>
                <p><strong>College:</strong> MNNIT Allahabad</p>
                <p><i class="fa fa-envelope"></i>
                    <a href="mailto:prashant2024cs15@mnnit.ac.in">prashant2024cs15@mnnit.ac.in</a>
                </p>
                <p><i class="fa fa-linkedin"></i>
                    <a href="https://www.linkedin.com/in/prashant-kumar-singh-972041306/" target="_blank">prashant-kumar-singh-972041306</a>
                </p>
                <p><i class="fa fa-github"></i>
                    <a href="https://github.com/PrashantA7985" target="_blank">github.com/PrashantA7985</a>
                </p>
            </div>

            <div class="developer-card">
                <img src="dev3.jpg" alt="Developer 3" class="dev-photo">
                <h3>👨‍💻 Shashank Tiwari</h3>
                <p><strong>Branch:</strong> Computer Science and Engineering</p>
                <p><strong>College:</strong> MNNIT Allahabad</p>
                <p><i class="fa fa-envelope"></i>
                    <a href="mailto:shashank2024@mnnit.ac.in">shashank2024@mnnit.ac.in</a>
                </p>
                <p><i class="fa fa-linkedin"></i>
                    <a href="https://www.linkedin.com/in/tshashank620" target="_blank">linkedin.com/in/tshashank620</a>
                </p>
                <p><i class="fa fa-github"></i>
                    <a href="https://github.com/Shashank14081997" target="_blank">github.com/Shashank14081997</a>
                </p>
            </div>
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