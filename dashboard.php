<?php
include 'config.php';
include 'header.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];
$user_role = $_SESSION['role'];

$pending_issues = 3; 
$upcoming_reminders = 2;
$upcoming_events = 1;

// Fetch issues and their votes
$issues_res = $conn->query("SELECT id, title, category, status, votes FROM issues ORDER BY id ASC");
$issues = [];
while($row = $issues_res->fetch_assoc()){
    $issues[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Residency Tracker</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="assets/css/style.css">
<style>
.recent-issues td:not(.status):not(.vote) {
    color: #000 !important;
}
.vote-btn {
    background-color: #1E3A8A;
    color: white;
    font-weight: bold;
    padding: 0.3rem 0.7rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}
.vote-btn:hover {
    background-color: #3749b0;
    transform: scale(1.05);
}
/* DataTables pagination and length controls visible */
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
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>
<body class="bg-gradient-to-br from-red-50 via-blue-50 to-orange-50 min-h-screen p-6">

<div class="flex flex-col md:flex-row justify-between items-center mb-6 p-6 bg-white rounded-2xl shadow-lg">
    <h1 class="text-3xl font-extrabold text-red-600">Welcome, <?= htmlspecialchars($user_name) ?>!</h1>
</div>

<h2 class="text-3xl font-bold mb-6 text-orange-500">Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="report_issue.php" class="card bg-red-100 hover:bg-red-200 transition-all transform hover:-translate-y-2 shadow-xl p-6 rounded-2xl">
        <h3 class="text-xl font-bold mb-2 text-red-600">Issue Reporter</h3>
        <p class="mb-2 text-gray-700">Report new issues like water leakage, electricity faults, or cleaning requests.</p>
        <span class="inline-block mt-2 px-3 py-1 bg-red-50 text-red-800 rounded-full font-semibold animate-pulse">Pending: <?= $pending_issues ?></span>
    </a>
    <a href="reminders.php" class="card bg-blue-100 hover:bg-blue-200 transition-all transform hover:-translate-y-2 shadow-xl p-6 rounded-2xl">
        <h3 class="text-xl font-bold mb-2 text-blue-600">Reminders</h3>
        <p class="mb-2 text-gray-700">Set reminders for maintenance, bills, or society meetings.</p>
        <span class="inline-block mt-2 px-3 py-1 bg-blue-50 text-blue-800 rounded-full font-semibold animate-pulse">Upcoming: <?= $upcoming_reminders ?></span>
    </a>
    <a href="timetable.php" class="card bg-orange-100 hover:bg-orange-200 transition-all transform hover:-translate-y-2 shadow-xl p-6 rounded-2xl">
        <h3 class="text-xl font-bold mb-2 text-orange-600">Society Timetable</h3>
        <p class="mb-2 text-gray-700">View weekly events like water tank cleaning, power outage timings, and meetings.</p>
        <span class="inline-block mt-2 px-3 py-1 bg-orange-50 text-orange-800 rounded-full font-semibold animate-pulse">Next Event: <?= $upcoming_events ?></span>
    </a>
   <a href="members.php" target="_blank" class="card bg-green-100 hover:bg-green-200 transition-all transform hover:-translate-y-2 shadow-xl p-6 rounded-2xl cursor-pointer">
    <h3 class="text-xl font-bold mb-2 text-green-600">Living Members</h3>
    <p class="mb-2 text-gray-700">Click to see all active members in the society.</p>
</a>

</div>

<!-- Living Members Section -->
<div id="membersList" class="hidden mt-6 bg-white rounded-2xl shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-green-600">Current Living Members</h2>
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-3 px-4 text-left font-semibold text-black">ID</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Name</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Flat Number</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Phone</th>
            </tr>
        </thead>
        <tbody id="membersTbody">
            <!-- Members will be dynamically populated here -->
        </tbody>
    </table>
</div>

<div class="mb-4">
    <input type="text" id="searchIssues" placeholder="Search Issues..." class="w-full md:w-1/3 p-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="overflow-x-auto bg-white rounded-2xl shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-blue-600">Recent Issues</h2>
    <table id="issuesTable" class="min-w-full recent-issues">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-3 px-4 text-left font-semibold text-black">ID</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Title</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Category</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Status</th>
                <th class="py-3 px-4 text-left font-semibold text-black">Votes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($issues as $issue): ?>
            <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                <td class="py-2 px-4 font-medium"><?= $issue['id'] ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($issue['title']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($issue['category']) ?></td>
                <td class="py-2 px-4 font-bold status <?= $issue['status']=='Pending'?'text-red-600':($issue['status']=='In Progress'?'text-yellow-600':'text-green-600') ?>"><?= $issue['status'] ?></td>
                <td class="py-2 px-4">
                    <button class="vote-btn" data-issue-id="<?= $issue['id'] ?>">Vote</button>
                    <span id="votes-<?= $issue['id'] ?>"><?= $issue['votes'] ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Pie Chart -->
<div class="mt-10 bg-white rounded-2xl shadow-lg p-6 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-green-600">Votes Distribution</h2>
    <canvas id="votesChart"></canvas>
</div>

<!-- Top 3 Priority Table -->
<div class="mt-6 bg-white rounded-2xl shadow-lg p-6 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-red-600">Top 3 Priority Issues</h2>
    <table class="min-w-full text-black">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 text-left font-semibold">Rank</th>
                <th class="py-2 px-4 text-left font-semibold">Title</th>
                <th class="py-2 px-4 text-left font-semibold">Votes</th>
                <th class="py-2 px-4 text-left font-semibold">Status</th>
            </tr>
        </thead>
        <tbody class="text-black">
            <?php
            $sorted_issues = $issues;
            usort($sorted_issues, function($a,$b){ return $b['votes'] - $a['votes']; });
            $top3 = array_slice($sorted_issues, 0, 3);
            $rank = 1;
            foreach($top3 as $issue):
            ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="py-2 px-4 font-medium"><?= $rank++ ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($issue['title']) ?></td>
                <td class="py-2 px-4 font-bold"><?= $issue['votes'] ?></td>
                <td class="py-2 px-4 font-bold <?= $issue['status']=='Pending'?'text-red-600':($issue['status']=='In Progress'?'text-yellow-600':'text-green-600') ?>">
                    <?= $issue['status'] ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
let issues = <?= json_encode($issues) ?>;

function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for(let i = 0; i < 6; i++){
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

const ctx = document.getElementById('votesChart').getContext('2d');
const colors = issues.map(() => getRandomColor());
const votesChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: issues.map(i => i.title),
        datasets: [{ data: issues.map(i => parseInt(i.votes)), backgroundColor: colors, borderColor: '#fff', borderWidth: 2 }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' }, tooltip: { callbacks: { label: function(context){ return context.label + ': ' + context.parsed; } } } } }
});

document.querySelectorAll('.vote-btn').forEach(button => {
    button.addEventListener('click', () => {
        const issueId = button.dataset.issueId;
        fetch('vote_issue.php', { method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body: `issue_id=${issueId}` })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                document.getElementById(`votes-${issueId}`).textContent = parseInt(document.getElementById(`votes-${issueId}`).textContent) + 1;
                issues.find(i => i.id == issueId).votes += 1;
                votesChart.data.datasets[0].data = issues.map(i => parseInt(i.votes));
                votesChart.update();
            } else { alert(data.message); }
        });
    });
});

