<?php
include('db.php');

$success_msg = "";
$error_msg = "";

if (isset($_POST['book_now']))
     {
    $room_no = $_POST['room_no'];
    $room_name = $_POST['room_name'];
    $price = $_POST['price'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $payment_mode = $_POST['payment_mode'];

    $check_query = "SELECT * FROM room_bookings WHERE room_no = '$room_no' AND checkout_date >= '$checkin_date' AND checkin_date <= '$checkout_date'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0)
         {
        $error_msg = "Sorry! Room $room_no is already booked for these selected dates.";
    }
     else
         {
        $insert_query = "INSERT INTO room_bookings (room_no, room_name, price, adults, children, customer_name, phone, checkin_date, checkout_date, payment_mode) 
                         VALUES ('$room_no', '$room_name', '$price', '$adults', '$children', '$customer_name', '$phone', '$checkin_date', '$checkout_date', '$payment_mode')";
        
        if (mysqli_query($conn, $insert_query))
             {
            $success_msg = "Room booked successfully! Redirecting to availability...";
            echo "<script>setTimeout(function(){ window.location.href='room-availability.php'; }, 2000);</script>";
        } 
        else 
            {
            $error_msg = "Database Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Elite - Professional Room Booking</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
         background-color: #f4f7f6;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
          }
        .booking-wrapper {
         max-width: 700px;
          margin: 40px auto;
           background: #fff;
            padding: 40px;
             border-radius: 12px;
              box-shadow: 0 10px 30px rgba(0,0,0,0.08);
               }
        .booking-header { 
        text-align: center;
         margin-bottom: 30px; 
         }
        .booking-header h2 {
         color: #0d1b2a;
          font-size: 2rem;
           margin-bottom: 8px;
            }
        .booking-header p {
         color: #666;
          font-size: 0.95rem; 
          }
        
        .form-grid {
         display: grid;
          grid-template-columns: 1fr 1fr;
           gap: 20px;
            }
        .form-group { 
        margin-bottom: 20px;
         }
        .form-group.full-width { 
        grid-column: span 2;
         }
        
        .form-group label {
         display: block;
          margin-bottom: 8px;
           font-weight: 600;
            color: #333;
             font-size: 0.9rem; 
             }
        .form-group input, .form-group select {
         width: 100%;
          padding: 12px 15px;
           border: 1px solid #dcdcdc;
            border-radius: 6px;
             font-size: 0.95rem; 
             background: #fafafa; 
             transition: all 0.3s ease;
              }
        .form-group input:focus, .form-group select:focus { 
        border-color: #0d1b2a; 
        background: #fff;
         outline: none;
          box-shadow: 0 0 5px rgba(13, 27, 42, 0.2);
           }
        
        .btn-reserve { 
        background: #0d1b2a; 
        color: white;
         padding: 14px;
          border: none; 
          border-radius: 6px;
           font-size: 1rem;
            font-weight: bold;
             width: 100%;
              cursor: pointer;
               transition: background 0.3s ease; 
               }
        .btn-reserve:hover {
        
         background: #1b263b;
          }
        
        .alert-success {
         background: #e1fdf4;
          color: #065f46;
           padding: 12px; 
           border-radius: 6px;
            margin-bottom: 20px;
             text-align: center;
              font-weight: 600; 
              border: 1px solid #a7f3d0; 
              }
        .alert-error {
         background: #ffeeec;
          color: #991b1b;
           padding: 12px; 
           border-radius: 6px;
            margin-bottom: 20px;
             text-align: center;
              font-weight: 600; 
              border: 1px solid #fecaca; 
              }
    </style>
    <script>
        function updateRoomDetails() 
        {
            var select = document.getElementById('room_select');
            var selectedOption = select.options[select.selectedIndex];
            
            var roomNo = selectedOption.getAttribute('data-no');
            var roomType = selectedOption.getAttribute('data-type');
            var roomPrice = selectedOption.getAttribute('data-price');
            
            document.getElementById('room_no_hidden').value = roomNo;
            document.getElementById('room_name_hidden').value = roomType;
            document.getElementById('price_input').value = roomPrice;
        }
    </script>
</head>
<body>

    <div class="booking-wrapper">
        <div class="booking-header">
            <h2>Reserve Your Stay</h2>
            <p>Hotel Elite Room Booking Portal (Price includes 2 Adults & 1 Child base)</p>
        </div>

        <?php
         if(!empty($success_msg))
          {
             echo "<div class='alert-success'>$success_msg</div>";
              }
               ?>
        <?php
         if(!empty($error_msg))
          { 
            echo "<div class='alert-error'>$error_msg</div>";
             }
              ?>

        <form action="booking.php" method="POST">
            <div class="form-grid">
                

                <input type="hidden" name="room_no" id="room_no_hidden">
                <input type="hidden" name="room_name" id="room_name_hidden">

                <div class="form-group full-width">
                    <label>Select Room & Price (Base: 2 Adults, 1 Child)</label>
                    <select id="room_select" onchange="updateRoomDetails()" required>
                        <option value="">-- Choose Room --</option>
                        <option value="101" data-no="101" data-type="Standard Room" data-price="1800">Room 101 - Standard Room (1st Floor) - ₹1,800</option>
                        <option value="102" data-no="102" data-type="Standard Room" data-price="1800">Room 102 - Standard Room (1st Floor) - ₹1,800</option>
                        <option value="201" data-no="201" data-type="Deluxe Room" data-price="2500">Room 201 - Deluxe Room (2nd Floor) - ₹2,500</option>
                        <option value="202" data-no="202" data-type="Deluxe Room" data-price="2500">Room 202 - Deluxe Room (2nd Floor) - ₹2,500</option>
                        <option value="301" data-no="301" data-type="Executive Suite" data-price="3800">Room 301 - Executive Suite (3rd Floor) - ₹3,800</option>
                        <option value="302" data-no="302" data-type="Executive Suite" data-price="3800">Room 302 - Executive Suite (3rd Floor) - ₹3,800</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Total Price (₹)</label>
                    <input type="number" name="price" id="price_input" readonly required style="background: #e9ecef; font-weight: bold; color: #2c3e50;">
                </div>

                <div class="form-group">
                    <label>Payment Mode</label>
                    <select name="payment_mode">
                        <option value="Online / UPI">Online / UPI</option>
                        <option value="Credit / Debit Card">Credit / Debit Card</option>
                        <option value="Cash at Hotel">Cash at Hotel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Adults (Base: 2)</label>
                    <input type="number" name="adults" value="2" min="1" max="5" required>
                </div>

                <div class="form-group">
                    <label>Children (Base: 1)</label>
                    <input type="number" name="children" value="1" min="0" max="4">
                </div>

                <div class="form-group">
                    <label>Guest Full Name</label>
                    <input type="text" name="customer_name" placeholder="Enter full name" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter mobile number" required>
                </div>

                <div class="form-group">
                    <label>Check-in Date</label>
                    <input type="date" name="checkin_date" required>
                </div>

                <div class="form-group">
                    <label>Check-out Date</label>
                    <input type="date" name="checkout_date" required>
                </div>

                <div class="form-group full-width">
                    <button type="submit" name="book_now" class="btn-reserve">Confirm Reservation</button>
                </div>

            </div>
        </form>
    </div>

</body>
</html>