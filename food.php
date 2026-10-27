<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_food_order'])) {
    $c_name = $_POST['c_name'];
    $room_no = $_POST['r_no'];
    $items = $_POST['cart_items_data'];
    $total = $_POST['total_amount_data'];
    $pay_mode = $_POST['pay_mode'];

    $sql = "INSERT INTO food_orders (customer_name, room_no, items, total_amount, payment_mode, payment_status, status) 
            VALUES ('$c_name', '$room_no', '$items', '$total', '$pay_mode', 'Pending', 'Ordered')";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "Food Order Placed Successfully for Hotel Elite!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Dining Menu</title>
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
            max-width: 1200px; 
            margin: 30px auto; 
            padding: 0 20px; 
            width: 100%;
            flex: 1;
        }

        .food-layout { 
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-top: 20px; 
        }

        @media (max-width: 768px) { 
            .food-layout { grid-template-columns: 1fr; }
        }
        
        .food-grid {
            display: grid; 
            grid-template-columns: repeat(3, 1fr);
            gap: 20px; 
        }

        @media (max-width: 900px) {
            .food-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 600px) {
            .food-grid { grid-template-columns: 1fr; }
        }

        .food-card {
            background: #fff;
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center; 
            padding-bottom: 20px;
            transition: transform 0.2s;
        }

        .food-card:hover {
            transform: translateY(-3px);
        }

        .food-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: #e9ecef;
        }

        .food-card h4 { 
            margin: 15px 0 8px; 
            color: #0d1b2a; 
            font-size: 1.1rem; 
        }

        .food-card p { 
            color: #28a745; 
            font-weight: bold; 
            margin-bottom: 15px; 
            font-size: 1.05rem; 
        }

        .add-btn {
            background-color: #28a745;
            color: white; 
            border: none;
            padding: 8px 18px; 
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold; 
            transition: background 0.2s;
        }

        .add-btn:hover { 
            background-color: #218838; 
        }
        
        .cart-panel { 
            background: #fff; 
            padding: 25px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            height: fit-content;
            position: sticky;
            top: 20px; 
        }

        .cart-item-row {
            display: flex; 
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem; 
            color: #495057; 
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 6px;
        }

        .alert {
            background: #d4edda;
            color: #155724;
            padding: 12px; 
            margin-bottom: 20px; 
            border-radius: 5px; 
            text-align: center; 
            font-weight: bold;
            border: 1px solid #c3e6cb;
        }

        .input-group { 
            margin-bottom: 15px;
            display: flex; 
            flex-direction: column; 
            gap: 6px;
        }

        .input-group label { 
            font-size: 0.85rem; 
            font-weight: 600; 
            color: #495057; 
        }

        .input-group input, 
        .input-group select { 
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 0.95rem; 
        }

        .input-group input:focus, 
        .input-group select:focus {
            border-color: #007bff;
            outline: none;
        }

        footer { 
            text-align: center; 
            padding: 20px; 
            background: #0d1b2a; 
            color: white; 
            margin-top: auto;
            font-size: 0.9rem;
            border-top: 1px solid #1b263b;
        }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="home.php" style="background: #ffffff; color: #0d1b2a; padding: 6px 14px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">&larr; Back</a>
            <div class="logo">Hotel Elite - Dining</div>
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="food.php" style="color: white; font-weight: bold;">Dining</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="logout.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php 
        if($msg != "") { 
            echo "<div class='alert'>$msg</div>";
        } 
        ?>
        <h2 style="color: #0d1b2a; margin-bottom: 5px; font-size: 1.8rem;">Room Service Menu (Special Items)</h2>
        <p style="color: #6c757d; margin-bottom: 25px;">Select items and add them to your cart</p>

        <div class="food-layout">
            <div class="food-grid">
                <?php 
                $menu_result = $conn->query("SELECT * FROM food_items ORDER BY id DESC");

                if ($menu_result && $menu_result->num_rows > 0) {
                    while ($food = $menu_result->fetch_assoc()) {
                        $fname = $food['food_name'];
                        $f_price = $food['price'];
                        
                        $img = (!empty($food['image'])) ? $food['image'] : "https://images.unsplash.com/photo-1546833999-b9f581a1996d";
                        $f_name_js = addslashes($fname);

                        echo '<div class="food-card">
                                <img src="'.$img.'" alt="'.$fname.'">
                                <h4>'.$fname.'</h4>
                                <p>₹'.number_format($f_price, 2).'</p>
                                <button class="add-btn" onclick="addToCart(\''.$f_name_js.'\', '.$f_price.')">Add to Cart</button>
                              </div>';
                    }
                } else {
                    echo "<p>No food items available in the menu right now.</p>";
                }
                ?>
            </div>

            <div class="cart-panel">
                <h3 style="color: #0d1b2a; margin-bottom: 15px; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; font-size: 1.3rem;">Your Cart</h3>
                
                <div id="cart-list" style="margin-bottom: 15px; min-height: 50px;">
                    <p style="color: #adb5bd; font-size: 0.9rem;">No items selected yet.</p>
                </div>

                <div style="border-top: 2px dashed #e9ecef; padding-top: 12px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; font-weight: bold; color: #28a745; font-size: 1.1rem;">
                        <span>Total:</span>
                        <span>₹<span id="total-amount">0</span></span>
                    </div>
                </div>

                <form method="POST" action="" onsubmit="return validateCheckout()">
                    <input type="hidden" name="cart_items_data" id="cart_items_data">
                    <input type="hidden" name="total_amount_data" id="total_amount_data">

                    <div class="input-group">
                        <label>Your Name</label>
                        <input type="text" name="c_name" required placeholder="Enter your name">
                    </div>
                    <div class="input-group">
                        <label>Room Number</label>
                        <input type="text" name="r_no" required placeholder="Enter room no">
                    </div>
                    <div class="input-group">
                        <label>Payment Method</label>
                        <select name="pay_mode">
                            <option value="Cash">Cash / Pay to Room Bill</option>
                            <option value="Online">Online Payment (UPI/Card)</option>
                        </select>
                    </div>

                    <button type="submit" name="place_food_order" class="btn" style="background-color: #0d1b2a; width: 100%; padding: 12px; color: white; border: none; font-weight: bold; border-radius: 5px; cursor: pointer; margin-top: 10px; font-size: 1rem; transition: background 0.2s;">Order Food</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let total = 0;

        function addToCart(name, price) {
            cart.push({ name, price });
            total += price;
            updateUI();
        }

        function updateUI() {
            let list = document.getElementById("cart-list");
            list.innerHTML = "";
            if (cart.length === 0) {
                list.innerHTML = '<p style="color: #adb5bd; font-size: 0.9rem;">No items selected yet.</p>';
            } else {
                cart.forEach(item => {
                    let div = document.createElement("div");
                    div.className = "cart-item-row";
                    div.innerHTML = `<span>${item.name}</span><span>₹${item.price}</span>`;
                    list.appendChild(div);
                });
            }
            document.getElementById("total-amount").textContent = total;
        }

        function validateCheckout() {
            if (cart.length === 0) {
                alert("Please add at least one item to your cart!");
                return false;
            }
            let itemStr = cart.map(i => `${i.name} (₹${i.price})`).join(", ");
            document.getElementById("cart_items_data").value = itemStr;
            document.getElementById("total_amount_data").value = total;
            return true;
        }
    </script>
    <footer><p>&copy; 2026 Hotel Elite, Ahmedabad. All Rights Reserved.</p></footer>
</body>
</html>