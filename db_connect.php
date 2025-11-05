<?php
// Ajuste estas variáveis conforme seu ambiente local
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'kanban';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_errno) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
// Não iniciar session aqui; cada página chama session_start() quando necessário
?>
