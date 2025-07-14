<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message = "All password fields are required!";
    } else {
        // Verify current password
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (!password_verify($current_password, $user['password'])) {
            $error_message = "Current password is not the same with the old password";
        } elseif ($new_password !== $confirm_new_password) {
            $error_message = "New password and Re-Enter new password should be the same.";
        } elseif (strlen($new_password) < 6) {
            $error_message = "New password must be at least 6 characters long";
        } else {
            // Update password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_new_password, $user_id);
            
            if ($update_stmt->execute()) {
                $success_message = "Password changed successfully!";
            } else {
                $error_message = "Error updating password: " . $update_stmt->error;
            }
            $update_stmt->close();
        }
        $stmt->close();
    }
}

// Get user information
$sql = "SELECT firstname, lastname, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity B - User Dashboard</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: #333;
            font-size: 32px;
            font-weight: 700;
        }
        
        .header .user-info {
            text-align: right;
        }
        
        .header .user-name {
            color: #667eea;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .card h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
        }
        
        .profile-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        
        .profile-info .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .profile-info .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .profile-info .label {
            font-weight: 600;
            color: #555;
        }
        
        .profile-info .value {
            color: #333;
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
            padding: 12px;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
        }
        
        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>User Dashboard</h1>
                <p style="color: #666; margin-top: 5px;">Welcome to your profile management</p>
            </div>
            <div class="user-info">
                <div class="user-name">
                    <?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?>
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-grid">
            <!-- User Profile Information -->
            <div class="card">
                <h2>Profile Information</h2>
                
                <div class="profile-info">
                    <div class="info-row">
                        <span class="label">First Name:</span>
                        <span class="value"><?php echo htmlspecialchars($user_info['firstname']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Last Name:</span>
                        <span class="value"><?php echo htmlspecialchars($user_info['lastname']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo htmlspecialchars($user_info['email']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Member Since:</span>
                        <span class="value"><?php echo date('F j, Y', strtotime($user_info['created_at'])); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">User ID:</span>
                        <span class="value"><?php echo htmlspecialchars($user_id); ?></span>
                    </div>
                </div>
                
                <div style="background: #e7f3ff; padding: 15px; border-radius: 10px; border: 1px solid #b3d7ff; color: #0066cc; font-size: 14px;">
                    <strong>Session Information:</strong><br>
                    Your session is active and secure.<br>
                    Data retrieved from MySQL database.
                </div>
            </div>

            <!-- Change Password -->
            <div class="card">
                <h2>Change Password</h2>
                
                <?php if ($success_message): ?>
                <div class="success-message">
                    <?php echo $success_message; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="current_password">Enter Current Password:</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">Enter New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_new_password">Re-Enter New Password:</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" required>
                    </div>
                    
                    <button type="submit" name="change_password" class="submit-btn">Change Password</button>
                </form>
                
                <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 10px; margin-top: 20px; font-size: 14px;">
                    <strong>Password Requirements:</strong><br>
                    • Current password must match your old password<br>
                    • New passwords must match<br>
                    • Minimum 6 characters required
                </div>
            </div>
        </div>
    </div>
</body>
</html>
