<?php
// Arquivo apenas para criar um usuário de teste. REMOVA APÓS USAR.
include 'db_connect.php';
$nome = 'Teste';
$email = 'teste@local';
$senha = 'senha123';
$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO usuarios (nome,email,senha) VALUES (?,?,?)');
$stmt->bind_param('sss', $nome, $email, $hash);
if ($stmt->execute()) echo 'Usuário criado: '.$email.' / '.$senha;
else echo 'Erro: '.$stmt->error;
?>