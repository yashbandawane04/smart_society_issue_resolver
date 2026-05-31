<?php
include 'config.php';
include 'header.php'; // session_start() + nav

// Only residents can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'resident') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $datetime = $conn->real_escape_string($_POST['datetime']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO reminders (user_id, title, datetime, description) 
            VALUES ('$user_id', '$title', '$datetime', '$description')";
    if($conn->query($sql)) {
        $success = "Reminder added successfully!";
    } else {
        $error = "Database error: " . $conn->error;
    }
}

// Fetch existing reminders
$reminders_res = $conn->query("SELECT * FROM reminders WHERE user_id='$user_id' ORDER BY datetime ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reminders - Residency Tracker</title>
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
form, .reminder-card {
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
    <h1 class="text-3xl font-extrabold mb-6 text-center text-blue-500 animate-pulse">Set a Reminder</h1>

    <?php if(isset($success)) echo "<p class='success-msg text-green-600 mb-4 font-semibold'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='error-msg text-red-600 mb-4 font-semibold'>$error</p>"; ?>

    <form method="post" class="bg-white shadow-2xl rounded-3xl p-8 space-y-5">
        <input type="text" name="title" placeholder="Reminder Title" required
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-300 text-gray-700">

        <input type="datetime-local" name="datetime" required
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-red-400 focus:ring-2 focus:ring-red-300 text-gray-700">

        <textarea name="description" placeholder="Description (optional)" rows="3"
                  class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-300 text-gray-700"></textarea>

        <button type="submit" class="w-full text-white font-bold py-3 rounded-2xl">Add Reminder</button>
    </form>

    <h2 class="text-2xl font-bold mt-10 mb-4 text-red-500">Your Reminders</h2>
    <div class="space-y-4">
        <?php while($reminder = $reminders_res->fetch_assoc()): ?>
        <div class="reminder-card bg-white rounded-2xl shadow-xl p-5 transition-all hover:shadow-2xl hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-blue-600"><?= htmlspecialchars($reminder['title']) ?></h3>
            <p class="text-gray-700 mt-1"><?= htmlspecialchars($reminder['description']) ?></p>
            <p class="text-gray-500 mt-1 font-medium">When: <?= date("d M Y, H:i", strtotime($reminder['datetime'])) ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
