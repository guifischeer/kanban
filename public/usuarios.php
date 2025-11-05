<?php
// Exemplo: endpoint para listar usuários (apenas para admin). NÃO expor em produção.
include __DIR__ . '/../db_connect.php';
$res = $conn->query('SELECT id,nome,email,criado_em FROM usuarios ORDER BY criado_em DESC');
$users = [];
while($r = $res->fetch_assoc()) $users[] = $r;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($users);
?>