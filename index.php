<?php
session_start();
include('db.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $staff_result = $conn->query("SELECT * FROM staff WHERE email = '$email'");
    if ($staff_result && $staff_result->num_rows > 0) {
        $staff = $staff_result->fetch_assoc();
        if ($password === $staff['password'] || password_verify($password, $staff['password'])) {
            $_SESSION['staff_email'] = $staff['email'];
            $_SESSION['staff_name'] = $staff['name'];
            $_SESSION['staff_role'] = $staff['role'];
            header("Location: dashboard.php");
            exit();
        }
    }

    
    $admin_result = $conn->query("SELECT * FROM admin");
    if ($admin_result && $admin_result->num_rows > 0) {
        while ($admin = $admin_result->fetch_assoc()) {
            $db_user = $admin['email'] ?? $admin['username'] ?? $admin['user'] ?? '';
            $db_pass = $admin['password'] ?? '';
            if ($email === $db_user && $password === $db_pass) {
                $_SESSION['admin'] = $db_user;
                header("Location: dashboard.php");
                exit();
            }
        }
    }


    $user_result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($user_result && $user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        if ($password === $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home.php");
            exit();
        }
    }

    $error = "Invalid Email or Password!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Hotel Elite</title>
    <style>
        * { box-sizing: border-box;
         margin: 0;
          padding: 0;
           font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
        body { 
            background: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }
        .login-card { 
            background: #ffffff; 
            padding: 40px 35px; 
            border-radius: 10px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        h2 { 
            color: #0d1b2a; 
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 25px; 
        }
        .form-group { 
            margin-bottom: 20px; 
            text-align: left;
        }
        label { 
            display: block; 
            font-weight: bold; 
            margin-bottom: 8px; 
            color: #333; 
            font-size: 0.9rem; 
        }
        input[type="email"], input[type="password"] { 
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-size: 0.95rem; 
            outline: none;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #f39c12;
        }
        .btn-login { 
            background: #f39c12; 
            color: white; 
            border: none; 
            padding: 12px; 
            width: 100%; 
            font-weight: bold; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 1rem; 
            margin-top: 5px;
            transition: background 0.2s;
        }
        .btn-login:hover { 
        background: #d68910; 
        }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 10px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            font-size: 0.85rem; 
            font-weight: bold; 
        }
        .links { 
            margin-top: 20px; 
            font-size: 0.9rem; 
            color: #555;
        }
        .links a { 
            color: #007bff; 
            text-decoration: none; 
            font-weight: bold; 
        }
        .links a:hover {
         text-decoration: underline; 
         }
        .back-home {
            display: block;
            margin-top: 15px;
            color: #007bff;
            font-size: 0.9rem;
            text-decoration: none;
            font-weight: 500;
        }
        .back-home:hover {
         text-decoration: underline;
          }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login to Hotel Elite</h2>
        
        <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="Enter email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        
        <div class="links">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            <a href="home.php" class="back-home">&larr; Back to Home</a>
        </div>
    </div>
</body>
</html>