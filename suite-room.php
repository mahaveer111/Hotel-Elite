<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Elite - Executive Suite Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .room-header {
            background: linear-gradient(rgba(13, 27, 42, 0.8), rgba(13, 27, 42, 0.8)), url('https://images.unsplash.com/photo-1591088398332-8a7791972843');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .room-header h2 {
			font-size: 2.5rem; 
			margin-bottom: 10px; 
			}
        .badge {
			background: #f39c12;
			color: #fff;
			padding: 6px 15px;
			border-radius: 20px;
			font-weight: bold;
			display: inline-block;
			margin-bottom: 10px;
			}
        .price {
			font-size: 1.8rem;
			color: #f39c12;
			font-weight: bold; 
			}
        
        .content-box {
            background: #fff;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            text-align: center;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .gallery-grid img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-grid img:hover { 
		transform: scale(1.03); 
		}

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 15px;
            margin-top: 20px;
            text-align: left;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .amenity-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.05rem;
            color: #444;
            background: #f9f9f9;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .amenity-item span {
			color: #27ae60;
			font-weight: bold;
			font-size: 1.2rem;
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
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php" style="color: #e74c3c;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        
       
        <div class="room-header">
            <span class="badge">Executive Suite</span>
            <h2>Ultimate Luxury & Comfort</h2>
            <p style="margin-bottom: 15px; 
			font-size: 1.1rem;
			color: #ddd;">Room Size: 500+ sq. ft. (Living Area + Bedroom)</p>
            <div class="price">₹3,800 <span 
			style="font-size: 1rem;
			color: #ccc;">/ night</span></div>
        </div>

        
        <div class="content-box">
            <h3 style="color: #0d1b2a; margin-bottom: 10px; border-bottom: 2px solid #f39c12; display: inline-block; padding-bottom: 5px;">Room Gallery</h3>
            <div class="gallery-grid">
                <img src="https://images.unsplash.com/photo-1591088398332-8a7791972843" alt="Suite View 1">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b" alt="Suite View 2">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" alt="Suite View 3">
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32" alt="Suite View 4">
            </div>
        </div>

     
        <div class="content-box">
            <h3 style="color: #0d1b2a; margin-bottom: 10px; border-bottom: 2px solid #f39c12; display: inline-block; padding-bottom: 5px;">Room Facilities & Amenities</h3>
            
            <div class="amenities-grid">
                <div class="amenity-item"><span>✓</span> King Size Luxury Bed (Orthopedic)</div>
                <div class="amenity-item"><span>✓</span> Private Jacuzzi & Bathtub</div>
                <div class="amenity-item"><span>✓</span> Unlimited High-Speed Wi-Fi</div>
                <div class="amenity-item"><span>✓</span> Espresso Coffee Machine</div>
                <div class="amenity-item"><span>✓</span> Large Smart TV with Channels</div>
                <div class="amenity-item"><span>✓</span> 24/7 Personal Butler Service</div>
                <div class="amenity-item"><span>✓</span> Centralized AC & Smart Heating</div>
                <div class="amenity-item"><span>✓</span> Luxury Bathrobes & Toiletries</div>
                <div class="amenity-item"><span>✓</span> Electronic Safe Locker</div>
                <div class="amenity-item"><span>✓</span> Scenic City Skyline View</div>
                <div class="amenity-item"><span>✓</span> Free Breakfast & Evening Snacks</div>
            </div>
        </div>

     
        <div 
		style="text-align: center; 
		margin-bottom: 40px;">
            <a href="booking.php" class="btn"
			style="padding: 15px 40px;
			font-size: 1.2rem;
			background: #f39c12; 
			color: #fff;
			border-radius: 5px;
			text-decoration: none;
			font-weight: bold;
			box-shadow: 0 4px 10px rgba(243,156,18,0.3);">Book This Room Now</a>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 Hotel Elite. All Rights Reserved.</p>
    </footer>

</body>
</html>