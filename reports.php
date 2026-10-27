<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin']) && !isset($_SESSION['staff_email'])) {
    header("Location: login.php");
    exit();
}

$room_search = isset($_GET['room_search']) ? trim($_GET['room_search']) : "";
$food_search = isset($_GET['food_search']) ? trim($_GET['food_search']) : "";
$room_month = isset($_GET['room_month']) ? trim($_GET['room_month']) : "";
$food_month = isset($_GET['food_month']) ? trim($_GET['food_month']) : "";

$b_rev_sql = "SELECT SUM(total_price) as total_booking_amt FROM room_bookings WHERE 1=1";
if(!empty($room_month)) {
    $b_rev_sql .= " AND check_in LIKE '$room_month%'";
}
$booking_total_query = $conn->query($b_rev_sql);
$booking_row = $booking_total_query->fetch_assoc();
$grand_booking_income = $booking_row['total_booking_amt'] ?? 0;

$f_rev_sql = "SELECT SUM(total_amount) as total_food_amt FROM food_orders WHERE 1=1";
if(!empty($food_month)) {
}
$food_total_query = $conn->query($f_rev_sql);
$food_row = $food_total_query->fetch_assoc();
$grand_food_income = $food_row['total_food_amt'] ?? 0;

$total_overall_revenue = $grand_booking_income + $grand_food_income;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports & Analytics - Hotel Management</title>
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

        .logout-box a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .logout-box a:hover {
            color: #c0392b;
        }

        .main-wrapper {
            display: flex;
            flex: 1;
        }

        aside {
            width: 240px;
            background: #1b263b;
            padding: 25px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        aside ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        aside ul li a {
            display: block;
            color: #adb5bd;
            text-decoration: none;
            padding: 12px 25px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease-in-out;
        }

        aside ul li a:hover, 
        aside ul li a.active {
            background: #007bff;
            color: white;
            border-left: 5px solid #f39c12;
        }

        .content {
            flex: 1;
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
        }

        .top-bar { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
        }

        h2 { 
            color: #0d1b2a; 
            font-size: 1.8rem;
        }

        .btn-back { 
            background: #6c757d; 
            color: white; 
            padding: 8px 16px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
            font-size: 0.9rem; 
            transition: background 0.2s;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .btn-print { 
            background: #28a745; 
            color: white; 
            padding: 8px 16px; 
            border: none; 
            border-radius: 5px; 
            font-weight: bold; 
            font-size: 0.9rem; 
            cursor: pointer; 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
            text-decoration: none; 
            transition: background 0.2s;
        }

        .btn-print:hover {
            background: #218838;
        }
        
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }

        .stat-card { 
            background: #fff; 
            padding: 22px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            border-left: 5px solid #007bff; 
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card.food { border-left-color: #28a745; }
        .stat-card.total { border-left-color: #ffc107; }

        .stat-card h4 { 
            margin: 0 0 10px 0; 
            color: #6c757d; 
            font-size: 0.95rem; 
        }

        .stat-card p { 
            margin: 0; 
            font-size: 1.6rem; 
            font-weight: bold; 
            color: #0d1b2a; 
        }

        .tab-buttons { 
            display: flex; 
            gap: 12px; 
            margin-bottom: 25px; 
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

        .report-section { 
            display: none; 
            background: #fff; 
            padding: 25px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            margin-bottom: 30px; 
        }

        .report-section.active { display: block; }

        .report-section h3 { 
            margin-top: 0; 
            color: #0d1b2a; 
            border-bottom: 2px solid #e9ecef; 
            padding-bottom: 12px; 
            margin-bottom: 20px;
        }
        
        .filter-form { 
            display: flex; 
            gap: 10px; 
            margin-bottom: 20px; 
            flex-wrap: wrap; 
        }

        .filter-form input, 
        .filter-form select { 
            padding: 10px 12px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.9rem; 
            flex: 1; 
            min-width: 160px; 
        }

        .filter-form input:focus, 
        .filter-form select:focus {
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

        .badge { 
            padding: 5px 10px; 
            border-radius: 4px; 
            font-size: 0.75rem; 
            font-weight: bold; 
            color: white; 
            background: #28a745; 
            display: inline-block;
        }

        @media print {
            header, aside, .top-bar, .tab-buttons, .filter-form, .btn-back, .btn-print { display: none !important; }
            .report-section { display: block !important; box-shadow: none; border: none; margin: 0; padding: 0; }
            body { background: white; }
            .main-wrapper { display: block; }
            .content { margin: 0; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Hotel Elite - Management</div>
        <div class="logout-box">
            <a href="login.php">Logout</a>
        </div>
    </header>

    <div class="main-wrapper">
        <aside>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="booking_management.php">Bookings</a></li>
                <li><a href="food_orders.php">Food Orders</a></li>
                <li><a href="reports.php" class="active">Reports</a></li>
            </ul>
        </aside>

        <div class="content">
            <div class="top-bar">
                <h2>Financial & Order Reports</h2>
                <div style="display: flex; gap: 10px;">
                    <button class="btn-print" onclick="window.print()">Print Report</button>
                    <a href="dashboard.php" class="btn-back">&larr; Back to Dashboard</a>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h4>Total Room Bookings Revenue</h4>
                    <p>₹<?php echo number_format($grand_booking_income, 2); ?></p>
                </div>
                <div class="stat-card food">
                    <h4>Total Food Orders Revenue</h4>
                    <p>₹<?php echo number_format($grand_food_income, 2); ?></p>
                </div>
                <div class="stat-card total">
                    <h4>Grand Total Revenue</h4>
                    <p>₹<?php echo number_format($total_overall_revenue, 2); ?></p>
                </div>
            </div>

            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchReport('room-report', this)"> Room Bookings Report</button>
                <button class="tab-btn" onclick="switchReport('food-report', this)">Food Orders Report</button>
            </div>

            <div id="room-report" class="report-section active">
                <h3>Room Bookings Report</h3>
                
                <form method="GET" action="" class="filter-form">
                    <input type="text" name="room_search" placeholder="Search user name, room type..." value="<?php echo htmlspecialchars($room_search); ?>">
                    <input type="month" name="room_month" value="<?php echo htmlspecialchars($room_month); ?>">
                    <button type="submit">Filter Report</button>
                    <?php if(!empty($room_search) || !empty($room_month)): ?>
                        <a href="reports.php">Reset</a>
                    <?php endif; ?>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $booking_query = "SELECT rb.*, r.room_type FROM room_bookings rb LEFT JOIN rooms r ON rb.room_id = r.id WHERE 1=1";
                        
                        if (!empty($room_search)) {
                            $safe_r_search = mysqli_real_escape_string($conn, $room_search);
                            $booking_query .= " AND (rb.user_name LIKE '%$safe_r_search%' OR r.room_type LIKE '%$safe_r_search%')";
                        }

                        if (!empty($room_month)) {
                            $safe_month = mysqli_real_escape_string($conn, $room_month);
                            $booking_query .= " AND rb.check_in LIKE '$safe_month%'";
                        }

                        $booking_query .= " ORDER BY rb.id DESC";
                        
                        $b_result = $conn->query($booking_query);
                        if ($b_result && $b_result->num_rows > 0) {
                            while ($row = $b_result->fetch_assoc()) {
                                $name = $row['user_name'] ?? "N/A";
                                $room = $row['room_type'] ?? "Room #" . ($row['room_id'] ?? 'N/A');
                                $in = $row['check_in'] ?? "N/A";
                                $out = $row['check_out'] ?? "N/A";
                                $price = $row['total_price'] ?? 0;

                                echo "<tr>";
                                echo "<td>#" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($name) . "</td>";
                                echo "<td><b>" . htmlspecialchars($room) . "</b></td>";
                                echo "<td>" . htmlspecialchars($in) . "</td>";
                                echo "<td>" . htmlspecialchars($out) . "</td>";
                                echo "<td><b>₹" . number_format($price, 2) . "</b></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No room bookings found matching your filter!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="food-report" class="report-section">
                <h3>Food Orders Report</h3>
                
                <form method="GET" action="" class="filter-form">
                    <input type="text" name="food_search" placeholder="Search name, room no, items..." value="<?php echo htmlspecialchars($food_search); ?>">
                    <button type="submit">Filter Report</button>
                    <?php if(!empty($food_search)): ?>
                        <a href="reports.php">Reset</a>
                    <?php endif; ?>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Room No</th>
                            <th>Ordered Items</th>
                            <th>Payment Mode</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $food_query = "SELECT * FROM food_orders WHERE 1=1";
                        if (!empty($food_search)) {
                            $safe_f_search = mysqli_real_escape_string($conn, $food_search);
                            $food_query .= " AND (customer_name LIKE '%$safe_f_search%' OR user_name LIKE '%$safe_f_search%' OR room_no LIKE '%$safe_f_search%' OR items LIKE '%$safe_f_search%')";
                        }
                        $food_query .= " ORDER BY id DESC";

                        $f_result = $conn->query($food_query);
                        if ($f_result && $f_result->num_rows > 0) {
                            while ($row = $f_result->fetch_assoc()) {
                                $c_name = $row['customer_name'] ?? $row['user_name'] ?? $row['name'] ?? "N/A";
                                $r_no = $row['room_no'] ?? "N/A";
                                $items = $row['items'] ?? $row['food_name'] ?? "N/A";
                                $pay = $row['payment_mode'] ?? "Cash";
                                $total = $row['total_amount'] ?? $row['total_price'] ?? 0;
                                $status = $row['status'] ?? "Delivered";

                                echo "<tr>";
                                echo "<td>#" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($c_name) . "</td>";
                                echo "<td>" . htmlspecialchars($r_no) . "</td>";
                                echo "<td style='text-align: left;'><small>" . htmlspecialchars($items) . "</small></td>";
                                echo "<td>" . htmlspecialchars($pay) . "</td>";
                                echo "<td><b>₹" . number_format($total, 2) . "</b></td>";
                                echo "<td><span class='badge'>" . htmlspecialchars($status) . "</span></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No food orders found matching your filter!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function switchReport(sectionId, btn) {
            let sections = document.querySelectorAll('.report-section');
            sections.forEach(sec => sec.classList.remove('active'));

            let buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(b => b.classList.remove('active'));

            document.getElementById(sectionId).classList.add('active');
            btn.classList.add('active');
        }
    </script>
</body>
</html>