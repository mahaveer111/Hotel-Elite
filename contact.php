<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
Y: ini_set('display_errors', 1);

session_start();
include('db.php');

$success_msg = "";
$error_msg = "";

if (isset($_POST['send_message'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sss", $name, $email, $message);
                $stmt->execute();
                $success_msg = "Thank you! Your message has been sent successfully. We will get back to you soon.";
            } else {
                $error_msg = "Database error! Please make sure 'contact_messages' table exists.";
            }
        } else {
            $error_msg = "Invalid email address! Please enter a valid email like name@gmail.com.";
        }
    } else {
        $error_msg = "Please fill in all the fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Contact Us</title>
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

        .contact-container { 
            max-width: 1000px; 
            margin: 40px auto; 
            padding: 0 20px; 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 30px; 
            width: 100%;
            flex: 1;
        }

        .info-box { 
            background: #0d1b2a; 
            color: white; 
            padding: 35px; 
            border-radius: 8px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .info-box h3 { 
            margin-top: 0; 
            color: #f39c12; 
            font-size: 1.6rem; 
            margin-bottom: 15px;
        }

        .info-box p { 
            line-height: 1.6; 
            color: #cbd5e1; 
            font-size: 0.95rem;
            margin-bottom: 12px;
        }

        .form-box { 
            background: #fff; 
            padding: 35px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        }

        .form-box h2 { 
            color: #0d1b2a; 
            margin-top: 0; 
            margin-bottom: 20px; 
            font-size: 1.8rem;
        }

        .form-group { 
            margin-bottom: 20px; 
            text-align: left; 
        }

        .form-group label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            color: #495057; 
            font-size: 0.9rem; 
        }

        .form-group input, 
        .form-group textarea { 
            width: 100%; 
            padding: 10px 12px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.95rem; 
            box-sizing: border-box; 
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-group textarea { 
            resize: vertical; 
            height: 120px; 
        }

        .btn-submit { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 12px 20px; 
            font-size: 1rem; 
            font-weight: bold; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%; 
            transition: background 0.2s; 
        }

        .btn-submit:hover { 
            background: #0056b3; 
        }

        .alert-success { 
            background: #d4edda; 
            color: #155724; 
            padding: 12px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            font-size: 0.95rem; 
            border: 1px solid #c3e6cb;
            text-align: center;
        }

        .alert-error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            font-size: 0.95rem; 
            border: 1px solid #f5c6cb; 
            text-align: center;
        }

        footer { 
            text-align: center; 
            padding: 20px; 
            color: #adb5bd; 
            background: #0d1b2a; 
            border-top: 1px solid #1b263b; 
            margin-top: auto;
            font-size: 0.9rem;
        }

        @media(max-width: 768px) {
            .contact-container { 
                grid-template-columns: 1fr; 
            }
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
                <li><a href="food.php">Dining</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php" style="color: white; font-weight: bold;">Contact</a></li>
                <li><a href="index.php" style="color: #e74c3c; font-weight: bold;">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="contact-container">
        <div class="info-box">
            <h3>Get In Touch</h3>
            <p>Have questions about rooms, dining, or bookings? Reach out to our front desk team anytime.</p>
            <br>
            <p><strong>Address:</strong><br>CG Road, Navrangpura, Ahmedabad, Gujarat</p>
            <p><strong>Phone:</strong><br>+91 98765 43210</p>
            <p><strong>Email:</strong><br>support@hotelelite.com</p>
        </div>

        <div class="form-box">
            <h2>Send Us a Message</h2>
            
            <?php if (!empty($success_msg)): ?>
                <div class="alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert-error"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter valid email (e.g., name@gmail.com)" required>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" name="send_message" class="btn-submit">Send Message</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Hotel Elite, Ahmedabad. All Rights Reserved.</p>
    </footer>
</body>
</html>