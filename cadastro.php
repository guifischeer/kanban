<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Erro ao cadastrar. E-mail já existente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Kanban</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h2>Cadastrar Usuário</h2>
    <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required><br>
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p><a href="index.php">Voltar ao login</a></p>
</body>
</html>
