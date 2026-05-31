<?php
include 'config.php'; // DB connection
include 'header.php'; // Includes session_start() and navigation

// Only admin can access this page
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all issues with resident names
$sql = "SELECT issues.*, users.name 
        FROM issues 
        JOIN users ON issues.user_id = users.id 
        ORDER BY issues.created_at DESC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Reported Issues - Residency Tracker</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-100 p-6">

<h1 class="text-3xl font-bold mb-6">All Reported Issues</h1>

<table class="min-w-full bg-white rounded shadow">
    <thead>
        <tr class="bg-gray-200">
            <th class="py-2 px-4 border">ID</th>
            <th class="py-2 px-4 border">Resident</th>
            <th class="py-2 px-4 border">Title</th>
            <th class="py-2 px-4 border">Category</th>
            <th class="py-2 px-4 border">Status</th>
            <th class="py-2 px-4 border">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
        <tr>
            <td class="py-2 px-4 border"><?= $row['id'] ?></td>
            <td class="py-2 px-4 border"><?= htmlspecialchars($row['name']) ?></td>
            <td class="py-2 px-4 border"><?= htmlspecialchars($row['title']) ?></td>
            <td class="py-2 px-4 border"><?= htmlspecialchars($row['category']) ?></td>
            <td class="py-2 px-4 border"><?= htmlspecialchars($row['status']) ?></td>
            <td class="py-2 px-4 border">
                <a href="update_issue.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Update</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script src="assets/js/script.js"></script>
</body>
</html>
