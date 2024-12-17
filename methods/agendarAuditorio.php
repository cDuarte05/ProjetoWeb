<?php
session_start();
include "../methods/conection.php";

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php"); // Redireciona para a página de login se o usuário não estiver logado
    exit;
}

// Verificar a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_agendamento = $_POST['data'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fim = $_POST['horario_fim'];
    $usuario_id = $_SESSION['usuario']; // Usando o usuário logado

    // Verificar a disponibilidade do horário
    $query_check_disponibilidade = "
        SELECT COUNT(*) as count 
        FROM disponibilidade 
        WHERE data = ? 
          AND horario_inicio = ? 
          AND horario_fim = ? 
          AND status = 'livre'
    ";
    $stmt_check_disponibilidade = $conection->prepare($query_check_disponibilidade);
    $stmt_check_disponibilidade->bind_param('sss', $data_agendamento, $horario_inicio, $horario_fim);
    $stmt_check_disponibilidade->execute();
    $result_check_disponibilidade = $stmt_check_disponibilidade->get_result();
    $row_check_disponibilidade = $result_check_disponibilidade->fetch_assoc();

    if ($row_check_disponibilidade['count'] > 0) {
        // Inserir no agendamentos se o horário estiver disponível
        $query_insert_agendamento = "
            INSERT INTO agendamentos (usuario_id, data_agendamento, horario_inicio, horario_fim, status)
            VALUES (?, ?, ?, ?, 'pendente')
        ";
        $stmt_insert_agendamento = $conection->prepare($query_insert_agendamento);
        $stmt_insert_agendamento->bind_param('ssss', $usuario_id, $data_agendamento, $horario_inicio, $horario_fim);
        $stmt_insert_agendamento->execute();

        if ($stmt_insert_agendamento->affected_rows > 0) {
            echo "Agendamento realizado com sucesso!";
        } else {
            echo "Erro ao realizar agendamento.";
        }
    } else {
        echo "Horário não disponível.";
    }

    // Fechar a conexão
    if ($stmt_check_disponibilidade) {
        $stmt_check_disponibilidade->close();
    }
    if ($stmt_insert_agendamento) {
        $stmt_insert_agendamento->close();
    }
    $conection->close();
} else {
    echo "Requisição inválida.";
}
?>
