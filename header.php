<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include 'config.php';

// Protect pages: redirect if not logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Get user info
$role = $_SESSION['role'];
$name = $_SESSION['name'];
?>

<!-- Navigation -->
<nav class="bg-white shadow p-4 flex justify-between items-center mb-6">
    <div class="flex items-center space-x-3">
        <img src="RT.png" alt="Trackify Logo" class="h-10 w-10 rounded-full object-cover" />
        <h1 class="text-xl font-bold">Residency Trackify</h1>
    </div>
    <div class="flex space-x-4 items-center">
        <?php if($role == 'resident'): ?>
            <a href="dashboard.php" class="text-white hover:underline">Dashboard</a>
        <?php elseif($role == 'admin'): ?>
            <a href="view_issues.php" class="text-blue-600 hover:underline">All Issues</a>
        <?php endif; ?>
        <span class="font-semibold"><?= htmlspecialchars($name) ?></span>
        <a href="logout.php" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Logout</a>
    </div>
</nav>