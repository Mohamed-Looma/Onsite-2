<?php
require_once '../Config.php';

if (isset($_GET['id'])) {
    $statment=$pdo->prepare("DELETE FROM `catogry` WHERE `cat_id` = ?");
    $statment->execute([$_GET['id']]);
    header("Location: categorise.php");
    exit();


}

?>