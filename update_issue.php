<?php
include 'config.php'; // DB connection
include 'header.php'; // Includes session_start() and navigation

// Only admin can access this page
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Redirect if no issue ID is provided
if(!isset($_GET['id'])) {
    header("Location: view_issues.php");
    exit();
}

$id = (int)$_GET['id']; // cast to int for safety

// Handle status update
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $conn->real_escape_string($_POST['status']);
    $sql = "UPDATE issues SET status='$status' WHERE id='$id'";
    if($conn->query($sql)) {
        header("Location: view_issues.php");
        exit();
    } else {
        $error = "Error updating issue: " . $conn->error;
    }
}

// Fetch issue details for displaying in the form
$sql = "SELECT * FROM issues WHERE id='$id'";
$res = $conn->query($sql);
$issue = $res->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Issue - Residency Tracker</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-100 p-6">

<h1 class="text-3xl font-bold mb-6">Update Issue Status</h1>

<?php if(isset($error)) echo "<p class='text-red-600 mb-4'>$error</p>"; ?>

<form method="post" class="bg-white p-6 rounded shadow max-w-md">
    <h2 class="font-bold text-xl mb-4"><?= htmlspecialchars($issue['title']) ?></h2>
    <select name="status" class="w-full p-2 mb-4 border rounded">
        <option value="Pending" <?= $issue['status']=='Pending'?'selected':'' ?>>Pending</option>
        <option value="In Progress" <?= $issue['status']=='In Progress'?'selected':'' ?>>In Progress</option>
        <option value="Resolved" <?= $issue['status']=='Resolved'?'selected':'' ?>>Resolved</option>
    </select>
    <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Update Status</button>
</form>

<script src="assets/js/script.js"></script>
</body>
</html>
