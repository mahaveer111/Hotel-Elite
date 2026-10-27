<?php
include 'db.php';
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $error = "Email already registered! Please login.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                $success = "Registration successful! <a href='index.php' style='color: #f39c12; font-weight: bold;'>Login here</a>";
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
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-card { 
            background: white; 
            padding: 35px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            width: 100%;
            max-width: 380px; 
        }

        h2 { 
            text-align: center; 
            color: #0d1b2a; 
            margin-bottom: 25px; 
            font-size: 1.8rem; 
        }

        .form-group { 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            margin-bottom: 6px; 
            color: #495057; 
            font-weight: 600; 
            font-size: 0.9rem; 
        }

        input { 
            width: 100%; 
            padding: 10px 12px; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            font-size: 0.95rem; 
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-submit { 
            width: 100%; 
            padding: 12px; 
            background-color: #0d1b2a; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 1rem; 
            transition: background 0.2s; 
        }

        .btn-submit:hover { 
            background-color: #1b263b; 
        }

        .alert-error { 
            color: #721c24; 
            background-color: #f8d7da; 
            border: 1px solid #f5c6cb; 
            padding: 10px; 
            border-radius: 5px; 
            text-align: center; 
            font-size: 0.9rem; 
            margin-bottom: 20px; 
            font-weight: bold; 
        }

        .alert-success { 
            color: #155724; 
            background-color: #d4edda; 
            border: 1px solid #c3e6cb; 
            padding: 10px; 
            border-radius: 5px; 
            text-align: center; 
            font-size: 0.9rem; 
            margin-bottom: 20px; 
        }

        .login-link { 
            text-align: center; 
            margin-top: 20px; 
            color: #6c757d; 
            font-size: 0.9rem; 
        }

        .login-link a { 
            color: #f39c12; 
            text-decoration: none; 
            font-weight: bold; 
        }

        .login-link a:hover { 
            text-decoration: underline; 
        }
    </style>
</head>
<body>

    <div class="signup-card">
        <h2>Hotel Elite Sign Up</h2>
        
        <?php if($error != "") { echo "<div class='alert-error'>$error</div>"; } ?>
        <?php if($success != "") { echo "<div class='alert-success'>$success</div>"; } ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required placeholder="Enter your name">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email">
            </div>
            
            <div class="form-group" style="margin-bottom: 25px;">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn-submit">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="index.php">Login</a>
        </div>
    </div>

</body>
</html>