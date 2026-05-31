<?php
include 'config.php';
$issues_res = $conn->query("SELECT id, votes FROM issues ORDER BY id ASC");
$data = [];
while($row = $issues_res->fetch_assoc()){
    $data[] = $row;
}
echo json_encode($data);
?>
