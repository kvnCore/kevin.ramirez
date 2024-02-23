<?php
include "includes/dbh.inc.php";
$url = "reddits.json";
$response = file_get_contents($url);
$data = json_decode($response, true);

foreach ($data['data']['children'] as $subreddit) {
    $name = $subreddit['data']['display_name'];

    
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM subreddits WHERE name = ?");
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

 
    if ($count == 0) {
        $image_url = $subreddit['data']['icon_img'];
        $title = $subreddit['data']['title'];
        $description = $subreddit['data']['public_description'];
        $subscribers = $subreddit['data']['subscribers'];
        $url = $subreddit['data']['url'];


        $stmt = $conn->prepare("INSERT INTO subreddits (name, image_url, title, description, subscribers, url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $name, $image_url, $title, $description, $subscribers, $url);
        $stmt->execute();
        $stmt->close();
    }
}

echo "Subreddits almacenados en la base de datos.";

$conn->close();
header("Location: reddits.php");
exit();

?>