setInterval(() => {
    fetch('get_votes.php')
    .then(res => res.json())
    .then(data => {
        issues.forEach(issue => {
            const updated = data.find(d => d.id == issue.id);
            if(updated){
                issue.votes = parseInt(updated.votes);
                document.getElementById(`votes-${issue.id}`).textContent = issue.votes;
            }
        });
        votesChart.data.datasets[0].data = issues.map(i => i.votes);
        votesChart.update();
    });
}, 5000);

const searchInput = document.getElementById('searchIssues');
searchInput.addEventListener('input', () => {
    const filter = searchInput.value.toLowerCase();
    document.querySelectorAll('.recent-issues tbody tr').forEach(row => {
        const title = row.cells[1].textContent.toLowerCase();
        const category = row.cells[2].textContent.toLowerCase();
        const status = row.cells[3].textContent.toLowerCase();
        row.style.display = (title.includes(filter) || category.includes(filter) || status.includes(filter)) ? '' : 'none';
    });
});

$(document).ready(function() {
    $('#issuesTable').DataTable({ "pageLength": 10, "columnDefs": [ { "orderable": false, "targets": 4 } ] });
});

document.getElementById('viewMembersBtn').addEventListener('click', () => {
    const membersDiv = document.getElementById('membersList');
    membersDiv.classList.toggle('hidden');
    if(!membersDiv.classList.contains('hidden')){
        fetch('get_members.php')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('membersTbody');
            tbody.innerHTML = '';
            data.forEach(member => {
                const tr = document.createElement('tr');
                tr.className = 'bg-gray-50 hover:bg-gray-100 transition-colors';
                tr.innerHTML = `<td class="py-2 px-4">${member.id}</td><td class="py-2 px-4">${member.name}</td><td class="py-2 px-4">${member.flat_number}</td><td class="py-2 px-4">${member.phone}</td>`;
                tbody.appendChild(tr);
            });
        });
    }
});
</script>

<script src="assets/js/script.js"></script>

<footer class="bg-white mt-12 p-8 rounded-2xl shadow-inner">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <h3 class="text-xl font-bold text-red-600 mb-2">Panchavati Apartment </h3>
            <p class="text-gray-700">Vijaybaug Kalyan West 421301</p>
            <p class="text-gray-700 mt-1">Phone: +91 98765 43210</p>
            <p class="text-gray-700 mt-1">Email: info@panchavati.com</p>
        </div>
        <div>
            <h3 class="text-xl font-bold text-blue-600 mb-2">Quick Links</h3>
            <ul class="text-gray-700 space-y-1">
                <li><a href="report_issue.php" class="hover:text-blue-800">Report Issue</a></li>
                <li><a href="reminders.php" class="hover:text-blue-800">Reminders</a></li>
                <li><a href="timetable.php" class="hover:text-blue-800">Timetable</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-bold text-green-600 mb-2">Location</h3>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019291468973!2d144.96305771531753!3d-37.81410797975159!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f1f1f1f1%3A0x123456789abcdef!2sSample+Location!5e0!3m2!1sen!2sin!4v1692880000000!5m2!1sen!2sin" 
                width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <div class="text-center mt-6 text-gray-500 text-sm">
        &copy; <?= date('Y') ?> Panchavati Apartment. All rights reserved.
    </div>
</footer>

</body>
</html>
