<?php
include 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_food_order']))
	{
    $c_name =$_POST['c_name'];
    $room_no =$_POST['r_no'];
    $items =$_POST['cart_items_data'];
    $total =$_POST['total_amount_data'];
    $pay_mode =$_POST['pay_mode'];

    $sql = "INSERT INTO food_orders (customer_name, room_no, items, total_amount, payment_mode) 
            VALUES ('$c_name', '$room_no', '$items', '$total', '$pay_mode')";
    
    if ($conn->query($sql) === TRUE) {$msg = "Food Order Placed Successfully for Hotel Elite!";
    } 
	else 
	{
        $msg = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Dining</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .food-layout {
			display: grid;
			grid-template-columns: 2fr 1fr;
			gap: 25px;
			margin-top: 20px;
			}
        @media (max-width: 768px) {
			.food-layout {
				grid-template-columns: 1fr; 
				} 
				}
        .food-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
			gap: 15px; 
			}
        .food-card {
			background: #fff;
			border-radius: 8px;
			overflow: hidden; 
			box-shadow: 0 2px 6px rgba(0,0,0,0.1);
			text-align: center; 
			padding-bottom: 12px; 
			}
        .food-card img { 
		width: 100%; 
		height: 120px;
		object-fit: cover; 
		}
        .food-card h4 {
			margin: 10px 0 5px;
			color: #0d1b2a;
			}
        .food-card p {
			color: #f39c12;
			font-weight: bold;
			margin-bottom: 10px;
			}
        .add-btn { 
		background-color: #27ae60;
		color: white;
		border: none;
		padding: 6px 14px;
		border-radius: 4px;
		cursor: pointer; 
		font-weight: bold; 
		}
        .cart-panel {
			background: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);
			height: fit-content;
			position: sticky;
			top: 20px; 
			}
        .cart-item-row {
			display: flex;
			justify-content: space-between;
			margin-bottom: 8px;
			font-size: 0.95rem;
			color: #444; 
			}
        .alert {
			background: #d4edda; 
			color: #155724;

			padding: 12px;
			margin-bottom: 20px;
			border-radius: 5px;
			text-align: center;
			font-weight: bold; 
			}
    </style>
</head>
<body>

    <header>
        <div class="logo">Hotel Elite - Dining</div>
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

    <div class="container">
        <?php if($msg != "") { echo "<div class='alert'>$msg</div>"; } ?>
        <h2 style="color: #0d1b2a; margin-bottom: 5px;">Room Service Menu</h2>
        <p style="color: #666; margin-bottom: 20px;">Click "Add to Cart" to order items directly to your room.</p>

        <div class="food-layout">
            <div class="food-grid">
                <?php 
                $items_list = [
                    ["Mumbai Vadapav", 50, "https://images.unsplash.com/photo-1626777552726-4a6b54c97e46"],
                    ["Masala Soda", 60, "https://images.unsplash.com/photo-1622483767028-3f66f32aef97"],
                    ["Continental Breakfast", 600, "https://images.unsplash.com/photo-1533089860892-a7c6f0a88666"],
                    ["Paneer Tikka", 450, "https://images.unsplash.com/photo-1565557623262-b51c2513a641"],
                    ["Cheesy Pizza", 350, "https://images.unsplash.com/photo-1513104890138-7c749659a591"],
                    ["Veggie Burger", 180, "https://images.unsplash.com/photo-1568901346375-23c9450c58cd"],
                    ["White Sauce Pasta", 280, "https://images.unsplash.com/photo-1555396273-367ea4eb4db5"],
                    ["Healthy Green Salad", 150, "https://images.unsplash.com/photo-1546069901-ba9599a7e63c"],
                    ["Chocolate Brownie", 200, "https://images.unsplash.com/photo-1578985545062-69928b1d9587"]
                ];
                foreach($items_list as$item) 
				{
                    echo '<div class="food-card">
                            <img src="'.$item[2].'" alt="'.$item[0].'">
                            <h4>'.$item[0].'</h4>
                            <p>₹'.$item[1].'</p>
                            <button class="add-btn" onclick="addToCart(\''.$item[0].'\', '.$item[1].')">Add to Cart</button>
                          </div>';
                }
                ?>
            </div>

            <div class="cart-panel">
                <h3 style="color: #0d1b2a;
				margin-bottom: 15px; 
				border-bottom: 2px solid #f4f6f9;
				padding-bottom: 8px;">Your Cart</h3>
                
                <div id="cart-list" 
				style="margin-bottom: 15px;
				min-height: 50px;">
                    <p style="color: #888;
					font-size: 0.9rem;">No items selected yet.</p>
                </div>

                <div style="border-top: 2px dashed #ddd;
				padding-top: 10px;
				margin-bottom: 15px;">
                    <div style="display: flex; 
					justify-content: space-between;
					font-weight: bold; 
					color: #27ae60;">
                        <span>Total:</span>
                        <span>₹<span id="total-amount">0</span></span>
                    </div>
                </div>

                <form method="POST" action="" onsubmit="return validateCheckout()">
                    <input type="hidden" name="cart_items_data" id="cart_items_data">
                    <input type="hidden" name="total_amount_data" id="total_amount_data">

                    <div class="input-group">
                        <label>Your Name</label>
                        <input type="text" name="c_name" required placeholder="Enter name">
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

                    <button type="submit" name="place_food_order" class="btn" style="background-color: #0d1b2a;">Order Food</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let total = 0;

        function addToCart(name, price) 
		{
            cart.push({ name, price });
            total += price;
            updateUI();
        }

        function updateUI()
		{
            let list = document.getElementById("cart-list");
            list.innerHTML = "";
            if (cart.length === 0)
				{
                list.innerHTML = '<p style="color: #888; font-size: 0.9rem;">No items selected yet.</p>';
            } 
			else 
			{
                cart.forEach(item => {
                    let div = document.createElement("div");
                    div.className = "cart-item-row";
                    div.innerHTML = `<span>${item.name}</span><span>₹${item.price}</span>`;
                    list.appendChild(div);
                });
            }
            document.getElementById("total-amount").textContent = total;
        }

        function validateCheckout() 
		{
            if (cart.length === 0)
				{
                alert("Please add at least one item to your cart!");
                return false;
            }
            let itemStr = cart.map(i => `${i.name} (₹${i.price})`).join(", ");
            document.getElementById("cart_items_data").value = itemStr;
            document.getElementById("total_amount_data").value = total;
            return true;
        }
    </script>
    <footer><p>&copy; 2026 Hotel Elite. All Rights Reserved.</p></footer>
</body>
</html>