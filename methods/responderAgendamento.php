<?php
include("conection.php");
session_start();
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario'] == 'admin'){
        if (isset($_POST['aceitar'])) {
            $idAgendamento = $_POST['aceitar'];
            $sql = "UPDATE agendamentos SET status = 'confirmado' WHERE id = $idAgendamento;";
            try {
                $result = mysqli_query($conection, $sql);
                $sql = "SELECT id_disponibilidade FROM agendamentos WHERE id = $idAgendamento;";
                $result = mysqli_query($conection, $sql);
                $row = mysqli_fetch_assoc($result);
                $idDisponibilidade = $row['id_disponibilidade'];
                $sql = "UPDATE disponibilidade SET status = 'reservado' WHERE id = $idDisponibilidade";
                $result = mysqli_query($conection, $sql);
                header('Location: ../pages/reservas.php');
            }
            catch (mysqli_sql_exception $e) {
                echo "Exception: ". $e->getMessage();
                echo "<br>".$sql;
            }
            
        }
        if (isset($_POST['rejeitar'])) {
            $idAgendamento = $_POST['rejeitar'];
            $sql = "UPDATE agendamentos SET status = 'finalizado' WHERE id = $idAgendamento;";
            try {
                $result = mysqli_query($conection, $sql);
                header('Location: ../pages/reservas.php');
            }
            catch (mysqli_sql_exception $e) {
                echo "Exception: ". $e->getMessage();
                echo "<br>".$sql;
            }
        }
    } else {
        header('Location: ../pages/reservas.php');
        exit;
    }
} else {
    header('Location: ../pages/login.php');
    exit;
}

?>