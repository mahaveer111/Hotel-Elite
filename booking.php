<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', 1);

session_start();
include('db.php');

if (!isset($_SESSION['user_email']) || empty($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$success_msg = "";
$error_msg = "";

$selected_room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 0;

if (isset($_POST['book_room'])) {
    $user_name = isset($_POST['user_name']) ? mysqli_real_escape_string($conn, $_POST['user_name']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';
    $user_email = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
    $room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 0;
    $check_in = isset($_POST['check_in']) ? mysqli_real_escape_string($conn, $_POST['check_in']) : '';
    $check_in_time = isset($_POST['check_in_time']) ? mysqli_real_escape_string($conn, $_POST['check_in_time']) : '12:00';
    $check_out = isset($_POST['check_out']) ? mysqli_real_escape_string($conn, $_POST['check_out']) : '';
    $check_out_time = isset($_POST['check_out_time']) ? mysqli_real_escape_string($conn, $_POST['check_out_time']) : '11:00';
    $adults = isset($_POST['adults']) ? (int)$_POST['adults'] : 1;
    $children = isset($_POST['children']) ? (int)$_POST['children'] : 0;
    $payment_method = isset($_POST['payment_method']) ? mysqli_real_escape_string($conn, $_POST['payment_method']) : 'Cash';

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error_msg = "Please enter a valid 10-digit mobile number!";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/', $user_email)) {
        $error_msg = "Invalid Email! Email must end with .com (e.g., name@gmail.com).";
    } else {
        $safe_email = mysqli_real_escape_string($conn, $user_email);
        $ci_datetime = "$check_in $check_in_time";
        $co_datetime = "$check_out $check_out_time";

        $conflict_check = "SELECT * FROM room_bookings WHERE room_id = $room_id AND NOT (check_out <= '$ci_datetime' OR check_in >= '$co_datetime')";
        $conflict_result = $conn->query($conflict_check);

        if ($conflict_result && $conflict_result->num_rows > 0) {
            $error_msg = "Sorry! This room is already booked for the selected dates and time. Please choose different dates.";
        } else {
            $room_query = $conn->query("SELECT * FROM rooms WHERE id = $room_id");
            if ($room_query && $room_query->num_rows > 0) {
                $room_data = $room_query->fetch_assoc();
                
                $room_name = $room_data['room_type'];
                $base_price = $room_data['price'] ?? 1200;
                $max_adults = $room_data['max_adults'] ?? 1;
                $max_children = $room_data['max_children'] ?? 0;
                $extra_adult_fee = $room_data['extra_adult_charge'] ?? 400;
                $extra_child_fee = $room_data['extra_child_charge'] ?? 200;

                $earlier = new DateTime($check_in);
                $later = new DateTime($check_out);
                $days = $earlier->diff($later)->days;
                if ($days <= 0) $days = 1;

                $nightly_total = $base_price;
                if ($adults > $max_adults) {
                    $extra_adults = $adults - $max_adults;
                    $nightly_total += ($extra_adults * $extra_adult_fee);
                }
                if ($children > $max_children) {
                    $extra_children = $children - $max_children;
                    $nightly_total += ($extra_children * $extra_child_fee);
                }

                $total_price = $days * $nightly_total;
                $payment_status = ($payment_method == 'Cash') ? 'Pending (Pay at Hotel)' : 'Paid Successfully';

                $insert = "INSERT INTO room_bookings (user_name, phone, user_email, room_id, check_in, check_out, total_price, payment_method, payment_status) 
                           VALUES ('$user_name', '$phone', '$safe_email', $room_id, '$ci_datetime', '$co_datetime', '$total_price', '$payment_method', '$payment_status')";
                
                if ($conn->query($insert) === TRUE) {
                    $success_msg = "Booking Successful!<br>Total Payable: <b>₹" . number_format($total_price) . "</b> | Status: <b style='color:#27ae60;'>$payment_status</b>";
                } else {
                    $error_msg = "Database Error: " . $conn->error;
                }
            } else {
                $error_msg = "Selected room not found in the database!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Room - Hotel Elite</title>
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
            max-width: 650px; 
            margin: 40px auto; 
            background: #fff; 
            padding: 35px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            width: 100%;
        }

        h2 { 
            text-align: center; 
            color: #0d1b2a; 
            margin-bottom: 25px; 
            font-size: 1.8rem;
        }

        .form-group { 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 6px; 
            color: #495057; 
            font-size: 0.9rem;
        }

        input, select { 
            width: 100%; 
            padding: 10px 12px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.95rem; 
            box-sizing: border-box; 
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        .row-group { 
            display: flex; 
            gap: 15px; 
        }

        .row-group div { 
            flex: 1; 
        }

        .btn-submit { 
            background: #28a745; 
            color: #fff; 
            border: none; 
            width: 100%; 
            padding: 12px; 
            font-size: 1.05rem; 
            font-weight: bold; 
            border-radius: 5px; 
            cursor: pointer; 
            margin-top: 10px; 
            transition: background 0.2s;
        }

        .btn-submit:hover { 
            background: #218838; 
        }

        .alert-success { 
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            text-align: center; 
            font-size: 1.05rem; 
            line-height: 1.6; 
            border: 1px solid #c3e6cb;
        }

        .alert-danger { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            text-align: center; 
            font-weight: bold; 
            font-size: 0.95rem;
            border: 1px solid #f5c6cb;
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
                <li><a href="my_bookings.php">My Bookings</a></li>
                <li><a href="food.php">Dining</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Room Booking Form</h2>
        <?php if (!empty($success_msg)) { echo "<div class='alert-success'>$success_msg</div>"; } ?>
        <?php if (!empty($error_msg)) { echo "<div class='alert-danger'>$error_msg</div>"; } ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="user_name" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label>Mobile Number (10 Digits):</label>
                <input type="tel" name="phone" placeholder="e.g. 9876543210" pattern="[0-9]{10}" maxlength="10" required>
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="user_email" placeholder="Enter email address (e.g. name@gmail.com)" required>
            </div>

            <div class="form-group">
                <label>Select Room Type:</label>
                <select name="room_id" required>
                    <?php
                    $rooms_result = $conn->query("SELECT * FROM rooms ORDER BY id ASC");
                    if ($rooms_result && $rooms_result->num_rows > 0) {
                        while($r = $rooms_result->fetch_assoc()) {
                            $sel = ($r['id'] == $selected_room_id) ? "selected" : "";
                            echo '<option value="'.$r['id'].'" '.$sel.'>'.$r['room_type'].' (Standard Adults: '.$r['max_adults'].', Child: '.$r['max_children'].') - ₹'.$r['price'].'/night</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Number of Adults:</label>
                <select name="adults">
                    <option value="1">1 Adult</option>
                    <option value="2" selected>2 Adults</option>
                    <option value="3">3 Adults</option>
                    <option value="4">4 Adults</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Number of Children:</label>
                <select name="children">
                    <option value="0" selected>0 Child</option>
                    <option value="1">1 Child</option>
                    <option value="2">2 Children</option>
                </select>
            </div>

            <div class="form-group">
                <label>Select Payment Method:</label>
                <select name="payment_method" required>
                    <option value="Cash">Cash (Status: Pending / Pay at Hotel)</option>
                    <option value="Paytm / UPI">Paytm / UPI (Status: Paid Successfully)</option>
                    <option value="Credit / Debit Card">Credit / Debit Card (Status: Paid Successfully)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Check-In Date & Time:</label>
                <div class="row-group">
                    <input type="date" name="check_in" required>
                    <input type="time" name="check_in_time" value="12:00" required>
                </div>
            </div>

            <div class="form-group">
                <label>Check-Out Date & Time:</label>
                <div class="row-group">
                    <input type="date" name="check_out" required>
                    <input type="time" name="check_out_time" value="11:00" required>
                </div>
            </div>

            <button type="submit" name="book_room" class="btn-submit">Confirm Booking & Pay</button>
        </form>
    </div>
</body>
</html>