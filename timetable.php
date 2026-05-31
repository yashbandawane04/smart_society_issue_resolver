<?php
session_start();
include 'config.php';
include 'header.php';

// Only residents can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'resident') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";
$success = "";

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO timetable (user_id, title, event_date, start_time, end_time, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $event_date, $start_time, $end_time, $description);

    if($stmt->execute()) {
        $success = "Event added successfully!";
    } else {
        $error = "Database error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch events
$stmt = $conn->prepare("SELECT * FROM timetable WHERE user_id=? ORDER BY event_date ASC, start_time ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Timetable - Residency Tracker</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
/* Glowing Inputs */
input, textarea {
  transition: all 0.3s ease;
  box-shadow: 0 0 0px transparent;
}
input:focus, textarea:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(60, 179, 113, 0.7);
  transform: scale(1.02);
}

/* Gradient Button */
button {
  background: linear-gradient(90deg, #FF3C3C, #1E90FF);
  transition: all 0.3s ease;
}
button:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(30, 144, 255, 0.6);
}

/* Card Animation */
form, .event-card {
  animation: fadeInUp 0.8s ease forwards;
  opacity: 0;
}
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Success/Error Animations */
.success-msg, .error-msg {
  animation: fadeIn 0.8s ease forwards;
  opacity: 0;
}
@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(-10px);}
  100% { opacity: 1; transform: translateY(0);}
}
</style>
</head>
<body class="bg-gradient-to-r from-red-100 via-blue-100 to-orange-100 min-h-screen p-6">

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-extrabold mb-6 text-center text-blue-500 animate-pulse">Add a Timetable Event</h1>

    <?php if($success) echo "<p class='success-msg text-green-600 mb-4 font-semibold'>$success</p>"; ?>
    <?php if($error) echo "<p class='error-msg text-red-600 mb-4 font-semibold'>$error</p>"; ?>

    <form method="post" class="bg-white shadow-2xl rounded-3xl p-8 space-y-5">
        <input type="text" name="title" placeholder="Event Title" required
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-300 text-gray-700">

        <input type="date" name="event_date" required
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-red-400 focus:ring-2 focus:ring-red-300 text-gray-700">

        <input type="time" name="start_time" required
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-green-400 focus:ring-2 focus:ring-green-300 text-gray-700">

        <input type="time" name="end_time"
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-300 text-gray-700">

        <textarea name="description" placeholder="Description (optional)" rows="3"
                  class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-300 text-gray-700"></textarea>

        <button type="submit" class="w-full text-white font-bold py-3 rounded-2xl">Add Event</button>
    </form>

    <h2 class="text-2xl font-bold mt-10 mb-4 text-red-500">Your Timetable</h2>
    <div class="space-y-4">
        <?php while($row = $res->fetch_assoc()): ?>
        <div class="event-card bg-white rounded-2xl shadow-xl p-5 transition-all hover:shadow-2xl hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-blue-600"><?= htmlspecialchars($row['title']) ?></h3>
            <p class="text-gray-700 mt-1"><?= htmlspecialchars($row['description']) ?></p>
            <p class="text-gray-500 mt-1 font-medium">
                Date: <?= date("d M Y", strtotime($row['event_date'])) ?>, 
                Time: <?= date("H:i", strtotime($row['start_time'])) ?> - <?= $row['end_time'] ? date("H:i", strtotime($row['end_time'])) : '-' ?>
            </p>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
