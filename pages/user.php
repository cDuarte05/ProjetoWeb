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
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?>!</h1>
        <h2>Você está na conta <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
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

            // Consultar horários disponíveis
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
                )
            ";
            $result_disponibilidade = $conection->query($query_disponibilidade);
            $horarios_disponiveis = $result_disponibilidade->fetch_all(MYSQLI_ASSOC);
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
