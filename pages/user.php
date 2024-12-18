<?php
session_start();
include "../methods/conection.php";

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    // echo"<script>alert('Por favor, acesse uma conta para ter acesso à essa página');</script>";
    // sleep(1);
    // header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver logado
    ?>
    <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../style.css">
            <title>Reservas</title>
        </head>
    <header>
    <img class="logo" src="../images/logomarca.png" alt="Logo da ONG, duas mãos em formato de concha segurando uma planta crescendo, em estilo de desenho simples.">
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
    </header>
    <nav id="menu">
            <a id="op1" href="index.html"> Sobre nós </a>
            <a id="op2" href="reservas.php"> Ver reservas</a>
            <a id="op3" href="user.php"> Reservar Horário </a>
            <?php if (isset($_SESSION['usuario'])) {
                    if($_SESSION['usuario'] == "admin") {echo " <a id='op3' href='registroEspacos.php'> Registrar espaço </a>";}
            }?>
    </nav>
    <div class = "txt">
        <h3>Espaço para agendamento do auditório.</h3>
    </div>
    <body>
        <main>
            <section id="descricao">
                <h2>Para ter acesso</h2>
                <p>
                    Para fazer uso das funcionalidades presentes nessa página, por favor:
                </p>
            </section>

            <section id="cta">
                <h2>Acesse Agora</h2>
                <p>
                    Faça o login ou cadastre-se para reservar os espaços e contribuir com a nossa causa.
                </p>
                <a href="login.php" class="botao">Acessar Sistema</a>
            </section>
        </main>
    </body>
<?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Agendamento Auditório</title>
</head>

<body>
    <header>
    <img class="logo" src="../images/logomarca.png" alt="Logo da ONG, duas mãos em formato de concha segurando uma planta crescendo, em estilo de desenho simples.">
        <h1>Bem Vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h1>
        <!-- <h2>Você está na conta <?php //htmlspecialchars($_SESSION['usuario']) ?></h2> -->
        <form class="login" action="../methods/realizarLogout.php" method="post">
            <input class="login" type="submit" value="Sair">
        </form>
    </header>

    <nav id="menu">
        <a id="op1" href="index.html">Sobre nós</a>
        <a id="op2" href="reservas.php">Ver reservas</a>
        <a id="op3" href="user.php">Reservar Horário</a>
        <?php if ($_SESSION['usuario'] == "admin"): ?>
            <a id="op4" href="gerenciamentoHorario.php">Cadastrar espaço</a>
        <?php endif; ?>
    </nav>

    <main>
        <section id="agendamento">
            <h2>Agendamento de Auditório</h2>

            <?php
            $usuario_id = $_SESSION['usuario'];
            $query_agendamentos = "
                SELECT id, data_agendamento, horario_inicio, horario_fim, status 
                FROM agendamentos 
                WHERE usuario_id = ?
            ";
            $stmt_agendamentos = $conection->prepare($query_agendamentos);
            $stmt_agendamentos->bind_param('s', $usuario_id);
            $stmt_agendamentos->execute();
            $result_agendamentos = $stmt_agendamentos->get_result();
            $agendamentos = $result_agendamentos->fetch_all(MYSQLI_ASSOC);

            if (count($agendamentos) > 0) {
                $temAgendamento = true;
                echo "<p>Você já tem agendamentos para o auditório:</p><ul>";
                foreach ($agendamentos as $agendamento) {
                    echo "<li>Data: " . htmlspecialchars($agendamento['data_agendamento']) . 
                         " - Horário: " . htmlspecialchars($agendamento['horario_inicio']) . 
                         " - " . htmlspecialchars($agendamento['horario_fim']) . 
                         " - Status: " . htmlspecialchars($agendamento['status']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Você não tem agendamentos para o auditório.</p>";
            }

            // Consultar horários disponíveis -> tá errado isso aqui, eu acho pelo menos, agendamento "pendente", mesmo não sendo aprovado, tira a disponibildiade de uma disponibildiade
            $query_disponibilidade = "
                SELECT data, horario_inicio, horario_fim 
                FROM disponibilidade 
                WHERE status = 'livre' 
                AND NOT EXISTS ( 
                    SELECT 1 
                    FROM agendamentos 
                    WHERE agendamentos.data_agendamento = disponibilidade.data
                      AND agendamentos.horario_inicio = disponibilidade.horario_inicio
                      AND agendamentos.horario_fim = disponibilidade.horario_fim
                      AND agendamentos.status = 'Confirmado'
                )
                ORDER BY data;
            ";
            $result_disponibilidade = $conection->query($query_disponibilidade);
            $horarios_disponiveis = $result_disponibilidade->fetch_all(MYSQLI_ASSOC);
            ?>

            <h2>Horários e Dias Disponíveis</h2>
            <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Dia</th>
                        <th>Horário Inicial</th>
                        <th>Horário Final</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios_disponiveis as $horario): ?>
                        <tr>
                            <td><?= htmlspecialchars($horario['data']) ?></td>
                            <td><?= htmlspecialchars($horario['horario_inicio']) ?></td>
                            <td><?= htmlspecialchars($horario['horario_fim']) ?></td>
                            <td>
                                <form method="POST" action="../methods/agendarAuditorio.php">
                                    <input name="data" type="hidden" value="<?= htmlspecialchars($horario['data']) ?>">
                                    <input name="horario_inicio" type="hidden" value="<?= htmlspecialchars($horario['horario_inicio']) ?>">
                                    <input name="horario_fim" type="hidden" value="<?= htmlspecialchars($horario['horario_fim']) ?>">
                                    <button type="submit" name="agendar" value="1">Agendar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
<!-- 
            <section>
                <form id="form-agendamento" action="../methods/agendarAuditorio.php" method="POST">
                    <label for="data">Data do Agendamento:</label>
                    <input type="date" id="data" name="data" required>

                    <label for="horario_inicio">Horário de Início:</label>
                    <input type="time" id="horario_inicio" name="horario_inicio" step="1"required>

                    <label for="horario_fim">Horário de Fim:</label>
                    <input type="time" id="horario_fim" name="horario_fim" step="1" required>

                    <button type="submit">Agendar</button>
                </form>
            </section> -->
        </section>
    </main>
</body>
</html>
