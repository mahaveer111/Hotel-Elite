<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('db.php');

$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$result = $conn->query("SELECT * FROM rooms WHERE id = $room_id");

if ($result && $result->num_rows > 0) {
    $room = $result->fetch_assoc();
} else {
    $result = $conn->query("SELECT * FROM rooms LIMIT 1");
    $room = $result->fetch_assoc();
}

$room_name = $room['room_type'] ?? 'Room Details';
$room_price = $room['price'] ?? '1,800';
$bed_type = !empty($room['bed_type']) ? $room['bed_type'] : 'Queen Size Bed';
$room_no = $room['room_no'] ?? '101';
$room_img = !empty($room['image']) ? $room['image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - <?php echo htmlspecialchars($room_name); ?></title>
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
            display: flex; 
            list-style: none; 
            gap: 20px; 
            align-items: center; 
            margin: 0; 
            padding: 0; 
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

        .back-btn-container { 
            max-width: 1100px; 
            margin: 20px auto 0 auto; 
            padding: 0 20px; 
            width: 100%;
        }

        .btn-back { 
            display: inline-block; 
            background: #6c757d; 
            color: #fff; 
            padding: 8px 16px; 
            border-radius: 5px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 0.9rem; 
            transition: background 0.2s;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .container {
            max-width: 1100px; 
            margin: 20px auto; 
            padding: 0 20px; 
            width: 100%;
            flex: 1;
        }

        .room-header { 
            background: linear-gradient(rgba(13, 27, 42, 0.8), rgba(13, 27, 42, 0.8)), url('<?php echo htmlspecialchars($room_img); ?>'); 
            background-size: cover; 
            background-position: center; 
            color: white; 
            padding: 50px 20px; 
            text-align: center; 
            border-radius: 8px; 
            margin-bottom: 30px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .room-header h2 { 
            font-size: 2.2rem; 
            margin-bottom: 10px; 
        }

        .badge { 
            background: #f39c12; 
            color: #fff; 
            padding: 6px 16px; 
            border-radius: 20px; 
            font-weight: bold; 
            display: inline-block; 
            margin-bottom: 12px; 
            font-size: 0.85rem;
        }

        .price { 
            font-size: 1.8rem; 
            color: #f39c12; 
            font-weight: bold; 
            margin-top: 10px; 
        }

        .room-info-highlight { 
            background: rgba(255, 255, 255, 0.15); 
            display: inline-block; 
            padding: 8px 20px; 
            border-radius: 5px; 
            margin-top: 15px; 
            font-size: 0.95rem; 
            color: #fff; 
            border: 1px solid rgba(243, 156, 18, 0.4); 
        }

        .content-box { 
            background: #fff; 
            padding: 35px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            margin-bottom: 30px; 
            text-align: center; 
        }

        .content-box h3 {
            color: #0d1b2a; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #f39c12; 
            display: inline-block; 
            padding-bottom: 5px; 
            font-size: 1.4rem;
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
            gap: 12px; 
            font-size: 0.95rem; 
            color: #495057; 
            background: #f8f9fa; 
            padding: 12px 15px; 
            border-radius: 5px; 
            border: 1px solid #e9ecef;
        }

        .amenity-item span { 
            color: #28a745; 
            font-weight: bold; 
            font-size: 1.1rem; 
        }

        .btn-book { 
            background: #f39c12; 
            color: #fff; 
            padding: 12px 35px; 
            font-size: 1.05rem; 
            border-radius: 5px; 
            text-decoration: none; 
            font-weight: bold; 
            display: inline-block; 
            transition: background 0.2s;
        }

        .btn-book:hover {
            background: #d35400;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Hotel Elite</div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="rooms.php" style="color: white; font-weight: bold;">Rooms</a></li>
                <li><a href="food.php">Dining</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="back-btn-container">
        <a href="rooms.php" class="btn-back">&larr; Back to Rooms</a>
    </div>

    <div class="container">
        <div class="room-header">
            <span class="badge"><?php echo htmlspecialchars($room_name); ?></span>
            <h2>Cozy & Comfortable Stay</h2>
            <p style="margin-bottom: 10px; font-size: 1.05rem; color: #cbd5e1;">Room No: <?php echo htmlspecialchars($room_no); ?></p>
            <div class="price">₹<?php echo number_format((float)$room_price); ?> <span style="font-size: 0.9rem; color: #adb5bd;">/ night</span></div>
            
            <div class="room-info-highlight">
                🛏️ Bed Type: <b><?php echo htmlspecialchars($bed_type); ?></b> &nbsp;|&nbsp; 👥 Capacity: Max 2-3 Persons
            </div>
        </div>

        <div class="content-box">
            <h3>Room Facilities & Amenities</h3>
            <div class="amenities-grid">
                <div class="amenity-item"><span>✓</span> Bed Type: <?php echo htmlspecialchars($bed_type); ?></div>
                <div class="amenity-item"><span>✓</span> High-Speed Free Wi-Fi</div>
                <div class="amenity-item"><span>✓</span> LED Smart TV with OTT</div>
                <div class="amenity-item"><span>✓</span> Individual AC & Heating</div>
                <?php if($room_price >= 3800) { ?>
                    <div class="amenity-item"><span>✓</span> Private Jacuzzi & Bathtub</div>
                    <div class="amenity-item"><span>✓</span> Mini-Bar & Refrigerator</div>
                    <div class="amenity-item"><span>✓</span> 24/7 Personal Butler Service</div>
                <?php } else { ?>
                    <div class="amenity-item"><span>✓</span> Tea & Coffee Maker Kit</div>
                    <div class="amenity-item"><span>✓</span> Attached Modern Bathroom</div>
                <?php } ?>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 40px;">
            <a href="booking.php?room_id=<?php echo $room['id']; ?>" class="btn-book">Book This Room Now</a>
        </div>
    </div>
</body>
</html>