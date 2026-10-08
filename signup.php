<?php
include 'db.php';
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        // Check if email already exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $error = "Email already registered! Please login.";
        } else {
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                $success = "Registration successful! <a href='login.php' style='color: #f39c12; font-weight: bold;'>Login here</a>";
            } else {
                $error = "Database Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $checkStmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Sign Up</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f7f6; font-family: Arial, sans-serif;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); width: 350px;">
        <h2 style="text-align: center; color: #0d1b2a; margin-bottom: 20px;">Hotel Elite Sign Up</h2>
        
        <?php if($error != "") { echo "<p style='color:red; text-align:center; font-size:14px;'>$error</p>"; } ?>
        <?php if($success != "") { echo "<p style='color:green; text-align:center; font-size:14px;'>$success</p>"; } ?>
        
        <form method="POST" action="">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333;">Full Name</label>
                <input type="text" name="name" required placeholder="Enter your name" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333;">Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; color: #333;">Password</label>
                <input type="password" name="password" required placeholder="Enter your password" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <button type="submit" style="width: 100%; padding: 10px; background-color: #0d1b2a; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Sign Up</button>
        </form>

        <p style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
            Already have an account? <a href="login.php" style="color: #f39c12; text-decoration: none; font-weight: bold;">Login</a>
        </p>
    </div>

</body>
</html>