<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Home</title>
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

    <section style="background: linear-gradient(rgba(0,0,0,0.5),
	rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945');
	background-size: cover;
	background-position: center;
	color: white;
	text-align: center;
	padding: 100px 20px;">
        <h1>Experience Ultimate Luxury</h1>
        <p>Book your stay with us in Ahmedabad and enjoy world-class hospitality.</p>
        <a href="rooms.php" class="btn" style="display: inline-block; 
		width: auto;
		padding: 12px 30px; 
		margin-top: 20px;">Book a Room Now</a>
    </section>

    <div class="container">
        <h2 style="text-align: center;
		margin-bottom: 30px;
		color: #0d1b2a;">Our Featured Services</h2>
        <div style="display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		gap: 20px;">
            <div style="background: #fff;
			padding: 20px;
			border-radius: 6px; 
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <h3>Luxury Rooms</h3>
                <p>Spacious rooms equipped with modern amenities and premium city views.</p>
            </div>
            <div style="background: #fff;
			padding: 20px;
			border-radius: 6px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <h3>Fine Dining</h3>
                <p>Enjoy multi-cuisine delicacies prepared by master chefs with 24/7 room service.</p>
            </div>
            <div style="background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <h3>Prime Location</h3>
                <p>Located on CG Road, Navrangpura, Ahmedabad, close to top business hubs.</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Hotel Elite, Ahmedabad. All Rights Reserved.</p>
    </footer>

</body>
</html>