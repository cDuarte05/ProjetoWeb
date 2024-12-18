<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Agendamento Auditório</title>
</head>
<?php
session_start();
include "../methods/conection.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agendar'])) {
    $data = $_POST['data'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fim = $_POST['horario_fim'];
    $usuario_id = $_SESSION['usuario'];

    $query_check_disponibilidade = "
    SELECT id 
    FROM disponibilidade 
    WHERE data = ?
      AND horario_inicio = ?
      AND horario_fim = ? 
      AND status = 'livre'
    ";

    $stmt_check_disponibilidade = $conection->prepare($query_check_disponibilidade);
    $stmt_check_disponibilidade->bind_param('sss', $data, $horario_inicio, $horario_fim);
    $stmt_check_disponibilidade->execute();
    $result_check_disponibilidade = $stmt_check_disponibilidade->get_result();  
    $row_check_disponibilidade = $result_check_disponibilidade->fetch_assoc();
 
if ($row_check_disponibilidade) {
    $query_agendamentos = "
        SELECT id, data_agendamento, horario_inicio, horario_fim, status 
        FROM agendamentos 
        WHERE usuario_id = ?
        AND status = 'pendente'
    ";
    $stmt_agendamentos = $conection->prepare($query_agendamentos);
    $stmt_agendamentos->bind_param('s', $usuario_id);
    $stmt_agendamentos->execute();
    $result_agendamentos = $stmt_agendamentos->get_result();
    $agendamentos = $result_agendamentos->fetch_all(MYSQLI_ASSOC);
    if (count($agendamentos) > 0) {
        ?>
            <div class="popup">
                <p class="popup">Você já possuí um agendamneto pendente.</p>
                <a class="popup" href='../pages/user.php'>Voltar</a>
            </div>
        <?php
    } else {
        $id_disponibilidade = $row_check_disponibilidade['id'];
        // Inserir no agendamentos usando o id_disponibilidade
        $query_insert_agendamento = "
            INSERT INTO agendamentos (usuario_id, id_disponibilidade, data_agendamento, horario_inicio, horario_fim, status)
            VALUES (?, ?, ?, ?, ?, 'pendente')
        ";
        $stmt_insert_agendamento = $conection->prepare($query_insert_agendamento);
        $stmt_insert_agendamento->bind_param('sisss', $usuario_id, $id_disponibilidade, $data, $horario_inicio, $horario_fim);
        $stmt_insert_agendamento->execute();
        if ($stmt_insert_agendamento->affected_rows > 0) {
            header('Location: ../pages/user.php');
        } else {
            ?>
                <div class="popup">
                    <p class="popup">Erro ao realizar agendamento</p>
                    <a class="popup" href='../pages/user.php'>Voltar</a>
                </div>
            <?php
        }
    }
    
} else {
    ?>
        <div class="popup">
            <p class="popup">Horário não disponível ou inválido</p>
            <a class="popup" href='../pages/user.php'>Voltar</a>
        </div>
    <?php
}
}
?>
