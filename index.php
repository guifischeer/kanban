<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Kanban</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <h1>Menu</h1>
    <ul>
        <li><a href="public/usuarios.php">Cadastrar Usuário</a></li>
        <li><a href="public/tarefas.php">Cadastrar Tarefa</a></li>
        <li><a href="public/gerenciar.php">Gerenciar Tarefas</a></li>
    </ul>

    <link rel="stylesheet" href="styles/style.css">

<div class="container">
    <h1>Login</h1>
    <form action="public/gerenciar.php" method="post">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <a href="public/cadastrar.php">Criar conta</a>
</div>

</body>
</html>
