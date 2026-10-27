<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Elite - About Us</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f7f6;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: #0d1b2a;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: #adb5bd;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        nav ul li a:hover {
            color: white;
        }

        .container {
            flex: 1;
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
        }

        .about-card {
            background: #fff;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            text-align: center;
        }

        .about-card h2 {
            color: #0d1b2a;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .about-card p {
            color: #6c757d;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .location-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
        }

        .location-card h3 {
            margin-bottom: 8px;
            color: #0d1b2a;
            font-size: 1.4rem;
        }

        .location-card p {
            color: #6c757d;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .map-wrapper {
            overflow: hidden;
            border-radius: 6px;
            height: 350px;
            border: 1px solid #e9ecef;
        }

        .map-wrapper iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        footer {
            background: #0d1b2a;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Hotel Elite</div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="food.php">Dining</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php" style="color: #e74c3c;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="about-card">
            <h2>About Hotel Elite, Ahmedabad</h2>
            <p>
                Welcome to Hotel Elite located in the heart of Ahmedabad, Gujarat. We combine modern luxury with traditional Gujarati hospitality to offer an unforgettable stay.
            </p>
        </div>

        <div class="location-card">
            <h3>Our Location</h3>
            <p>CG Road, Navrangpura, Ahmedabad, Gujarat 380009</p>
            
            <div class="map-wrapper">
                <iframe 
                    allowfullscreen="" 
                    loading="lazy" 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.865672045617!2d72.55776!3d23.03386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84f526ea29d7%3A0x854e4c9f1a07011b!2sC%20G%20Rd%2C%20Navrangpura%2C%20Ahmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1650000000000!5m2!1sen!2sin">
                </iframe>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Hotel Elite. All Rights Reserved.</p>
    </footer>

</body>
</html>