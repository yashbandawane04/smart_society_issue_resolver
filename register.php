<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'resident'; // All new registrations are residents

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($check && $check->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if($conn->query($sql)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Registration failed: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Residency Tracker</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

    <!-- Display error message -->
    <?php if(isset($error)): ?>
    <p class="text-red-600 mb-4 text-center"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required class="w-full p-2 mb-4 border rounded">
        <input type="email" name="email" placeholder="Email" required class="w-full p-2 mb-4 border rounded">
        <input type="password" name="password" placeholder="Password" required class="w-full p-2 mb-4 border rounded">
        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Register</button>
    </form>

    <p class="mt-4 text-center">Already have an account? 
        <a href="index.php" class="text-blue-600 hover:underline">Login</a>
    </p>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
