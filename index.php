<?php
include 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password))
		{
        header("Location: home.php");
        exit();
    }
	else
		{
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display: flex;
 justify-content: center;
 align-items: center;
 height: 100vh;">

    <div class="form-container">
        <h2 style="text-align: center;
		color: #0d1b2a;
		margin-bottom: 20px;">Hotel Elite Login</h2>
        <?php 
		if($error != "")
			{
				echo "<p style='color:red; text-align:center;'>$error</p>"; 
				}
				?>
        
        <form method="POST" action="">
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email">
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>

        <p style="text-align: center; margin-top: 20px; color: #666;">
            Don't have an account? <a href="signup.php" style="color: #f39c12;
			text-decoration: none; 
			font-weight: bold;">Sign Up</a>
        </p>
    </div>

</body>
</html>