<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Registro de Ocorrência</title>
</head>
<?php
session_start();
include("../methods/conection.php");

if (isset($_POST['ocorrencia_'])) {
    $ocorrencia = $_POST['ocorrencia_'];
    $id_Agendamento = $_POST['idAgendamentoOc'];
    $sql = "UPDATE agendamentos SET status ='aberto_com_ocorrencia', avaliacao = '$ocorrencia' WHERE id = $id_Agendamento;";
    $result = mysqli_query($conection, $sql);
    ?>
        <div class="popup">
            <p class="popup">Ocorrência registrada com sucesso</p>
            <a class="popup" href='reservas.php'>Voltar</a>
        </div>
    <?php
}

if (isset($_POST['avaliacao'])) {
    $avaliacao = $_POST['avaliacao'];
    $id_Agendamento = $_POST['idAgendamentoAv'];
    $sql = "UPDATE agendamentos SET status ='Finalizado', avaliacao = '$avaliacao' WHERE id = $id_Agendamento;";
    $result = mysqli_query($conection, $sql);
    ?>
        <div class="popup">
            <p class="popup">Avaliacao registrada com sucesso</p>
            <a class="popup" href='reservas.php'>Voltar</a>
        </div>
    <?php
}

if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario'] == 'admin') {
        if (isset($_POST['ocorrencia'])) {
            $idAgendamento = $_POST['ocorrencia'];
            ?>
            <div class="popup">
                <p class="popup">Insira abaixo avaliação sobre a ocorrência:</p>
                <form method="POST">
                    <input type="hidden" name="idAgendamentoOc" value="<?php echo"$idAgendamento"; ?>">
                    <textarea style="height: 180px" name="ocorrencia_" placeholder="Insira aqui a avaliação sobre a ocorrência"></textarea>
                    <button type="submit">Marcar Ocorrência</button>
                </form>
                <a class="popup" href='reservas.php'>Cancelar Ocorrência</a>
            </div>
        <?php
        }
    } else {
        header('Location: index.html');
    }
} else {
    header('Location: index.html');
}

if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario'] == 'admin') {
        if (isset($_POST['finalizar'])) {
            $idAgendamento = $_POST['finalizar'];
            ?>
            <div class="popup">
                <p class="popup">Insira abaixo avaliação sobre a Agendamento:</p>
                <form method="POST">
                    <input type="hidden" name="idAgendamentoAv" value="<?php echo"$idAgendamento"; ?>">
                    <textarea style="height: 180px" name="avaliacao" placeholder="Insira aqui a avaliação sobre o agendamento:"></textarea>
                    <button type="submit">Marcar Avaliacao</button>
                </form>
                <a class="popup" href='reservas.php'>Cancelar Avaliacao</a>
            </div>
        <?php
        }
    } else {
        header('Location: index.html');
    }
} else {
    header('Location: index.html');
}


?>