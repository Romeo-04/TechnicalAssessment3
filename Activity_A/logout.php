<?php
session_start();

// Destroy all session data
session_destroy();

// Clear any existing cookies if user wants to logout completely
setcookie('username', '', time() - 3600, '/');
setcookie('password', '', time() - 3600, '/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="3;url=login.php">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
            <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Logout Successful</h2>
            <p class="text-gray-600 mb-6">
                You have been successfully logged out. Your session has been destroyed.
            </p>
            
            <div class="space-y-3">
                <p class="text-sm text-gray-500">
                    You will be redirected to the login page in 3 seconds...
                </p>
                
                <div class="space-x-4">
                    <a href="login.php" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Login Again
                    </a>
                    <a href="ActA.php" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Registration
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
