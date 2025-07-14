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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-600 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center text-white mb-12">
            <h1 class="text-6xl font-bold mb-4 drop-shadow-lg">Activity B</h1>
            <p class="text-xl opacity-90">MySQL Authentication System with Complete User Management</p>
        </div>

        <!-- Main Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Registration Card -->
            <div class="bg-white rounded-2xl p-8 shadow-xl text-center transform hover:scale-105 transition duration-300">
                <div class="text-6xl mb-6">👤</div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">User Registration</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Create a new account with our comprehensive registration system. 
                    All data is securely stored in MySQL database with password validation 
                    and instant feedback display.
                </p>
                <a href="ActB.php" class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-4 px-8 rounded-lg font-semibold text-lg hover:-translate-y-1 hover:shadow-lg transition">
                    Register Now
                </a>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl p-8 shadow-xl text-center transform hover:scale-105 transition duration-300">
                <div class="text-6xl mb-6">🔐</div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Secure Login</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Access your account with our secure login system. 
                    Features include session management, password verification, 
                    and complete user dashboard access.
                </p>
                <a href="login.php" class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-8 rounded-lg font-semibold text-lg hover:-translate-y-1 hover:shadow-lg transition">
                    Login Here
                </a>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white bg-opacity-90 p-6 rounded-xl text-center shadow-lg">
                <div class="text-3xl mb-3">🗄️</div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">MySQL Integration</h3>
                <p class="text-sm text-gray-600">Complete database integration with automatic table creation and secure password hashing.</p>
            </div>
            
            <div class="bg-white bg-opacity-90 p-6 rounded-xl text-center shadow-lg">
                <div class="text-3xl mb-3">🔒</div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Session Management</h3>
                <p class="text-sm text-gray-600">Secure session handling with automatic redirects and access control protection.</p>
            </div>
            
            <div class="bg-white bg-opacity-90 p-6 rounded-xl text-center shadow-lg">
                <div class="text-3xl mb-3">👥</div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">User Dashboard</h3>
                <p class="text-sm text-gray-600">Complete profile management with password change functionality and validation.</p>
            </div>
            
            <div class="bg-white bg-opacity-90 p-6 rounded-xl text-center shadow-lg">
                <div class="text-3xl mb-3">✅</div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Form Validation</h3>
                <p class="text-sm text-gray-600">Comprehensive validation with password confirmation and detailed error messaging.</p>
            </div>
        </div>

        <!-- Database Information -->
        <div class="bg-white rounded-2xl p-8 shadow-xl text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Database Specifications</h2>
            <p class="text-gray-600 mb-8">
                This system uses MySQL database for secure data storage and user management
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
                    <div class="text-sm font-semibold text-gray-700">Database Name</div>
                    <div class="text-lg font-bold text-indigo-600">sa3_activityb</div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
                    <div class="text-sm font-semibold text-gray-700">Table Name</div>
                    <div class="text-lg font-bold text-indigo-600">users</div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
                    <div class="text-sm font-semibold text-gray-700">Host</div>
                    <div class="text-lg font-bold text-indigo-600">localhost</div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
                    <div class="text-sm font-semibold text-gray-700">Security</div>
                    <div class="text-lg font-bold text-indigo-600">Hashed</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
