<?php
session_start();
include('db.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $staff_result = $conn->query("SELECT * FROM staff WHERE email = '$email'");
    
    if ($staff_result && $staff_result->num_rows > 0) {
        $staff = $staff_result->fetch_assoc();
        
        if ($password === $staff['password'] || password_verify($password, $staff['password'])) {
            $_SESSION['staff_email'] = $staff['email'];
            $_SESSION['staff_name'] = $staff['name'];
            $_SESSION['staff_role'] = $staff['role'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $admin_result = $conn->query("SELECT * FROM admin");
        $admin_logged = false;

        if ($admin_result && $admin_result->num_rows > 0) {
            while ($admin = $admin_result->fetch_assoc()) {
                $db_user = $admin['email'] ?? $admin['username'] ?? $admin['user'] ?? '';
                $db_pass = $admin['password'] ?? '';

                if ($email === $db_user && $password === $db_pass) {
                    $_SESSION['admin'] = $db_user;
                    $admin_logged = true;
                    header("Location: dashboard.php");
                    exit();
                }
            }
        }

        if (!$admin_logged) {
            $error = "Invalid Email/Username or Password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin & Staff Login - Hotel Elite</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #0d1b2a;
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.6rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
            font-size: 0.9rem;
        }

        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-login {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #0056b3;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #0d1b2a;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Hotel Elite Login</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Email or Username</label>
                <input type="text" name="email" required placeholder="Enter username or email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter password">
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="back-link">
            <a href="index.php">&larr; Back to Home</a>
        </div>
    </div>

</body>
</html>