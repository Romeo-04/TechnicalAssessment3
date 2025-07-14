<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity B - MySQL Authentication System</title>
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
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }
        
        .header h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .header p {
            font-size: 20px;
            opacity: 0.9;
        }
        
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 40px;
            color: white;
        }
        
        .register-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-icon {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .feature-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }
        
        .feature-description {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .feature-btn {
            display: inline-block;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .feature-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .feature-item {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .feature-item h3 {
            color: #333;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .feature-item p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .database-info {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .database-info h2 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .db-specs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .db-spec {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .db-spec .label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        .db-spec .value {
            color: #667eea;
            font-weight: 700;
            font-size: 16px;
        }
        
        @media (max-width: 768px) {
            .main-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .header h1 {
                font-size: 36px;
            }
            
            .header p {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Activity B</h1>
            <p>MySQL Authentication System with Complete User Management</p>
        </div>

        <!-- Main Options -->
        <div class="main-grid">
            <!-- Registration Card -->
            <div class="feature-card">
                <div class="feature-icon register-icon">👤</div>
                <h2 class="feature-title">User Registration</h2>
                <p class="feature-description">
                    Create a new account with our comprehensive registration system. 
                    All data is securely stored in MySQL database with password validation 
                    and instant feedback display.
                </p>
                <a href="ActB.php" class="feature-btn btn-register">Register Now</a>
            </div>

            <!-- Login Card -->
            <div class="feature-card">
                <div class="feature-icon login-icon">🔐</div>
                <h2 class="feature-title">Secure Login</h2>
                <p class="feature-description">
                    Access your account with our secure login system. 
                    Features include session management, password verification, 
                    and complete user dashboard access.
                </p>
                <a href="login.php" class="feature-btn btn-login">Login Here</a>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="features-grid">
            <div class="feature-item">
                <h3>🗄️ MySQL Integration</h3>
                <p>Complete database integration with automatic table creation and secure password hashing using PHP's password_hash() function.</p>
            </div>
            
            <div class="feature-item">
                <h3>🔒 Session Management</h3>
                <p>Secure session handling with automatic redirects and access control to protect user areas and maintain login state.</p>
            </div>
            
            <div class="feature-item">
                <h3>👥 User Dashboard</h3>
                <p>Complete user profile management with password change functionality and real-time validation of user credentials.</p>
            </div>
            
            <div class="feature-item">
                <h3>✅ Form Validation</h3>
                <p>Comprehensive client and server-side validation with password confirmation and detailed error messaging system.</p>
            </div>
        </div>

        <!-- Database Information -->
        <div class="database-info">
            <h2>Database Specifications</h2>
            <p style="color: #666; margin-bottom: 30px;">
                This system uses MySQL database for secure data storage and user management
            </p>
            
            <div class="db-specs">
                <div class="db-spec">
                    <div class="label">Database Name</div>
                    <div class="value">sa3_activityb</div>
                </div>
                
                <div class="db-spec">
                    <div class="label">Table Name</div>
                    <div class="value">users</div>
                </div>
                
                <div class="db-spec">
                    <div class="label">Host</div>
                    <div class="value">localhost</div>
                </div>
                
                <div class="db-spec">
                    <div class="label">Password Security</div>
                    <div class="value">Hashed</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
