<?php
include('../db_connect.php');


$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    if (!empty($nome) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $email);

        if ($stmt->execute()) {
            $mensagem = "Cadastro concluído com sucesso";
        } else {
            $mensagem = "Erro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos corretamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="../styles/style.css">

</head>
<body>
    <h1>Cadastro de Usuários</h1>
    <?php if($mensagem) echo "<p>$mensagem</p>"; ?>
    <form method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <label>E-mail:</label>
        <input type="email" name="email" required>
        <button type="submit">Cadastrar</button>
    </form>
    <a href="../index.php">Voltar ao menu</a>
</body>
</html>
