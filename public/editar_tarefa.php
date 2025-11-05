<?php
session_start();
include __DIR__ . '/../db_connect.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}
$usuario_id = (int)$_SESSION['usuario_id'];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $conn->prepare('SELECT * FROM tarefas WHERE id = ? AND usuario_id = ? LIMIT 1');
    $stmt->bind_param('ii', $id, $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($t = $res->fetch_assoc()) {
?>
        <!doctype html>
        <html lang="pt-br">

        <head>
            <meta charset="utf-8">
            <title>Editar</title>
            <link rel="stylesheet" href="../styles/style.css">
        </head>

        <body>
            <h2>Editar Tarefa</h2>
            <form method="post">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <label>Título</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($t['titulo']) ?>" required>
                <label>Descrição</label>
                <textarea name="descricao"><?= htmlspecialchars($t['descricao']) ?></textarea>
                <label>Status</label>
                <select name="status">
                    <option <?= $t['status'] == 'A Fazer' ? 'selected' : '' ?>>A Fazer</option>
                    <option <?= $t['status'] == 'Fazendo' ? 'selected' : '' ?>>Fazendo</option>
                    <option <?= $t['status'] == 'Pronto' ? 'selected' : '' ?>>Pronto</option>
                </select>
                <button type="submit">Salvar</button>
            </form>
            <p><a href="../tarefas.php">Voltar</a></p>
        </body>

        </html>
<?php
        exit;
    } else {
        header('Location: ../tarefas.php');
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $status = $_POST['status'] ?? 'A Fazer';
    $stmt = $conn->prepare('UPDATE tarefas SET titulo=?, descricao=?, status=? WHERE id=? AND usuario_id=?');
    $stmt->bind_param('sssii', $titulo, $descricao, $status, $id, $usuario_id);
    $stmt->execute();
    header('Location: ../tarefas.php');
    exit;
}
?>