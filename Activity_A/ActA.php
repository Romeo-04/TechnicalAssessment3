<?php
session_start();

// If user is already logged in, redirect to home
if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}

$registration_result = '';
$show_result = false;

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if ($password !== $confirm_password) {
        $registration_result = "Password and confirm password are not the same";
    } else {
        $registration_result = "Registration Successful!<br>
                               Name: $firstname $lastname<br>
                               Email: $email<br>
                               Password: " . str_repeat('*', strlen($password));
    }
    $show_result = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Module</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <div class="mb-8 text-center">
            <a href="ActA.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Registration</a>
            <a href="login.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Login</a>
        </div>

        <!-- Registration Form -->
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">User Registration</h2>
            
            <form method="POST" action="" class="space-y-4">
                <div>
                    <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password:</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <button type="submit" name="register" 
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Register
                </button>
            </form>
        </div>

        <!-- Registration Result -->
        <?php if ($show_result): ?>
        <div class="max-w-md mx-auto mt-6 p-4 <?php echo ($password !== $confirm_password) ? 'bg-red-100 border border-red-400 text-red-700' : 'bg-green-100 border border-green-400 text-green-700'; ?> rounded">
            <h3 class="font-bold mb-2">Registration Result:</h3>
            <p><?php echo $registration_result; ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>