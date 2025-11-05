<?php
include 'db_connect.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];

    $stmt = $conn->prepare("INSERT INTO tarefas (titulo, descricao, usuario_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $titulo, $descricao, $id_usuario);
    $stmt->execute();
}

$tarefas = $conn->query("SELECT * FROM tarefas WHERE usuario_id = $id_usuario");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Tarefas</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Suas Tarefas</h1>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descricao" placeholder="Descrição"></textarea>
        <button type="submit">Adicionar</button>
    </form>

    <table>
        <tr><th>Título</th><th>Status</th><th>Ações</th></tr>
        <?php while($t = $tarefas->fetch_assoc()): ?>
        <tr>
            <td><?= $t['titulo'] ?></td>
            <td><?= $t['status'] ?></td>
            <td>
                <a href="public/editar_tarefa.php?id=<?= $t['id'] ?>">Editar</a> | 
                <a href="public/excluir_tarefa.php?id=<?= $t['id'] ?>">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="menu.php">Voltar</a>
</body>
</html>
