<?php
// Database connection include karein ya direct connect karein
$conn = mysqli_connect("localhost", "root", "", "mahavir");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Elite - Room Availability</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .page-header {
            background: linear-gradient(rgba(13, 27, 42, 0.8), rgba(13, 27, 42, 0.8)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .page-header h2 {
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
			}

        .content-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: left;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #0d1b2a;
            color: white;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        tr:hover { 
		background-color: #f9f9f9;
		}

        /* Status Badges */
        .status-available {
            background-color: #27ae60;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .status-booked {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
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
                <li><a href="room-availability.php" style="color: #f39c12;">Availability</a></li>
                <li><a href="food.php">Dining</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php" style="color: #e74c3c;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container" style="width: 85%; margin: 20px auto;">
        
        <div class="page-header">
            <span class="badge">Live Tracking</span>
            <h2>Room Availability Status</h2>
            <p style="margin-top: 10px; color: #ddd;">Check current occupancy status across all floors dynamically.</p>
        </div>

        <div class="content-box">
            <h3 style="color: #0d1b2a;
			margin-bottom: 20px;
			border-bottom: 2px solid #f39c12; 
			display: inline-block;
			padding-bottom: 5px;">All Rooms Status</h3>
            
            <table>
                <thead>
                    <tr>
                        <th>Room No</th>
                        <th>Floor</th>
                        <th>Room Type</th>
                        <th>Room Status</th>
                        <th>Booking Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT r.room_no, r.floor, r.room_type, r.room_status, 
                              CASE WHEN rb.id IS NOT NULL THEN 'Booked' ELSE 'Available' END as booking_status
                              FROM rooms r 
                              LEFT JOIN room_bookings rb ON r.room_no = rb.room_no AND rb.checkout_date >= CURDATE()";
                    
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0)
						{
                        while($row = mysqli_fetch_assoc($result)) 
						{
                            $badgeClass = ($row['booking_status'] == 'Available') ? 'status-available' : 'status-booked';
                            
                            echo "<tr>";
                            echo "<td><strong>" . $row['room_no'] . "</strong></td>";
                            echo "<td>" . $row['floor'] . "</td>";
                            echo "<td>" . $row['room_type'] . "</td>";
                            echo "<td>" . $row['room_status'] . "</td>";
                            echo "<td><span class='" . $badgeClass . "'>" . $row['booking_status'] . "</span></td>";
                            echo "</tr>";
                        }
                    } 
					else 
					{
                        echo "<tr><td colspan='5' style='text-align:center;'>No rooms found in database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <footer>
        <p style="text-align:center; padding: 20px; color: #666;">&copy; 2026 Hotel Elite. All Rights Reserved.</p>
    </footer>

</body>
</html>