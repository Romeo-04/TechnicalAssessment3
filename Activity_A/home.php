
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Welcome <?php echo htmlspecialchars($username); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Welcome to Homepage</h1>
                    <p class="text-lg text-gray-600 mt-2">
                        Hello, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($username); ?></span>!
                    </p>
                </div>
                <div>
                    <a href="logout.php" 
                       class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Session Information</h3>
                    <p class="text-blue-700">
                        <strong>Username:</strong> <?php echo htmlspecialchars($username); ?><br>
                        <strong>Session ID:</strong> <?php echo session_id(); ?><br>
                        <strong>Login Time:</strong> <?php echo date('Y-m-d H:i:s'); ?>
                    </p>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">Access Control</h3>
                    <p class="text-green-700">
                        You are successfully logged in and have access to protected content.
                        Your session is active and secure.
                    </p>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Protected Area</h3>
                <p class="text-yellow-700">
                    This page is protected by session authentication. Users without an active session 
                    cannot access this page and will be redirected to the login page.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
