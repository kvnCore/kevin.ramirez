<?php
include "includes/dbh.inc.php";

$sql = "SELECT * FROM subreddits";
$result = $conn->query($sql);

$subreddits = array();
while ($row = $result->fetch_assoc()) {
    $subreddits[] = $row;
}

header('Content-Type: application/json');
echo json_encode($subreddits);

$conn->close();
?>
