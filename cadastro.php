<?php
include 'db_connect.php';
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: menu.php');
    exit;
}
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'Senha deve ter pelo menos 6 caracteres.';
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO usuarios (nome,email,senha) VALUES (?,?,?)');
        $stmt->bind_param('sss', $nome, $email, $hash);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Erro ao cadastrar. E-mail pode já estar em uso.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Cadastro - Kanban</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="card">
        <h2>Cadastro</h2>
        <?php if ($erro): ?><p class="error"><?=htmlspecialchars($erro)?></p><?php endif; ?>
        <form method="post" autocomplete="off">
            <label>Nome</label>
            <input type="text" name="nome" required>
            <label>E-mail</label>
            <input type="email" name="email" required>
            <label>Senha (mínimo 6 caracteres)</label>
            <input type="password" name="senha" required>
            <button type="submit">Cadastrar</button>
        </form>
        <p><a href="index.php">Voltar ao login</a></p>
    </div>
</body>
</html>
