<?php
session_start();
include __DIR__ . '/../db_connect.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}
$usuario_id = (int)$_SESSION['usuario_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    if ($titulo === '') {
        header('Location: ../tarefas.php');
        exit;
    }
    $stmt = $conn->prepare('INSERT INTO tarefas (titulo,descricao,usuario_id) VALUES (?,?,?)');
    $stmt->bind_param('ssi', $titulo, $descricao, $usuario_id);
    $stmt->execute();
}
header('Location: ../tarefas.php');
exit;
