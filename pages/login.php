<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Login/Logout</title>
</head>
<body>
<header>
    <?php
        if (isset ($_SESSION['usuario'])) {
            echo "<h1>Bem Vindo ". $_SESSION['nome']; echo "</h1>";
            echo 
            "
                <form action='../methos/relizarLogout.php'>
                    <input class = 'botaoSair' type='submit' value='Sair'>
                </form>        
            ";
        } else {
            echo "<h1>Bem Vindo</h1>";
        }
    ?>
    <!-- penso em pegar o nome dele -> esse trechinho aqui em cima vai tentar fazer isso -->
    <?php
        if (isset ($_SESSION['usuario'])) {
            echo "<h2>Você está na conta ". $_SESSION['usuario']; echo "</h2>";
        } else {
            echo "<h2>Você não está conectado em uma conta.</h2>";
        }
    ?>
</header>
<nav id="menu">
    <a id="op1" href="sobre.php"> Sobre nós </a>
    <a id="op2" href="reservas.php"> Ver reservas</a>
    <a id="op3" href="user.php"> Reservar Horário </a>
</nav>
<div class = "txt">
    <h3>Acesse sua conta, ou registre caso não possua uma.</h3>
</div>
<main>
    <section id = "agendamento">
            <h2>Realizar Login</h2>
            <form id="form-agendamento" action="../methods/realizarLogin.php" method="POST">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <button type="submit">Login</button>
            </form> <br><br>

            <h2>Registrar Conta</h2>
            <form id="form-agendamento" action="../methods/registrarConta.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="novoUsuario">Usuário:</label>
                <input type="text" id="novoUsuario" name="novoUsuario" required>

                <label for="novaSenha">Senha:</label>
                <input type="password" id="novaSenha" name="novaSenha" required>
                
                <button type="submit">Registrar</button>
            </form>
    </section>
    </main>
</body>
</html>