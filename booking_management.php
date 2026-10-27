<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin']) && !isset($_SESSION['staff_email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_room'])) {
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    
    $stmt = $conn->prepare("INSERT INTO rooms (room_type, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $room_type, $price);
    $stmt->execute();
    header("Location: booking_management.php");
    exit();
}

if (isset($_POST['update_room_price'])) {
    $room_id = (int)$_POST['room_id'];
    $new_price = $_POST['new_price'];
    
    $stmt = $conn->prepare("UPDATE rooms SET price = ? WHERE id = ?");
    $stmt->bind_param("di", $new_price, $room_id);
    $stmt->execute();
    header("Location: booking_management.php");
    exit();
}

if (isset($_GET['delete_room'])) {
    $r_id = (int)$_GET['delete_room'];
    $conn->query("DELETE FROM rooms WHERE id = $r_id");
    header("Location: booking_management.php");
    exit();
}

if (isset($_POST['update_booking'])) {
    $b_id = (int)$_POST['booking_id'];
    $user_name = $_POST['user_name'];
    $room_id = (int)$_POST['room_id'];
    $phone = $_POST['phone'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $payment_status = $_POST['payment_status'];

    $stmt = $conn->prepare("UPDATE room_bookings SET user_name = ?, room_id = ?, phone = ?, check_in = ?, check_out = ?, total_price = ?, payment_method = ?, payment_status = ? WHERE id = ?");
    $stmt->bind_param("sisssdssi", $user_name, $room_id, $phone, $check_in, $check_out, $total_price, $payment_method, $payment_status, $b_id);
    $stmt->execute();
    header("Location: booking_management.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'accept') {
    $id = (int)$_GET['id'];
    $conn->query("UPDATE room_bookings SET payment_status = 'Confirmed' WHERE id = $id");
    header("Location: booking_management.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'reject') {
    $id = (int)$_GET['id'];
    $conn->query("UPDATE room_bookings SET payment_status = 'Cancelled' WHERE id = $id");
    header("Location: booking_management.php");
    exit();
}

if (isset($_GET['delete_booking'])) {
    $b_id = (int)$_GET['delete_booking'];
    $conn->query("DELETE FROM room_bookings WHERE id = $b_id");
    header("Location: booking_management.php");
    exit();
}

$search_query = isset($_GET['search']) ? trim($_GET['search']) : "";
$status_filter = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : "";
$filter_date = isset($_GET['filter_date']) ? trim($_GET['filter_date']) : "";
$room_search = isset($_GET['room_search']) ? trim($_GET['room_search']) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking & Room Management - Dashboard</title>
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

        h2, h3 { 
            color: #0d1b2a; 
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

        .card { 
            background: #fff; 
            padding: 25px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            margin-bottom: 30px; 
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
        
        .badge-confirmed { 
            background: #28a745; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.75rem; 
            display: inline-block;
        }

        .badge-cancelled { 
            background: #dc3545; 
            color: white; 
            padding: 5px 10px; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.75rem; 
            display: inline-block;
        }

        .badge-pending { 
            background: #ffc107; 
            color: #000; 
            padding: 5px 10px; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.75rem; 
            display: inline-block;
        }

        .btn-delete { 
            background: #dc3545; 
            color: #fff; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.8rem; 
            display: inline-block; 
            margin-top: 4px; 
            transition: background 0.2s;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-edit { 
            background: #ffc107; 
            color: #212529; 
            padding: 6px 12px; 
            border: none; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.8rem; 
            cursor: pointer; 
            display: inline-block; 
            margin-top: 4px; 
            transition: background 0.2s;
        }

        .btn-edit:hover {
            background: #e0a800;
        }

        .btn-accept { 
            background: #28a745; 
            color: white; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.8rem; 
            display: inline-block; 
            margin-bottom: 4px; 
            transition: background 0.2s;
        }

        .btn-accept:hover {
            background: #218838;
        }

        .btn-reject { 
            background: #e67e22; 
            color: white; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-weight: bold; 
            font-size: 0.8rem; 
            display: inline-block; 
            margin-bottom: 4px; 
            transition: background 0.2s;
        }

        .btn-reject:hover {
            background: #d35400;
        }

        .btn-update { 
            background: #28a745; 
            color: white; 
            padding: 6px 12px; 
            border: none; 
            border-radius: 4px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: background 0.2s;
        }

        .btn-update:hover {
            background: #218838;
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

        .section-box { display: none; }
        .section-box.active { display: block; }

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

        .add-form { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 6px; 
            border: 1px solid #e9ecef; 
            display: flex; 
            gap: 15px; 
            align-items: center; 
            flex-wrap: wrap; 
            margin-bottom: 25px; 
        }

        .add-form input { 
            padding: 10px 12px; 
            font-size: 0.9rem; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            flex: 1; 
            min-width: 200px; 
        }

        .add-form button { 
            background: #28a745; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            font-weight: bold; 
            border-radius: 5px; 
            cursor: pointer; 
            transition: background 0.2s;
        }

        .add-form button:hover {
            background: #218838;
        }

        .modal { 
            display: none; 
            position: fixed; 
            z-index: 999; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.5); 
            justify-content: center; 
            align-items: center; 
        }

        .modal-content { 
            background: #fff; 
            padding: 30px; 
            border-radius: 8px; 
            width: 100%; 
            max-width: 420px; 
            box-shadow: 0 4px 25px rgba(0,0,0,0.2); 
        }

        .modal-content h3 { 
            margin-bottom: 20px; 
            color: #0d1b2a; 
        }

        .form-group { 
            margin-bottom: 15px; 
            display: flex; 
            flex-direction: column; 
            gap: 6px; 
            text-align: left; 
        }

        .form-group label { 
            font-size: 0.85rem; 
            font-weight: 600; 
            color: #495057;
        }

        .form-group input, 
        .form-group select { 
            padding: 10px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.95rem; 
        }

        .modal-btns { 
            display: flex; 
            justify-content: flex-end; 
            gap: 10px; 
            margin-top: 20px; 
        }

        .btn-save { 
            background: #28a745; 
            color: white; 
            border: none; 
            padding: 10px 18px; 
            border-radius: 5px; 
            font-weight: bold; 
            cursor: pointer; 
        }

        .btn-cancel { 
            background: #6c757d; 
            color: white; 
            border: none; 
            padding: 10px 18px; 
            border-radius: 5px; 
            font-weight: bold; 
            cursor: pointer; 
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Hotel Elite - Management</div>
        <div class="logout-box">
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="main-wrapper">
        <aside>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="booking_management.php" class="active">Bookings</a></li>
                <li><a href="food_orders.php">Food Orders</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </aside>

        <div class="content">
            <div class="top-bar">
                <h2>Room Bookings & Room Management</h2>
                <a href="dashboard.php" class="btn-back">&larr; Back to Dashboard</a>
            </div>

            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchTab('bookings-tab', this)">Customer Bookings View</button>
                <button class="tab-btn" onclick="switchTab('rooms-tab', this)">Add / Update Rooms</button>
            </div>

            <div id="bookings-tab" class="section-box active">
                <div class="card">
                    <h3>Customer Room Bookings List</h3>
                    
                    <form method="GET" action="" class="filter-form">
                        <input type="text" name="search" placeholder="Search name, phone, room type..." value="<?php echo htmlspecialchars($search_query); ?>">
                        
                        <select name="status_filter">
                            <option value="">-- Filter by Status --</option>
                            <option value="Confirmed" <?php if($status_filter == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                            <option value="Cancelled" <?php if($status_filter == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                            <option value="Pending (Pay at Hotel)" <?php if($status_filter == 'Pending (Pay at Hotel)') echo 'selected'; ?>>Pending (Pay at Hotel)</option>
                            <option value="Paid Successfully" <?php if($status_filter == 'Paid Successfully') echo 'selected'; ?>>Paid Successfully</option>
                        </select>

                        <input type="date" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">

                        <button type="submit">Apply Filter</button>
                        <?php if(!empty($search_query) || !empty($status_filter) || !empty($filter_date)): ?>
                            <a href="booking_management.php">Reset</a>
                        <?php endif; ?>
                    </form>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Room Type</th>
                                <th>Phone</th>
                                <th>Check-In & Check-Out</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $b_query = "SELECT rb.*, r.room_type, r.id AS r_id FROM room_bookings rb LEFT JOIN rooms r ON rb.room_id = r.id WHERE 1=1";
                            
                            if (!empty($search_query)) {
                                $safe_search = mysqli_real_escape_string($conn, $search_query);
                                $b_query .= " AND (rb.user_name LIKE '%$safe_search%' OR r.room_type LIKE '%$safe_search%' OR rb.phone LIKE '%$safe_search%' OR rb.payment_method LIKE '%$safe_search%')";
                            }

                            if (!empty($status_filter)) {
                                $safe_status = mysqli_real_escape_string($conn, $status_filter);
                                $b_query .= " AND rb.payment_status = '$safe_status'";
                            }

                            if (!empty($filter_date)) {
                                $safe_date = mysqli_real_escape_string($conn, $filter_date);
                                $b_query .= " AND rb.check_in LIKE '$safe_date%'";
                            }

                            $b_query .= " ORDER BY rb.id DESC";
                            $b_result = $conn->query($b_query);

                            if ($b_result && $b_result->num_rows > 0) {
                                while ($row = $b_result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $name = $row['user_name'] ?? "N/A";
                                    $room_id = $row['room_id'] ?? 0;
                                    $room = $row['room_type'] ?? "Room #" . $room_id;
                                    $phone = $row['phone'] ?? "N/A";
                                    $in = $row['check_in'] ?? "N/A";
                                    $out = $row['check_out'] ?? "N/A";
                                    $price = $row['total_price'] ?? 0;
                                    $pay = $row['payment_method'] ?? $row['payment_mode'] ?? "Cash";
                                    $status = $row['payment_status'] ?? "Confirmed";

                                    echo "<tr>";
                                    echo "<td><b>#" . $id . "</b></td>";
                                    echo "<td>" . $name . "</td>";
                                    echo "<td><b>" . $room . "</b></td>";
                                    echo "<td>" . $phone . "</td>";
                                    echo "<td><small>" . $in . "<br>to<br>" . $out . "</small></td>";
                                    echo "<td><b>₹" . number_format($price, 2) . "</b></td>";
                                    echo "<td>" . $pay . "</td>";
                                    
                                    echo "<td>";
                                    if ($status == 'Confirmed' || $status == 'Paid Successfully') {
                                        echo "<span class='badge-confirmed'>" . $status . "</span>";
                                    } elseif ($status == 'Cancelled') {
                                        echo "<span class='badge-cancelled'>" . $status . "</span>";
                                    } else {
                                        echo "<span class='badge-pending'>" . $status . "</span>";
                                    }
                                    echo "</td>";

                                    echo "<td>
                                            <a href='booking_management.php?action=accept&id=" . $id . "' class='btn-accept' onclick='return confirm(\"Accept/Confirm this booking?\")'>Accept</a><br>
                                            <a href='booking_management.php?action=reject&id=" . $id . "' class='btn-reject' onclick='return confirm(\"Reject/Cancel this booking?\")'>Reject</a><br>
                                            <button class='btn-edit' onclick='openEditModal($id, \"$name\", $room_id, \"$phone\", \"$in\", \"$out\", $price, \"$pay\", \"$status\")'>Edit</button><br>
                                            <a href='booking_management.php?delete_booking=" . $id . "' class='btn-delete' onclick='return confirm(\"Delete this booking record?\")'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No room bookings found matching your filter!</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="rooms-tab" class="section-box">
                <div class="card">
                    <h3>Add New Room & Change Room Prices</h3>
                    
                    <form action="" method="POST" class="add-form">
                        <input type="text" name="room_type" placeholder="Room Type (e.g. Deluxe Suite)" required>
                        <input type="number" step="0.01" name="price" placeholder="Price per Night (₹)" required>
                        <button type="submit" name="add_room">+ Add New Room</button>
                    </form>

                    <h3>Existing Rooms & Price Updater</h3>
                    
                    <form method="GET" action="" class="filter-form">
                        <input type="text" name="room_search" placeholder="Search by room type..." value="<?php echo htmlspecialchars($room_search); ?>">
                        <button type="submit">Search Room</button>
                        <?php if(!empty($room_search)): ?>
                            <a href="booking_management.php">Reset</a>
                        <?php endif; ?>
                    </form>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room Type</th>
                                <th>Current Price (₹)</th>
                                <th>Update Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rooms_query = "SELECT * FROM rooms WHERE 1=1";
                            if (!empty($room_search)) {
                                $safe_r_search = mysqli_real_escape_string($conn, $room_search);
                                $rooms_query .= " AND room_type LIKE '%$safe_r_search%'";
                            }
                            $rooms_query .= " ORDER BY id DESC";

                            $rooms_res = $conn->query($rooms_query);
                            if ($rooms_res && $rooms_res->num_rows > 0) {
                                while ($r = $rooms_res->fetch_assoc()) {
                                    $r_id = $r['id'];
                                    $r_type = $r['room_type'] ?? "Room #" . $r_id;
                                    $r_price = $r['price'] ?? 0;

                                    echo "<tr>";
                                    echo "<td><b>#" . $r_id . "</b></td>";
                                    echo "<td>" . $r_type . "</td>";
                                    echo "<td><b>₹" . number_format($r_price, 2) . "</b></td>";
                                    echo "<td>
                                            <form action='' method='POST' style='margin:0; padding:0; border:none; background:none; display:flex; justify-content:center; gap:8px;'>
                                                <input type='hidden' name='room_id' value='" . $r_id . "'>
                                                <input type='number' step='0.01' name='new_price' value='" . $r_price . "' style='width:100px; padding:6px;' required>
                                                <button type='submit' name='update_room_price' class='btn-update'>Save</button>
                                            </form>
                                          </td>";
                                    echo "<td><a href='booking_management.php?delete_room=" . $r_id . "' class='btn-delete' onclick='return confirm(\"Delete this room?\")'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No rooms found matching your search!</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="editBookingModal" class="modal">
        <div class="modal-content">
            <h3>Edit Room Booking</h3>
            <form action="" method="POST">
                <input type="hidden" name="booking_id" id="edit_b_id">
                
                <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" name="user_name" id="edit_b_name" required>
                </div>
                <div class="form-group">
                    <label>Room Type</label>
                    <select name="room_id" id="edit_b_room" required>
                        <?php
                        $room_dropdown = $conn->query("SELECT * FROM rooms ORDER BY id ASC");
                        while($rd = $room_dropdown->fetch_assoc()) {
                            echo "<option value='".$rd['id']."'>".$rd['room_type']." (₹".$rd['price']."/night)</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" id="edit_b_phone" required>
                </div>
                <div class="form-group">
                    <label>Check-In Date & Time</label>
                    <input type="text" name="check_in" id="edit_in" required>
                </div>
                <div class="form-group">
                    <label>Check-Out Date & Time</label>
                    <input type="text" name="check_out" id="edit_out" required>
                </div>
                <div class="form-group">
                    <label>Total Amount (₹)</label>
                    <input type="number" step="0.01" name="total_price" id="edit_b_price" required>
                </div>
                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" id="edit_b_pay">
                        <option value="Cash">Cash</option>
                        <option value="Paytm / UPI">Paytm / UPI</option>
                        <option value="Credit / Debit Card">Credit / Debit Card</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="payment_status" id="edit_b_status">
                        <option value="Confirmed">Confirmed</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Pending (Pay at Hotel)">Pending (Pay at Hotel)</option>
                        <option value="Paid Successfully">Paid Successfully</option>
                    </select>
                </div>

                <div class="modal-btns">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" name="update_booking" class="btn-save">Save Changes</button>
                </div>
            </form>
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

        function openEditModal(id, name, roomId, phone, checkIn, checkOut, price, pay, status) {
            document.getElementById('edit_b_id').value = id;
            document.getElementById('edit_b_name').value = name;
            document.getElementById('edit_b_room').value = roomId;
            document.getElementById('edit_b_phone').value = phone;
            document.getElementById('edit_in').value = checkIn;
            document.getElementById('edit_out').value = checkOut;
            document.getElementById('edit_b_price').value = price;
            document.getElementById('edit_b_pay').value = pay;
            document.getElementById('edit_b_status').value = status;
            document.getElementById('editBookingModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editBookingModal').style.display = 'none';
        }
    </script>
</body>
</html>