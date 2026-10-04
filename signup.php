<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Elite - Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display: flex; 
justify-content: center; 
align-items: center;
 height: 100vh;">

    <div class="form-container">
        <h2 style="text-align: center; 
		color: #0d1b2a;
		margin-bottom: 20px;">Create an Account</h2>
        
        <form action="home.php" method="POST">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" required placeholder="Enter your full name">
            </div>

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" required placeholder="Enter your email">
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <input type="password" required placeholder="Create a password">
            </div>
            
            <button type="submit" class="btn">Sign Up</button>
        </form>

        <p style="text-align: center; 
		margin-top: 20px;
		color: #666;">
            Already have an account? <a href="index.php" 
			style="color: #f39c12; 
			text-decoration: none;
			font-weight: bold;">Login</a>
        </p>
    </div>

</body>
</html>