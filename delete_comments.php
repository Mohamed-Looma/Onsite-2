<?php
require_once '../Config.php';

if (isset($_GET['comments_id'])) {
    $statment=$pdo->prepare("DELETE FROM `comments` WHERE `	comments_id ` = ?");
    $statment->execute([$_GET['comments_id']]);
    header("Location: comments.php");
    exit();


}

?>