<?php
session_start();
require_once 'config.php';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$registration_result = '';
$show_result = false;
$error_message = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $firstname = sanitize_input($_POST['firstname']);
    $lastname = sanitize_input($_POST['lastname']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password and confirm password are not the same";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long";
    } else {
        // Check if email already exists
        $check_email = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error_message = "Email already exists!";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $registration_result = "Registration Successful!<br>
                                       Name: $firstname $lastname<br>
                                       Email: $email<br>
                                       Data has been saved to the database.";
                $show_result = true;
                
                // Clear form fields after successful registration
                $firstname = $lastname = $email = '';
            } else {
                $error_message = "Error: " . $stmt->error;
            }
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
    <title>Activity B - Registration with MySQL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-600 min-h-screen py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Navigation -->
        <div class="text-center mb-8">
            <a href="ActB.php" class="inline-block px-6 py-3 mx-2 bg-white text-gray-800 rounded-full font-semibold shadow hover:-translate-y-1 hover:shadow-lg transition <?php echo basename($_SERVER['PHP_SELF']) == 'ActB.php' ? 'bg-green-500 text-white' : ''; ?>">Registration</a>
            <a href="login.php" class="inline-block px-6 py-3 mx-2 bg-white text-gray-800 rounded-full font-semibold shadow hover:-translate-y-1 hover:shadow-lg transition <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'bg-green-500 text-white' : ''; ?>">Login</a>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-2xl p-10 shadow-xl max-w-lg mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">User Registration</h2>
            
            <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-300 text-red-700 px-6 py-4 rounded-lg mb-6 text-center">
                <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-5">
                    <label for="firstname" class="block mb-2 text-gray-700 font-semibold">First Name:</label>
                    <input type="text" id="firstname" name="firstname" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" 
                           value="<?php echo isset($firstname) ? htmlspecialchars($firstname) : ''; ?>" required>
                </div>
                
                <div class="mb-5">
                    <label for="lastname" class="block mb-2 text-gray-700 font-semibold">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" 
                           value="<?php echo isset($lastname) ? htmlspecialchars($lastname) : ''; ?>" required>
                </div>
                
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-gray-700 font-semibold">Email:</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" 
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
                
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-gray-700 font-semibold">Password:</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" required>
                </div>
                
                <div class="mb-8">
                    <label for="confirm_password" class="block mb-2 text-gray-700 font-semibold">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-lg" required>
                </div>
                
                <button type="submit" name="register" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-4 rounded-lg text-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition">
                    Register
                </button>
            </form>

            <!-- Registration Result -->
            <?php if ($show_result): ?>
            <div class="bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-lg mt-6 text-center">
                <h3 class="font-bold mb-2">Registration Result:</h3>
                <p><?php echo $registration_result; ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Database Information -->
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mt-6 text-sm">
                <strong>Database Info:</strong><br>
                Database: sa3_activityb<br>
                Table: users<br>
                All registration data is saved to MySQL database
            </div>
        </div>
    </div>
</body>
</html>