<?php
session_start();

// If user is already logged in, redirect to home
if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}

// Static credentials for authentication
class UserAuth {
    private static $username = 'admin';
    private static $password = 'password123';
    
    public static function authenticate($user, $pass) {
        return ($user === self::$username && $pass === self::$password);
    }
    
    public static function getUsername() {
        return self::$username;
    }
}

$error_message = '';
$username_value = '';
$password_value = '';
$remember_checked = '';

// Check for existing cookies
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username_value = $_COOKIE['username'];
    $password_value = $_COOKIE['password'];
    $remember_checked = 'checked';
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (UserAuth::authenticate($username, $password)) {
        // Set session
        $_SESSION['username'] = $username;
        
        // Handle cookies based on remember me checkbox
        if ($remember) {
            // Set cookies for 30 days
            setcookie('username', $username, time() + (30 * 24 * 60 * 60), '/');
            setcookie('password', $password, time() + (30 * 24 * 60 * 60), '/');
        } else {
            // Delete existing cookies
            setcookie('username', '', time() - 3600, '/');
            setcookie('password', '', time() - 3600, '/');
        }
        
        // Redirect to home page
        header('Location: home.php');
        exit();
    } else {
        $error_message = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Module</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <div class="mb-8 text-center">
            <a href="ActA.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Registration</a>
            <a href="login.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Login</a>
        </div>

        <!-- Login Form -->
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">User Login</h2>
            
            <?php if ($error_message): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username:</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo htmlspecialchars($username_value); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password:</label>
                    <input type="password" id="password" name="password" required 
                           value="<?php echo htmlspecialchars($password_value); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" <?php echo $remember_checked; ?>
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>
                
                <button type="submit" name="login" 
                        class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Login
                </button>
            </form>
            
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded">
                <p class="text-sm text-blue-700">
                    <strong>Test Credentials:</strong><br>
                    Username: admin<br>
                    Password: password123
                </p>
            </div>
        </div>
    </div>
</body>
</html>
