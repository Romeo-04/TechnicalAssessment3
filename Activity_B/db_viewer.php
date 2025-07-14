<?php
require_once 'config.php';

// Get database and table information
$database_info = [];
$users_data = [];

// Get database info
$db_info_query = "SELECT SCHEMA_NAME as database_name FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = 'sa3_activityb'";
$result = $conn->query($db_info_query);
if ($result && $result->num_rows > 0) {
    $database_info = $result->fetch_assoc();
}

// Get table structure
$table_structure = [];
$structure_query = "DESCRIBE users";
$result = $conn->query($structure_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $table_structure[] = $row;
    }
}

// Get users data (limit to recent 10 users for display)
$users_query = "SELECT id, firstname, lastname, email, created_at FROM users ORDER BY created_at DESC LIMIT 10";
$result = $conn->query($users_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users_data[] = $row;
    }
}

// Get total users count
$count_query = "SELECT COUNT(*) as total_users FROM users";
$result = $conn->query($count_query);
$total_users = 0;
if ($result) {
    $count_data = $result->fetch_assoc();
    $total_users = $count_data['total_users'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity B - Database Viewer</title>
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
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .header h1 {
            color: #333;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 16px;
        }
        
        .navigation {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .nav-btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            background: white;
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
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #e1e1e1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e1e1e1;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #e1e1e1;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
        }
        
        .info-value {
            color: #333;
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
            font-weight: 600;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            color: #333;
        }
        
        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 Database Viewer</h1>
            <p>Activity B - MySQL Database Structure and Data</p>
        </div>

        <!-- Navigation -->
        <div class="navigation">
            <a href="index.php" class="nav-btn">Home</a>
            <a href="ActB.php" class="nav-btn">Registration</a>
            <a href="login.php" class="nav-btn">Login</a>
            <a href="db_viewer.php" class="nav-btn" style="background: #4CAF50; color: white;">Database</a>
        </div>

        <!-- Database Information -->
        <div class="cards-grid">
            <!-- Database Info -->
            <div class="card">
                <h2>🗄️ Database Information</h2>
                
                <div class="info-item">
                    <span class="info-label">Database Name:</span>
                    <span class="info-value">sa3_activityb</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Host:</span>
                    <span class="info-value">localhost</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Connection:</span>
                    <span class="info-value">MySQL</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="background: #d4edda; color: #155724;">Connected</span>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $total_users; ?></div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Tables</div>
                    </div>
                </div>
            </div>

            <!-- Table Structure -->
            <div class="card">
                <h2>🏗️ Table Structure</h2>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Null</th>
                                <th>Key</th>
                                <th>Default</th>
                                <th>Extra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table_structure as $column): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($column['Field']); ?></strong></td>
                                <td><?php echo htmlspecialchars($column['Type']); ?></td>
                                <td><?php echo htmlspecialchars($column['Null']); ?></td>
                                <td><?php echo htmlspecialchars($column['Key']); ?></td>
                                <td><?php echo htmlspecialchars($column['Default'] ?? 'NULL'); ?></td>
                                <td><?php echo htmlspecialchars($column['Extra']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Users Data -->
        <div class="card">
            <h2>👥 Registered Users Data</h2>
            
            <?php if (empty($users_data)): ?>
            <div class="empty-state">
                <h3>No Users Found</h3>
                <p>No users have been registered yet. Use the registration form to add users to the database.</p>
                <a href="ActB.php" class="nav-btn" style="margin-top: 20px; background: #667eea; color: white;">Register Now</a>
            </div>
            <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users_data as $user): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($user['id']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo date('M j, Y H:i', strtotime($user['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if ($total_users > 10): ?>
            <div style="text-align: center; margin-top: 20px; padding: 15px; background: #e7f3ff; border-radius: 8px; color: #0066cc;">
                <strong>Note:</strong> Showing latest 10 users. Total users in database: <?php echo $total_users; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
