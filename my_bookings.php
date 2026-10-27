<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', 1);

session_start();
include('db.php');

if (!isset($_SESSION['user_email']) || empty($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$logged_in_email = $_SESSION['user_email'];
$logged_in_name = $_SESSION['user_name'] ?? '';

$room_search = isset($_GET['room_search']) ? trim($_GET['room_search']) : "";
$room_date = isset($_GET['room_date']) ? trim($_GET['room_date']) : "";

$food_search = isset($_GET['food_search']) ? trim($_GET['food_search']) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings & Orders - Hotel Elite</title>
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
            background: #fff; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            width: 100%;
            flex: 1;
        }

        h2 { 
            color: #0d1b2a; 
            margin-bottom: 5px; 
            font-size: 1.8rem;
        }

        p { 
            color: #6c757d; 
            margin-bottom: 25px; 
            font-size: 0.95rem;
        }
        
        .tab-buttons { 
            display: flex; 
            gap: 12px; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #e9ecef; 
            padding-bottom: 15px; 
        }

        .tab-btn { 
            background: #e9ecef; 
            color: #495057; 
            border: none; 
            padding: 10px 22px; 
            font-size: 0.95rem; 
            font-weight: bold; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: all 0.2s; 
        }

        .tab-btn.active { 
            background: #0d1b2a; 
            color: white; 
        }

        .tab-btn:hover { 
            background: #007bff; 
            color: white; 
        }

        .section-box { display: none; }
        .section-box.active { display: block; }

        .filter-form { 
            display: flex; 
            gap: 10px; 
            margin-bottom: 20px; 
            flex-wrap: wrap; 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 6px; 
            border: 1px solid #e9ecef; 
        }

        .filter-form input { 
            flex: 1; 
            min-width: 180px; 
            padding: 10px 12px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.9rem; 
        }

        .filter-form input:focus {
            border-color: #007bff;
            outline: none;
        }

        .filter-form button { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            font-weight: bold; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: background 0.2s;
        }

        .filter-form button:hover { 
            background: #0056b3; 
        }

        .filter-form a { 
            background: #6c757d; 
            color: white; 
            padding: 10px 16px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
            display: inline-flex; 
            align-items: center; 
            font-size: 0.9rem; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            margin-bottom: 25px; 
        }

        th, td { 
            border: 1px solid #e9ecef; 
            padding: 12px 10px; 
            text-align: center; 
            font-size: 0.9rem; 
        }

        th { 
            background: #007bff; 
            color: white; 
            font-weight: 600;
        }

        tr:nth-child(even) { 
            background: #fdfdfe; 
        }

        tr:hover {
            background: #f1f4f8;
        }

        .status-btn { 
            background: #28a745; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 4px; 
            font-size: 0.75rem; 
            font-weight: bold; 
            display: inline-block; 
        }

        .top-links { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 20px; 
        }

        .top-links a { 
            text-decoration: none; 
            color: #007bff; 
            font-weight: bold; 
            font-size: 0.9rem;
        }

        .top-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="rooms.php" style="background: #ffffff; color: #0d1b2a; padding: 6px 14px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">&larr; Back</a>
            <div class="logo">Hotel Elite</div>
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="food.php">Dining</a></li>
                <li><a href="my_bookings.php" style="color: white; font-weight: bold;">My Bookings</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="top-links">
            <a href="rooms.php">&larr; Back to Rooms</a>
            <a href="home.php">Home</a>
        </div>

        <h2>My Bookings & Orders Dashboard</h2>
        <p>Click between the two buttons below to easily view your Room Bookings or Food Orders separately:</p>

        <div class="tab-buttons">
            <button class="tab-btn active" onclick="switchTab('rooms-tab', this)">Room Bookings</button>
            <button class="tab-btn" onclick="switchTab('food-tab', this)">Food Orders</button>
        </div>

        <div id="rooms-tab" class="section-box active">
            <h3 style="color: #0d1b2a; margin-bottom: 15px; font-size: 1.3rem;">Room Bookings History</h3>
            
            <form method="GET" action="" class="filter-form">
                <input type="text" name="room_search" placeholder="Search room by name, email or phone..." value="<?php echo htmlspecialchars($room_search); ?>">
                <input type="date" name="room_date" value="<?php echo htmlspecialchars($room_date); ?>">
                <button type="submit">Filter Rooms</button>
                <?php if(!empty($room_search) || !empty($room_date)): ?>
                    <a href="my_bookings.php">Reset</a>
                <?php endif; ?>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room Name</th>
                        <th>Guest Name</th>
                        <th>Phone / Email</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total Bill</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $room_query = "SELECT b.*, r.room_type 
                                   FROM room_bookings b 
                                   LEFT JOIN rooms r ON b.room_id = r.id 
                                   WHERE (b.user_email = '$logged_in_email'";
                    
                    if (!empty($logged_in_name)) {
                        $safe_name = mysqli_real_escape_string($conn, $logged_in_name);
                        $room_query .= " OR b.user_name = '$safe_name'";
                    }
                    $room_query .= ")";

                    if (!empty($room_search)) {
                        $safe_r_search = mysqli_real_escape_string($conn, $room_search);
                        $room_query .= " AND (b.user_name LIKE '%$safe_r_search%' OR b.user_email LIKE '%$safe_r_search%' OR b.phone LIKE '%$safe_r_search%')";
                    }

                    if (!empty($room_date)) {
                        $safe_r_date = mysqli_real_escape_string($conn, $room_date);
                        $room_query .= " AND DATE(b.check_in) = '$safe_r_date'";
                    }

                    $room_query .= " ORDER BY b.id DESC";
                    $room_result = $conn->query($room_query);

                    if ($room_result && $room_result->num_rows > 0) {
                        while ($row = $room_result->fetch_assoc()) {
                            $room_display = !empty($row['room_type']) ? $row['room_type'] : "Standard Room";
                            $name_display = !empty($row['user_name']) ? $row['user_name'] : "N/A";
                            $contact_display = ($row['phone'] ?? '') . "<br><small style='color:#6c757d;'>" . ($row['user_email'] ?? '') . "</small>";
                            $check_in = !empty($row['check_in']) ? $row['check_in'] : "N/A";
                            $check_out = !empty($row['check_out']) ? $row['check_out'] : "N/A";
                            $total = !empty($row['total_price']) ? "₹" . number_format($row['total_price'], 2) : "₹0.00";
                            $payment_status = !empty($row['payment_status']) ? $row['payment_status'] : "Confirmed";

                            echo "<tr>";
                            echo "<td><b>#" . $row['id'] . "</b></td>";
                            echo "<td><b>" . $room_display . "</b></td>";
                            echo "<td>" . $name_display . "</td>";
                            echo "<td>" . $contact_display . "</td>";
                            echo "<td style='color: #28a745; font-weight: bold;'>" . $check_in . "</td>";
                            echo "<td style='color: #dc3545; font-weight: bold;'>" . $check_out . "</td>";
                            echo "<td><b>" . $total . "</b></td>";
                            echo "<td><span class='status-btn'>" . $payment_status . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No room bookings found!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="food-tab" class="section-box">
            <h3 style="color: #0d1b2a; margin-bottom: 15px; font-size: 1.3rem;">Food Orders History</h3>

            <form method="GET" action="" class="filter-form">
                <input type="text" name="food_search" placeholder="Search food by customer name or room no..." value="<?php echo htmlspecialchars($food_search); ?>">
                <button type="submit">Filter Food</button>
                <?php if(!empty($food_search)): ?>
                    <a href="my_bookings.php">Reset</a>
                <?php endif; ?>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Room No</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Payment Mode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $food_query = "SELECT * FROM food_orders WHERE 1=1";

                    if (!empty($logged_in_name)) {
                        $safe_food_name = mysqli_real_escape_string($conn, $logged_in_name);
                        $food_query .= " AND (customer_name LIKE '%$safe_food_name%' OR user_name LIKE '%$safe_food_name%')";
                    }

                    if (!empty($food_search)) {
                        $safe_f_search = mysqli_real_escape_string($conn, $food_search);
                        $food_query .= " AND (customer_name LIKE '%$safe_f_search%' OR room_no LIKE '%$safe_f_search%')";
                    }

                    $food_query .= " ORDER BY id DESC";
                    $food_result = $conn->query($food_query);

                    if ($food_result && $food_result->num_rows > 0) {
                        while ($frow = $food_result->fetch_assoc()) {
                            $c_name = $frow['customer_name'] ?? $frow['user_name'] ?? "N/A";
                            echo "<tr>";
                            echo "<td><b>#" . $frow['id'] . "</b></td>";
                            echo "<td>" . $c_name . "</td>";
                            echo "<td>" . ($frow['room_no'] ?? 'N/A') . "</td>";
                            echo "<td style='text-align: left;'>" . ($frow['items'] ?? '') . "</td>";
                            echo "<td><b>₹" . number_format(($frow['total_amount'] ?? 0), 2) . "</b></td>";
                            echo "<td>" . ($frow['payment_mode'] ?? 'Cash') . "</td>";
                            echo "<td><span class='status-btn'>" . ($frow['status'] ?? 'Ordered') . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No food orders found!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function switchTab(tabId, btn) {
            let sections = document.querySelectorAll('.section-box');
            sections.forEach(sec => sec.classList.remove('active'));

            let buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(b => b.classList.remove('active'));

            document.getElementById(tabId).classList.add('active');
            btn.classList.add('active');
        }
    </script>
</body>
</html>