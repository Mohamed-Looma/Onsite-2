<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'php_blog';

$pdo =new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

?>