<?php
include('../db_connect.php');


$mensagem = '';


$usuarios = $conn->query("SELECT id, nome FROM usuarios");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $descricao = trim($_POST['descricao']);
    $setor = trim($_POST['setor']);
    $prioridade = $_POST['prioridade'];

    if ($usuario_id && $descricao && $setor && $prioridade) {
        $stmt = $conn->prepare("INSERT INTO tarefas (usuario_id, descricao, setor, prioridade) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $usuario_id, $descricao, $setor, $prioridade);

        if ($stmt->execute()) {
            $mensagem = "Tarefa cadastrada com sucesso";
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
    <title>Cadastro de Tarefas</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <h1>Cadastro de Tarefas</h1>
    <?php if($mensagem) echo "<p>$mensagem</p>"; ?>
    <form method="POST">
        <label>Usuário:</label>
        <select name="usuario_id" required>
            <option value="">Selecione</option>
            <?php while($user = $usuarios->fetch_assoc()): ?>
                <option value="<?= $user['id'] ?>"><?= $user['nome'] ?></option>
            <?php endwhile; ?>
        </select>
        <label>Descrição:</label>
        <textarea name="descricao" required></textarea>
        <label>Setor:</label>
        <input type="text" name="setor" required>
        <label>Prioridade:</label>
        <select name="prioridade" required>
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Alta">Alta</option>
        </select>
        <button type="submit">Cadastrar Tarefa</button>
    </form>
    <a href="../index.php">Voltar ao menu</a>

</body>
</html>
