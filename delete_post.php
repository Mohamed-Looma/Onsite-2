<?php
require_once '../Config.php';

if (isset($_GET['id'])) {
    $statment=$pdo->prepare("DELETE FROM `post` WHERE `post_id` = ?");
    $statment->execute([$_GET['id']]);
    header("Location: display_all_posts.php");
    exit();


}

?>