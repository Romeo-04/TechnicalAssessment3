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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-600 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-2xl p-8 mb-8 shadow-xl">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">User Dashboard</h1>
                    <p class="text-gray-600">Welcome to your profile management</p>
                </div>
                <div class="text-center md:text-right">
                    <div class="text-lg font-semibold text-indigo-600 mb-2">
                        <?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?>
                    </div>
                    <a href="logout.php" class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition hover:-translate-y-1 hover:shadow-lg">
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- User Profile Information -->
            <div class="bg-white rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Profile Information</h2>
                
                <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="font-semibold text-gray-700">First Name:</span>
                        <span class="text-gray-900"><?php echo htmlspecialchars($user_info['firstname']); ?></span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="font-semibold text-gray-700">Last Name:</span>
                        <span class="text-gray-900"><?php echo htmlspecialchars($user_info['lastname']); ?></span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="font-semibold text-gray-700">Email:</span>
                        <span class="text-gray-900"><?php echo htmlspecialchars($user_info['email']); ?></span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="font-semibold text-gray-700">Member Since:</span>
                        <span class="text-gray-900"><?php echo date('F j, Y', strtotime($user_info['created_at'])); ?></span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="font-semibold text-gray-700">User ID:</span>
                        <span class="text-gray-900"><?php echo htmlspecialchars($user_id); ?></span>
                    </div>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mt-6 text-sm">
                    <strong>Session Information:</strong><br>
                    Your session is active and secure.<br>
                    Data retrieved from MySQL database.
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Change Password</h2>
                
                <?php if ($success_message): ?>
                <div class="bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-lg mb-6 text-center">
                    <?php echo $success_message; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-lg mb-6 text-center">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-5">
                        <label for="current_password" class="block mb-2 text-gray-700 font-semibold">Enter Current Password:</label>
                        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" required>
                    </div>
                    
                    <div class="mb-5">
                        <label for="new_password" class="block mb-2 text-gray-700 font-semibold">Enter New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" required>
                    </div>
                    
                    <div class="mb-8">
                        <label for="confirm_new_password" class="block mb-2 text-gray-700 font-semibold">Re-Enter New Password:</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" required>
                    </div>
                    
                    <button type="submit" name="change_password" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-4 rounded-lg text-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition">
                        Change Password
                    </button>
                </form>
                
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mt-6 text-sm">
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
