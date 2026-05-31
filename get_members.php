<?php
include 'config.php';

$res = $conn->query("SELECT id, name, flat_number, phone FROM members ORDER BY name ASC");
$members = [];
while($row = $res->fetch_assoc()){
    $members[] = $row;
}
header('Content-Type: application/json');
echo json_encode($members);
