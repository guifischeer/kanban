<?php
include 'db_connect.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal - Kanban</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Bem-vindo, <?= $_SESSION['usuario_nome'] ?>!</h1>
    <a href="tarefas.php">Gerenciar Tarefas</a> | 
    <a href="logout.php">Sair</a>

    <h3>Consultar CEP (API ViaCEP)</h3>
    <input type="text" id="cep" placeholder="Digite o CEP">
    <button onclick="buscarCEP()">Buscar</button>
    <div id="resultado"></div>

    <script>
    async function buscarCEP() {
        const cep = document.getElementById('cep').value;
        const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await res.json();
        document.getElementById('resultado').innerHTML = `
            <p><strong>Logradouro:</strong> ${data.logradouro || 'Não encontrado'}</p>
            <p><strong>Bairro:</strong> ${data.bairro || 'Não encontrado'}</p>
            <p><strong>Cidade:</strong> ${data.localidade || 'Não encontrado'}</p>
        `;
    }
    </script>
</body>
</html>
