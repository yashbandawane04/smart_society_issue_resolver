<?php
include 'config.php';
include 'header.php'; // header.php already has session_start() and navigation

// Only residents can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'resident') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);

    $image_path = NULL;
    if(isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        $target_dir = "uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $image_path = $target_dir . $image_name;
        if(!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
            $error = "Failed to upload image.";
            $image_path = NULL;
        }
    }

    $sql = "INSERT INTO issues (user_id, title, description, category, image) 
            VALUES ('$user_id', '$title', '$description', '$category', '$image_path')";

    if($conn->query($sql)) {
        $success = "Issue submitted successfully!";
    } else {
        $error = "Database error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Report Issue - Residency Tracker</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
/* Glowing Inputs & Select & Textarea */
input, textarea, select {
  transition: all 0.3s ease;
  box-shadow: 0 0 0px transparent;
}
input:focus, textarea:focus, select:focus {
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
form {
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
    <h1 class="text-3xl font-extrabold mb-6 text-center text-blue-500 animate-pulse">Report an Issue</h1>

    <?php if(isset($success)) echo "<p class='success-msg text-green-600 mb-4 font-semibold'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='error-msg text-red-600 mb-4 font-semibold'>$error</p>"; ?>

    <form method="post" enctype="multipart/form-data" class="bg-white shadow-2xl rounded-3xl p-8 space-y-5">
        <input type="text" name="title" placeholder="Issue Title" required
               class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-300 text-gray-700">

        <textarea name="description" placeholder="Describe your issue..." required rows="4"
                  class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-red-400 focus:ring-2 focus:ring-red-300 text-gray-700"></textarea>

        <select name="category" required
                class="w-full p-3 rounded-xl border-2 border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-300 text-gray-700">
            <option value="">Select Category</option>
            <option value="Water Leakage">Water Leakage</option>
            <option value="Electricity Fault">Electricity Fault</option>
            <option value="Cleanliness">Cleanliness</option>
            <option value="Maintenance">Maintenance</option>
        </select>

        <input type="file" name="image"
               class="w-full text-gray-700 rounded-xl border-2 border-gray-200 p-2 hover:border-red-400 transition-all">

        <button type="submit" class="w-full text-white font-bold py-3 rounded-2xl">Submit Issue</button>
    </form>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
