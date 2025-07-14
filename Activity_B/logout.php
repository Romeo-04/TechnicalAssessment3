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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-600 min-h-screen flex items-center justify-center py-8">
    <div class="bg-white rounded-2xl p-10 shadow-xl text-center max-w-md w-full mx-4">
        <div class="mb-6">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Logout Successful</h2>
        <p class="text-gray-600 mb-6 leading-relaxed">
            You have been successfully logged out. Your session has been destroyed for security.
        </p>
        
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-6 text-sm">
            <strong>Auto Redirect:</strong><br>
            You will be redirected to the login page in 3 seconds...
        </div>
        
        <div class="space-y-3">
            <a href="login.php" class="block w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition">
                Login Again
            </a>
            <a href="ActB.php" class="block w-full bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition">
                Registration
            </a>
        </div>
    </div>
</body>
</html>
