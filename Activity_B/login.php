<?php
session_start();
require_once 'config.php';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error_message = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required!";
    } else {
        // Check user credentials
        $sql = "SELECT id, firstname, lastname, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                // Login successful - create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                $error_message = "Invalid email or password!";
            }
        } else {
            $error_message = "Invalid email or password!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity B - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-600 min-h-screen py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Navigation -->
        <div class="text-center mb-8">
            <a href="ActB.php" class="inline-block px-6 py-3 mx-2 bg-white text-gray-800 rounded-full font-semibold shadow hover:-translate-y-1 hover:shadow-lg transition">Registration</a>
            <a href="login.php" class="inline-block px-6 py-3 mx-2 bg-green-500 text-white rounded-full font-semibold shadow hover:-translate-y-1 hover:shadow-lg transition">Login</a>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl p-10 shadow-xl max-w-lg mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">User Login</h2>
            
            <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-lg mb-6 text-center">
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-gray-700 font-semibold">Email:</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                
                <div class="mb-8">
                    <label for="password" class="block mb-2 text-gray-700 font-semibold">Password:</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" required>
                </div>
                
                <button type="submit" name="login" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-lg text-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition">
                    Login
                </button>
            </form>
            
            <div class="text-center mt-6">
                <span class="text-gray-600">Don't have an account? </span>
                <a href="ActB.php" class="text-indigo-600 hover:text-indigo-800 font-semibold">Register here</a>
            </div>
            
            <!-- Database Information -->
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mt-6 text-sm">
                <strong>Login Info:</strong><br>
                Use your registered email and password to login.<br>
                System will verify credentials from MySQL database.
            </div>
        </div>
    </div>
</body>
</html>
