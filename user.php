<!--tela usuario comum-->
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <h1>Bem vindo usuario</h1> <!-- penso em pegar o nome dele -->
</header>
<nav id="menu">
            <a id="op1" href="sobre.php"> Sobre nós </a>
            <a id="op2" href="reservas.php"> Ver reservas</a>
            <a id="op3" href="user.php"> Reservar Horário </a>
            <a id="op5" href="material.html">Login/Logof</a>
        </nav>

<div class = "txt">
    <h3>Seja bem vindo ao local de reserva do nosso auditorio</h3>
    <p>Somos a ONG Natureza Viva</p>
    <p></p>
</div>
    <main>
        <section id = "agendamento">
            <h2>Solicitar Agendamento</h2>
            <form id="form-agendamento">
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

<?php echo "só pra não apontar hack"?>