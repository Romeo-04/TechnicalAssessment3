<?php
session_start();

// Destroy all session data
session_destroy();

// Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity B - Logout</title>
    <meta http-equiv="refresh" content="3;url=login.php">
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .logout-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }
        
        .success-icon::after {
            content: "✓";
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        
        .logout-title {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .logout-message {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .redirect-info {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            color: #0066cc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 480px) {
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="success-icon"></div>
        
        <h2 class="logout-title">Logout Successful</h2>
        
        <p class="logout-message">
            You have been successfully logged out of the system. 
            All your session data has been destroyed for security purposes.
        </p>
        
        <div class="redirect-info">
            <strong>Auto Redirect:</strong><br>
            You will be automatically redirected to the login page in 3 seconds...
        </div>
        
        <div class="action-buttons">
            <a href="login.php" class="btn btn-primary">Login Again</a>
            <a href="ActB.php" class="btn btn-secondary">Registration</a>
        </div>
    </div>
</body>
</html>
