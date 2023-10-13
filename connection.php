<?php
$server = 'database';
$scheme = 'assignment1';
$username = 'root';
$password = 'root';
$connection = new PDO("mysql:host=$server;dbname=$scheme", $username, $password,[PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION]);
?>