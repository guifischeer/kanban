<?php
include('../db_connect.php');




if (isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $prioridade = $_POST['prioridade'];
    $stmt = $conn->prepare("UPDATE tarefas SET status=?, prioridade=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $prioridade, $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['excluir'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}


$tarefas = $conn->query("SELECT t.*, u.nome AS usuario_nome FROM tarefas t JOIN usuarios u ON t.usuario_id = u.id ORDER BY t.data_cadastro DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Tarefas</title>
 <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <h1>Gerenciamento de Tarefas</h1>
    <div class="kanban">
        <?php
        $status_colunas = ['A Fazer','Fazendo','Pronto'];
        foreach ($status_colunas as $status_col) {
            echo "<div class='coluna'><h2>$status_col</h2>";
            foreach($tarefas as $tarefa) {
                if($tarefa['status'] == $status_col){
                    echo "<div class='tarefa'>
                        <p><strong>Descrição:</strong> {$tarefa['descricao']}</p>
                        <p><strong>Setor:</strong> {$tarefa['setor']}</p>
                        <p><strong>Prioridade:</strong> {$tarefa['prioridade']}</p>
                        <p><strong>Usuário:</strong> {$tarefa['usuario_nome']}</p>
                        <form method='POST'>
                            <input type='hidden' name='id' value='{$tarefa['id']}'>
                            <select name='status'>
                                <option value='A Fazer' ".($tarefa['status']=='A Fazer'?'selected':'').">A Fazer</option>
                                <option value='Fazendo' ".($tarefa['status']=='Fazendo'?'selected':'').">Fazendo</option>
                                <option value='Pronto' ".($tarefa['status']=='Pronto'?'selected':'').">Pronto</option>
                            </select>
                            <select name='prioridade'>
                                <option value='Baixa' ".($tarefa['prioridade']=='Baixa'?'selected':'').">Baixa</option>
                                <option value='Média' ".($tarefa['prioridade']=='Média'?'selected':'').">Média</option>
                                <option value='Alta' ".($tarefa['prioridade']=='Alta'?'selected':'').">Alta</option>
                            </select>
                            <button type='submit' name='atualizar'>Atualizar</button>
                            <button type='submit' name='excluir' onclick='return confirm(\"Deseja realmente excluir?\")'>Excluir</button>
                        </form>
                    </div>";
                }
            }
            echo "</div>";
        }
        ?>
    </div>
    <a href="../index.php">Voltar ao menu</a>

</body>
</html>
