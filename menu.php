<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$usuario_id = (int)$_SESSION['usuario_id'];
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Kanban - Painel</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <h1>Kanban</h1>
        <div class="userbox">
            <span><?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
            <a href="logout.php">Sair</a>
        </div>
    </header>
    <main>
        <section class="kanban">
            <div class="column">
                <h3>A Fazer</h3>
                <?php
                $stmt = $conn->prepare("SELECT id,titulo,descricao,criado_em FROM tarefas WHERE usuario_id = ? AND status = 'A Fazer' ORDER BY criado_em DESC");
                $stmt->bind_param('i', $usuario_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($t = $res->fetch_assoc()):
                ?>
                    <div class="card-task">
                        <h4><?= htmlspecialchars($t['titulo']) ?></h4>
                        <p><?= nl2br(htmlspecialchars($t['descricao'])) ?></p>
                        <small><?= htmlspecialchars($t['criado_em']) ?></small>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="column">
                <h3>Fazendo</h3>
                <?php
                $stmt = $conn->prepare("SELECT id,titulo,descricao,criado_em FROM tarefas WHERE usuario_id = ? AND status = 'Fazendo' ORDER BY criado_em DESC");
                $stmt->bind_param('i', $usuario_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($t = $res->fetch_assoc()):
                ?>
                    <div class="card-task">
                        <h4><?= htmlspecialchars($t['titulo']) ?></h4>
                        <p><?= nl2br(htmlspecialchars($t['descricao'])) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="column">
                <h3>Pronto</h3>
                <?php
                $stmt = $conn->prepare("SELECT id,titulo,descricao,criado_em FROM tarefas WHERE usuario_id = ? AND status = 'Pronto' ORDER BY criado_em DESC");
                $stmt->bind_param('i', $usuario_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($t = $res->fetch_assoc()):
                ?>
                    <div class="card-task">
                        <h4><?= htmlspecialchars($t['titulo']) ?></h4>
                        <p><?= nl2br(htmlspecialchars($t['descricao'])) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
        <aside class="side">
            <h3>Adicionar Tarefa</h3>
            <form id="formTarefa" method="post" action="public/add_tarefa.php">
                <input type="hidden" name="action" value="create">
                <label>Título</label>
                <input type="text" name="titulo" required>
                <label>Descrição</label>
                <textarea name="descricao"></textarea>
                <label>CEP (opcional)</label>
                <input type="text" id="cep" name="cep" placeholder="01001000">
                <button type="button" onclick="buscarCEP()">Buscar Endereço</button>
                <p id="endereco"></p>
                <button type="submit">Salvar</button>
            </form>
            <div class="api-box">
                <h3>Sugestão automática (BoredAPI)</h3>
                <button type="button" onclick="buscarSugestao()">Gerar ideia</button>
                <p id="sugestao"></p>
            </div>
        </aside>
    </main>
    <script>
        function buscarSugestao() {
            fetch('https://www.boredapi.com/api/activity/')
                .then(r => r.json())
                .then(data => document.getElementById('sugestao').innerText = data.activity)
                .catch(e => console.error(e));
        }

        function buscarCEP() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');
            if (!cep) {
                alert('Digite um CEP');
                return;
            }
            fetch('api/via_cep.php?cep=' + cep)
                .then(r => r.json())
                .then(data => {
                    if (data.erro) {
                        document.getElementById('endereco').innerText = 'CEP não encontrado';
                        return;
                    }
                    document.getElementById('endereco').innerText = data.logradouro + ', ' + data.bairro + ' - ' + data.localidade + '/' + data.uf;
                }).catch(e => console.error(e));
        }
    </script>
</body>

</html>