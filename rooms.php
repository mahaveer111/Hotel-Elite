<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms & Suites - Hotel Elite</title>
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

        .container { 
            max-width: 1100px; 
            margin: 30px auto; 
            padding: 0 20px; 
            width: 100%;
            flex: 1;
        }

        .page-title { 
            text-align: center; 
            color: #0d1b2a; 
            margin-bottom: 30px; 
            font-size: 2rem; 
        }

        .rooms-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 25px; 
        }

        .room-card { 
            background: #fff; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            transition: transform 0.2s; 
        }

        .room-card:hover { 
            transform: translateY(-4px); 
        }

        .room-img { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
            background: #e9ecef;
        }

        .room-body { 
            padding: 20px; 
            text-align: left; 
        }

        .room-badge { 
            background: #f39c12; 
            color: #fff; 
            padding: 4px 12px; 
            border-radius: 15px; 
            font-size: 0.75rem; 
            font-weight: bold; 
            display: inline-block; 
            margin-bottom: 10px; 
        }

        .room-title { 
            font-size: 1.25rem; 
            color: #0d1b2a; 
            margin-bottom: 8px; 
            font-weight: bold; 
        }

        .room-info { 
            font-size: 0.85rem; 
            color: #6c757d; 
            margin-bottom: 6px; 
        }

        .room-price { 
            font-size: 1.3rem; 
            color: #28a745; 
            font-weight: bold; 
            margin: 15px 0; 
        }

        .room-btns { 
            display: flex; 
            gap: 10px; 
        }

        .btn { 
            flex: 1; 
            text-align: center; 
            padding: 10px; 
            border-radius: 5px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 0.9rem; 
            transition: background 0.2s;
        }

        .btn-details { 
            background: #0d1b2a; 
            color: white; 
        }

        .btn-details:hover {
            background: #1b263b;
        }

        .btn-book { 
            background: #28a745; 
            color: white; 
        }

        .btn-book:hover {
            background: #218838;
        }

        footer { 
            background: #0d1b2a; 
            color: white; 
            text-align: center; 
            padding: 20px; 
            margin-top: auto; 
            font-size: 0.9rem;
            border-top: 1px solid #1b263b;
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
                <li><a href="my_bookings.php">My Bookings</a></li>
                <li><a href="food.php">Dining</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php 
                if (isset($_SESSION['user_email'])) {
                    echo '<li><a href="logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>';
                } else {
                    echo '<li><a href="index.php" style="color: #f39c12; font-weight: bold;">Login</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2 class="page-title">Our Exclusive Rooms & Suites</h2>
        <div class="rooms-grid">
            <?php
            $result = $conn->query("SELECT * FROM rooms ORDER BY id ASC");
            if ($result && $result->num_rows > 0) {
                while($room = $result->fetch_assoc()) {
                    $bed = !empty($room['bed_type']) ? $room['bed_type'] : 'King Size Bed';
                    $img = !empty($room['image']) ? $room['image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32';
                    
                    if (isset($_SESSION['user_email'])) {
                        $book_link = "booking.php?room_id=" . $room['id'];
                    } else {
                        $book_link = "index.php";
                    }
                    
                    echo '<div class="room-card">
                            <img src="'.$img.'" alt="'.$room['room_type'].'" class="room-img">
                            <div class="room-body">
                                <span class="room-badge">Room No: '.$room['room_no'].'</span>
                                <div class="room-title">'.$room['room_type'].'</div>
                                <div class="room-info">🛏️ Bed Type: <b>'.$bed.'</b></div>
                                <div class="room-price">₹'.$room['price'].' <span style="font-size:12px; color:#6c757d;">/ night</span></div>
                                <div class="room-btns">
                                    <a href="standard-room.php?id='.$room['id'].'" class="btn btn-details">View Details</a>
                                    <a href="'.$book_link.'" class="btn btn-book">Book Now</a>
                                </div>
                            </div>
                          </div>';
                }
            } else {
                echo "<p style='text-align:center;'>No rooms found.</p>";
            }
            ?>
        </div>
    </div>
    <footer><p>&copy; 2026 Hotel Elite. All Rights Reserved.</p></footer>
</body>
</html>