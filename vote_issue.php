<?php
include 'config.php';
session_start();

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','message'=>'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_POST['issue_id'])){
    echo json_encode(['status'=>'error','message'=>'No issue ID']);
    exit();
}

$issue_id = intval($_POST['issue_id']);

// Check if user already voted
$check = $conn->prepare("SELECT * FROM issue_votes WHERE user_id=? AND issue_id=?");
$check->bind_param("ii",$user_id,$issue_id);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    echo json_encode(['status'=>'error','message'=>'You have already voted for this issue']);
    exit();
}

// Insert vote
$insert = $conn->prepare("INSERT INTO issue_votes (user_id, issue_id) VALUES (?, ?)");
$insert->bind_param("ii",$user_id,$issue_id);

if($insert->execute()){
    // Update total votes in issues table
    $update = $conn->prepare("UPDATE issues SET votes = votes + 1 WHERE id=?");
    $update->bind_param("i",$issue_id);
    $update->execute();

    echo json_encode(['status'=>'success','message'=>'Vote counted']);
} else {
    echo json_encode(['status'=>'error','message'=>'Database error']);
}
?>
