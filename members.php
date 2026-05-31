<?php
include 'config.php';
include 'header.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch members
$members_res = $conn->query("SELECT id, name, flat_number, phone FROM members ORDER BY id ASC");
$members = [];
while($row = $members_res->fetch_assoc()){
    $members[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Living Members</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
/* Smooth sexy dashboard theme */
body {
    background: linear-gradient(to bottom right, #fef3c7, #dbeafe, #fed7aa);
    min-height: 100vh;
    padding: 2rem;
    font-family: 'Inter', sans-serif;
}

/* Card Styling */
.card {
    background-color: #ffffff;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

/* Card hover */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

/* DataTables Styles */
.dataTables_wrapper .dataTables_paginate {
    margin-top: 1rem;
    text-align: right;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #1E3A8A !important;
    background: #f3f4f6 !important;
    border: 1px solid #d1d5db !important;
    border-radius: 0.25rem !important;
    padding: 0.25rem 0.5rem !important;
    margin: 0 2px !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #1E3A8A !important;
    color: #fff !important;
}
.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    color: #000;
}
.dataTables_wrapper select {
    border-radius: 0.25rem;
    border: 1px solid #d1d5db;
    padding: 0.25rem 0.5rem;
    color: #000;
    background: #fff;
}

/* Members Table Styling */
#membersTable {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    background-color: #fef9f2; /* smooth warm tint */
    border-radius: 1rem;
    overflow: hidden;
}

#membersTable th, #membersTable td {
    padding: 0.75rem 1rem;
    text-align: left;
}

#membersTable thead tr {
    background-color: #f3f4f6;
    font-weight: bold;
    color: #000;
}

#membersTable tbody tr {
    transition: all 0.3s ease;
    cursor: default;
}

#membersTable tbody tr:hover {
    background-color: #dbeafe; /* light blue hover */
}

#membersTable tbody td {
    color: #1f2937;
}

/* Optional: scroll if too many members */
#membersTable_wrapper {
    max-height: 500px;
    overflow-y: auto;
}
</style>
</head>
<body>

<div class="card mb-6">
    <h2 class="text-2xl font-bold mb-4 text-green-600">Current Living Members</h2>

    <div class="mb-4">
        <input type="text" id="searchMembers" placeholder="Search Members..." class="w-full md:w-1/3 p-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <div class="overflow-x-auto">
        <table id="membersTable" class="min-w-full">
            <thead>
                <tr>
                    <th class="py-3 px-4 text-left font-semibold text-black">ID</th>
                    <th class="py-3 px-4 text-left font-semibold text-black">Name</th>
                    <th class="py-3 px-4 text-left font-semibold text-black">Flat Number</th>
                    <th class="py-3 px-4 text-left font-semibold text-black">Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($members as $member): ?>
                <tr>
                    <td class="py-2 px-4"><?= $member['id'] ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($member['name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($member['flat_number']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($member['phone']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#membersTable').DataTable({
        "pageLength": 10
    });

    // Search input
    $('#searchMembers').on('input', function() {
        table.search(this.value).draw();
    });
});
</script>

</body>
</html>
