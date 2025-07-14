<?php
session_start();

// If user is already logged in, redirect to home
if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SA3 - Authentication System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">SA3 Authentication System</h1>
            <p class="text-lg text-gray-600">Complete Registration and Login Module with Session Management</p>
        </div>

        <!-- Main Options -->
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Registration Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center">
                        <div class="mb-4">
                            <svg class="mx-auto h-16 w-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">New User Registration</h2>
                        <p class="text-gray-600 mb-6">
                            Create a new account with our registration system. 
                            Fill in your details and get instant feedback.
                        </p>
                        <a href="ActA.php" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg inline-block transition duration-300">
                            Register Now
                        </a>
                    </div>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center">
                        <div class="mb-4">
                            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">User Login</h2>
                        <p class="text-gray-600 mb-6">
                            Access your account with secure login. 
                            Features include "Remember Me" functionality and session management.
                        </p>
                        <a href="login.php" 
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg inline-block transition duration-300">
                            Login Here
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-4xl mx-auto mt-12">
            <h3 class="text-2xl font-bold text-center mb-8 text-gray-800">System Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <h4 class="font-bold text-lg mb-2 text-blue-600">Registration Module</h4>
                    <p class="text-sm text-gray-600">
                        Complete form validation with password confirmation and instant feedback display.
                    </p>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <h4 class="font-bold text-lg mb-2 text-green-600">Login with Cookies</h4>
                    <p class="text-sm text-gray-600">
                        Secure login with "Remember Me" option using cookies for user convenience.
                    </p>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <h4 class="font-bold text-lg mb-2 text-purple-600">Session Management</h4>
                    <p class="text-sm text-gray-600">
                        Complete session handling with automatic redirects and access control.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
