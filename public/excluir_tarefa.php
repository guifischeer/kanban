<?php
session_start();
include __DIR__ . '/../db_connect.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}
$usuario_id = (int)$_SESSION['usuario_id'];
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $conn->prepare('DELETE FROM tarefas WHERE id=? AND usuario_id=?');
    $stmt->bind_param('ii', $id, $usuario_id);
    $stmt->execute();
}
header('Location: ../tarefas.php');
exit;
