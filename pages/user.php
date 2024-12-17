<?php
session_start();
include "../methods/conection.php";

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver logado
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
        <h1>Bem-vindo, <?= $_SESSION['nome'] ?>!</h1>
        <h2>Você está na conta <?= $_SESSION['usuario'] ?></h2>
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
            // Consultar agendamentos do auditório
            $usuario_id = $_SESSION['usuario']; // Converte para string diretamente
            $query_agendamentos = "SELECT id, data_agendamento, horario_inicio, horario_fim FROM agendamentos WHERE usuario_id = ?";
            $stmt_agendamentos = $conection->prepare($query_agendamentos);
            $stmt_agendamentos->bind_param('s', $usuario_id); // Bind de string
            $stmt_agendamentos->execute();
            $result_agendamentos = $stmt_agendamentos->get_result();
            $agendamentos = $result_agendamentos->fetch_all(MYSQLI_ASSOC);

            // Consultar horários disponíveis que não estão reservados
            $query_disponibilidade = "
            SELECT d.data, d.horario_inicio, d.horario_fim 
            FROM disponibilidade d
            WHERE d.status = 'livre' 
              AND NOT EXISTS (
                  SELECT 1 
                  FROM agendamentos a 
                  WHERE a.data_agendamento = d.data 
                    AND a.horario_inicio = d.horario_inicio
                    AND a.horario_fim = d.horario_fim
                    AND a.usuario_id = ?
              )
            ";
            $stmt_disponibilidade = $conection->prepare($query_disponibilidade);
            $stmt_disponibilidade->bind_param('s', $usuario_id); // Bind de string
            $stmt_disponibilidade->execute();
            $result_disponibilidade = $stmt_disponibilidade->get_result();
            $horarios_disponiveis = $result_disponibilidade->fetch_all(MYSQLI_ASSOC);

            if (count($agendamentos) > 0) {
                echo "<p>Você já tem agendamentos para o auditório:</p>";
                echo "<ul>";
                foreach ($agendamentos as $agendamento) {
                    echo "<li>Data: " . htmlspecialchars($agendamento['data_agendamento']) . " - Horário: " . htmlspecialchars($agendamento['horario_inicio']) . " - " . htmlspecialchars($agendamento['horario_fim']) . " - Status: " . htmlspecialchars($agendamento['status']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Você não tem agendamentos para o auditório.</p>";
            }
            ?>

            <h2>Horários e Dias Disponíveis</h2>
            <table>
                <thead>
                    <tr>
                        <th>Dia</th>
                        <th>Horário Inicial</th>
                        <th>Horário Final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios_disponiveis as $horario): ?>
                        <tr>
                            <td><?= htmlspecialchars($horario['data']) ?></td>
                            <td><?= htmlspecialchars($horario['horario_inicio']) ?></td>
                            <td><?= htmlspecialchars($horario['horario_fim']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <section>
                <form id="form-agendamento" action="../methods/agendarAuditorio.php" method="POST">
                    <label for="data">Data do Agendamento:</label>
                    <input type="date" id="data" name="data" required>

                    <label for="horario_inicio">Horário de Início:</label>
                    <input type="time" id="horario_inicio" name="horario_inicio" required>

                    <label for="horario_fim">Horário de Fim:</label>
                    <input type="time" id="horario_fim" name="horario_fim" required>

                    <button type="submit">Agendar</button>
                </form>
            </section>
        </section>
    </main>

</body>

</html>
