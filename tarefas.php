<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$usuario_id = (int)$_SESSION['usuario_id'];
// lista rápida de tarefas do usuário
$stmt = $conn->prepare('SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY criado_em DESC');
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Minhas Tarefas</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1>Minhas Tarefas</h1>
        <a href="menu.php">Voltar</a> | <a href="logout.php">Sair</a>
    </header>
    <main>
        <section>
            <form method="post" action="public/add_tarefa.php">
                <input type="hidden" name="action" value="create">
                <label>Título</label>
                <input type="text" name="titulo" required>
                <label>Descrição</label>
                <textarea name="descricao"></textarea>
                <button type="submit">Adicionar</button>
            </form>
        </section>
        <section>
            <table>
                <thead><tr><th>Título</th><th>Status</th><th>Ações</th></tr></thead>
                <tbody>
                <?php while($t = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?=htmlspecialchars($t['titulo'])?></td>
                        <td><?=htmlspecialchars($t['status'])?></td>
                        <td>
                            <a href="public/editar_tarefa.php?id=<?= $t['id'] ?>">Editar</a> |
                            <a href="public/excluir_tarefa.php?id=<?= $t['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
