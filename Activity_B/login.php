<?php
session_start();
require_once 'config.php';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error_message = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required!";
    } else {
        // Check user credentials
        $sql = "SELECT id, firstname, lastname, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                // Login successful - create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                $error_message = "Invalid email or password!";
            }
        } else {
            $error_message = "Invalid email or password!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity B - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .navigation {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .nav-btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            background: #fff;
            color: #333;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        .nav-btn.active {
            background: #4CAF50;
            color: white;
        }
        
        .form-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 450px;
            margin: 0 auto;
        }
        
        .form-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
        }
        
        .error-container {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .info-container {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            color: #0066cc;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <div class="navigation">
            <a href="ActB.php" class="nav-btn">Registration</a>
            <a href="login.php" class="nav-btn active">Login</a>
        </div>

        <!-- Login Form -->
        <div class="form-container">
            <h2 class="form-title">User Login</h2>
            
            <?php if ($error_message): ?>
            <div class="error-container">
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" name="login" class="submit-btn">Login</button>
            </form>
            
            <div class="register-link">
                Don't have an account? <a href="ActB.php">Register here</a>
            </div>
            
            <!-- Database Information -->
            <div class="info-container">
                <strong>Login Info:</strong><br>
                Use your registered email and password to login.<br>
                System will verify credentials from MySQL database.
            </div>
        </div>
    </div>
</body>
</html>
