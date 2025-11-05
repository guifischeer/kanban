<?php
session_start();
include 'db_connect.php';
if (isset($_SESSION['usuario_id'])) {
    header('Location: menu.php');
    exit;
}
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare('SELECT id,nome,senha FROM usuarios WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($user = $res->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {
            // login ok
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            header('Location: menu.php');
            exit;
        } else {
            $msg = 'Senha incorreta.';
        }
    } else {
        $msg = 'Usuário não encontrado.';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login - Kanban</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="card">
        <h2>Entrar</h2>
        <?php if ($msg): ?><p class="error"><?=htmlspecialchars($msg)?></p><?php endif; ?>
        <form method="post" autocomplete="off">
            <label>E-mail</label>
            <input type="email" name="email" required>
            <label>Senha</label>
            <input type="password" name="senha" required>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</body>
</html>
