<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kanban";
$port = 3307; 

$conn = new mysqli('127.0.0.1', $username, $password, $dbname, 3307);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
