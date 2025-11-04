<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kanban";
$port = 4333; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
