<?php
include 'db.php';
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: home.php");
                exit();
            } else {
                $error = "Invalid Password! Please try again.";
            }
        } else {
            $error = "Invalid Email! Please sign up first.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Login</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f7f6; font-family: Arial, sans-serif;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); width: 350px;">
        <h2 style="text-align: center; color: #0d1b2a; margin-bottom: 20px;">Hotel Elite Login</h2>
        
        <?php if($error != "") { echo "<p style='color:red; text-align:center; font-size:14px;'>$error</p>"; } ?>
        
        <form method="POST" action="">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333;">Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; color: #333;">Password</label>
                <input type="password" name="password" required placeholder="Enter your password" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <button type="submit" style="width: 100%; padding: 10px; background-color: #0d1b2a; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Login</button>
        </form>

        <p style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
            Don't have an account? <a href="signup.php" style="color: #f39c12; text-decoration: none; font-weight: bold;">Sign Up</a>
        </p>
    </div>

</body>
</html>