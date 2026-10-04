<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Elite - Our Rooms</title>
    <link rel="stylesheet" href="style.css">
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
        <h2 style="text-align: center; 
		margin-bottom: 30px;
		color: #0d1b2a;">Our Luxurious Rooms</h2>
        
        <div style="display: grid; 
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
		gap: 30px;">
            
            <div style="background: #fff;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32" alt="Standard Room" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3>Standard Room</h3>
                    <p style="font-weight: bold;
					color: #f39c12;
					margin: 5px 0 10px 0;">₹1,800 / night</p>
                    <p style="color: #666;
					font-size: 0.95rem;
					margin-bottom: 15px;">Queen Bed, Free Wi-Fi, LED TV & Attached Bathroom.</p>
                    
                    <a href="standard-room.php" class="btn" style="width: 100%;
					text-align: center;
					display: block; 
					margin-bottom: 10px;
					background-color: #0d1b2a;">View Room</a>
                    <a href="booking.php" class="btn" style="width: 100%;
					text-align: center;
					display: block;">Book Now</a>
                </div>
            </div>

            <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b" alt="Deluxe Room" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3>Deluxe Room</h3>
                    <p style="font-weight: bold;
					color: #f39c12; 
					margin: 5px 0 10px 0;">₹2,500 / night</p>
                    <p style="color: #666;
					font-size: 0.95rem;
					margin-bottom: 15px;">King Bed, High-Speed WI-FI, AC & 24/7 Room Service.</p>
                    
                    <a href="deluxe-room.php" class="btn" style="width: 100%;
					text-align: center;
					display: block;
					margin-bottom: 10px; 
					background-color: #0d1b2a;">View Room</a>
                    <a href="booking.php" class="btn" style="width: 100%; 
					text-align: center;
					display: block;">Book Now</a>
                </div>
            </div>

            <div style="background: #fff;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <img src="https://images.unsplash.com/photo-1591088398332-8a7791972843" alt="Executive Suite" 
				style="width: 100%;
				height: 200px;
				object-fit: cover;">
                <div style="padding: 20px;">
                    <h3>Executive Suite</h3>
                    <p style="font-weight: bold;
					color: #f39c12;
					margin: 5px 0 10px 0;">₹3,800 / night</p>
                    <p style="color: #666;
					font-size: 0.95rem;
					margin-bottom: 15px;">City View, Mini Bar, Free Breakfast & Balcony.</p>
                    
                    <a href="suite-room.php" class="btn"
					style="width: 100%;
					text-align: center;
					display: block;
					margin-bottom: 10px;
					background-color: #0d1b2a;">View Room</a>
                    <a href="booking.php" class="btn" 
					style="width: 100%;
					text-align: center;
					display: block;">Book Now</a>
                </div>
            </div>

        </div>
    </div>

    <footer>
        <p>&copy; 2026 Hotel Elite. All Rights Reserved.</p>
    </footer>

</body>
</html>