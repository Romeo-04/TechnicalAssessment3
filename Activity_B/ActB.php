<?php
session_start();
require_once 'config.php';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$registration_result = '';
$show_result = false;
$error_message = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $firstname = sanitize_input($_POST['firstname']);
    $lastname = sanitize_input($_POST['lastname']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password and confirm password are not the same";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long";
    } else {
        // Check if email already exists
        $check_email = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error_message = "Email already exists!";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $registration_result = "Registration Successful!<br>
                                       Name: $firstname $lastname<br>
                                       Email: $email<br>
                                       Data has been saved to the database.";
                $show_result = true;
                
                // Clear form fields after successful registration
                $firstname = $lastname = $email = '';
            } else {
                $error_message = "Error: " . $stmt->error;
            }
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
    <title>Activity B - Registration with MySQL</title>
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
            max-width: 500px;
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
        
        .result-container {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
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
        
        .database-info {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            color: #0066cc;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <div class="navigation">
            <a href="ActB.php" class="nav-btn active">Registration</a>
            <a href="login.php" class="nav-btn">Login</a>
        </div>

        <!-- Registration Form -->
        <div class="form-container">
            <h2 class="form-title">User Registration</h2>
            
            <?php if ($error_message): ?>
            <div class="error-container">
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" 
                           value="<?php echo isset($firstname) ? htmlspecialchars($firstname) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" 
                           value="<?php echo isset($lastname) ? htmlspecialchars($lastname) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                
                <button type="submit" name="register" class="submit-btn">Register</button>
            </form>

            <!-- Registration Result -->
            <?php if ($show_result): ?>
            <div class="result-container">
                <h3>Registration Result:</h3>
                <p><?php echo $registration_result; ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Database Information -->
            <div class="database-info">
                <strong>Database Info:</strong><br>
                Database: sa3_activityb<br>
                Table: users<br>
                All registration data is saved to MySQL database
            </div>
        </div>
    </div>
</body>
</html>