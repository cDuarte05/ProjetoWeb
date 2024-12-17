<?php
    session_start();
?>

<!--tela usuario comum-->
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../style.css">
</head>
<header>
<?php
        if (isset ($_SESSION['usuario'])) {
            echo "<h1>Bem Vindo ". $_SESSION['nome']; echo "</h1>";
            echo 
            "
                <form class = 'login' action='../methods/realizarLogout.php'>
                    <input class = 'login' type='submit' value='Sair'>
                </form>       
            ";
        } else {
            ?>
                <div class='header_title'>
                    <h1>Bem Vindo</h1>  
                    <a class='login' href='login.php'>Login/Registro</a>
                </div>
            <?php
        }
    ?>  
    <!-- penso em pegar o nome dele -> esse trechinho aqui em cima vai fazer isso -->
</header>
<nav id="menu">
    <a id="op1" href="sobre.php"> Sobre nós </a>
    <a id="op2" href="reservas.php"> Ver reservas</a>
    <a id="op3" href="user.php"> Reservar Horário </a>
</nav>

<div class = "txt">
    <h3>Seja bem vindo ao local de reserva do nosso auditorio</h3>
    <p>Somos a ONG Natureza Viva</p>
</div>
    <main>
    <section id = "agendamento">
            <h2>Solicitar Agendamento</h2>
            <form id = "form-agendamento">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" required>
                <label for="horario">Horário:</label>
                <input type="time" id="horario" name="horario" required>
                <button type="submit">Solicitar</button>
            </form>
        </section>
        <section>
    </main>
</body>
</html>
