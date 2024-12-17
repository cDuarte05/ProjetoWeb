<?php
session_start();
include "../methods/conection.php";

// Verificação de permissão
if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"] != "admin") {
    echo "<script>alert('Acesso negado! Redirecionando para o login.');</script>";
    header("Refresh: 3; url=login.php");
    exit();
}

// Cadastro de disponibilidade
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar_disponibilidade'])) {
    $data = $_POST['data_disponivel'];
    $horarioInicio = $_POST['horario_inicio'];
    $horarioFim = $_POST['horario_fim'];

    $SQL = "INSERT INTO disponibilidade (data, horario_inicio, horario_fim, status) VALUES ('$data', '$horarioInicio', '$horarioFim', 'livre')";
    $resultado = mysqli_query($conection, $SQL);

    if ($resultado) {
        echo "<script>alert('Disponibilidade cadastrada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar disponibilidade: " . mysqli_error($conection) . "');</script>";
    }
}

// Consulta de disponibilidade
$filtro = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filtrar_disponibilidade'])) {
    $dataFiltro = $_POST['data_filtro'];
    if (!empty($dataFiltro)) {
        $filtro = "WHERE data = '$dataFiltro'";
    }
}

// Deletar horário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deletar_horario'])) {
    $id = $_POST['id_disponibilidade'];

    // Verificar se há agendamentos relacionados ao horário
    $sqlVerificarAgendamentos = "SELECT COUNT(*) AS total FROM agendamentos WHERE id_disponibilidade = '$id'";
    $resultadoVerificacao = mysqli_query($conection, $sqlVerificarAgendamentos);
    $dados = mysqli_fetch_assoc($resultadoVerificacao);

    if ($dados['total'] > 0) {
        echo "<script>alert('Não é possível deletar. Existem agendamentos associados a este horário.');</script>";
    } else {
        $SQL = "DELETE FROM disponibilidade WHERE id = '$id'";
        $resultado = mysqli_query($conection, $SQL);

        if ($resultado) {
            echo "<script>alert('Horário excluído com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao excluir horário: " . mysqli_error($conection) . "');</script>";
        }
    }
}

// Alterar horário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['alterar_horario'])) {
    $id = $_POST['id_disponibilidade'];
    $novaData = $_POST['nova_data'];
    $novoInicio = $_POST['novo_inicio'];
    $novoFim = $_POST['novo_fim'];

    // Verificar se há agendamentos relacionados ao horário
    $sqlVerificarAgendamentos = "SELECT COUNT(*) AS total FROM agendamentos WHERE id_disponibilidade = '$id'";
    $resultadoVerificacao = mysqli_query($conection, $sqlVerificarAgendamentos);
    $dados = mysqli_fetch_assoc($resultadoVerificacao);

    if ($dados['total'] > 0) {
        echo "<script>alert('Não é possível alterar. Existem agendamentos associados a este horário.');</script>";
    } else {
        $SQL = "UPDATE disponibilidade SET data = '$novaData', horario_inicio = '$novoInicio', horario_fim = '$novoFim' WHERE id = '$id'";
        $resultado = mysqli_query($conection, $SQL);

        if ($resultado) {
            echo "<script>alert('Horário alterado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao alterar horário: " . mysqli_error($conection) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Gerenciar Auditório</title>
</head>
<body>
<header>
    <h1>Gerenciamento do Auditório</h1>
    <h2>Bem-vindo, Administrador</h2>
    <form class='login' action='../methods/realizarLogout.php'>
        <input class='login' type='submit' value='Sair'>
    </form>
</header>

<nav id="menu">
    <a id="op1" href="index.html"> Sobre nós </a>
    <a id="op2" href="reservas.php"> Ver reservas</a>
    <a id="op3" href="user.php"> Reservar Horário </a>
    <?php if (isset($_SESSION['usuario'])) {
            if($_SESSION['usuario'] == "admin") {echo " <a id='op3' href='gerenciamentoHorario.php'> Cadastrar espaço </a>";}
        }?>
</nav>

<main>
    <!-- Cadastro de disponibilidade -->
    <section>
        <h2>Cadastrar Disponibilidade do Auditório</h2>
        <form action="" method="POST">
            <label for="data_disponivel">Data:</label>
            <input type="date" id="data_disponivel" name="data_disponivel" required>

            <label for="horario_inicio">Horário de Início:</label>
            <input type="time" id="horario_inicio" name="horario_inicio" required>

            <label for="horario_fim">Horário de Fim:</label>
            <input type="time" id="horario_fim" name="horario_fim" required>

            <button type="submit" name="cadastrar_disponibilidade">Cadastrar</button>
        </form>
    </section>

    <!-- Consulta de disponibilidade -->
    <section>
        <h2>Consultar Disponibilidade do Auditório</h2>
        <form action="" method="POST">
            <label for="data_filtro">Filtrar por Data:</label>
            <input type="date" id="data_filtro" name="data_filtro">

            <button type="submit" name="filtrar_disponibilidade">Consultar</button>
        </form>

        <h3>Horários Disponíveis:</h3>
        <table border="1">
            <tr>
                <th>Data</th>
                <th>Horário de Início</th>
                <th>Horário de Fim</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php
                $sql = "SELECT * FROM disponibilidade $filtro ORDER BY data, horario_inicio";
                $resultado = mysqli_query($conection, $sql);

                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$row['data']}</td>
                            <td>{$row['horario_inicio']}</td>
                            <td>{$row['horario_fim']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id_disponibilidade' value='{$row['id']}'>
                                    <button type='submit' name='deletar_horario'>Deletar</button><br>
                                </form>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id_disponibilidade' value='{$row['id']}'>
                                    <input type='date' name='nova_data' required>
                                    <input type='time' name='novo_inicio' required>
                                    <input type='time' name='novo_fim' required>
                                    <button type='submit' name='alterar_horario'>Alterar</button>
                                </form>
                            </td>
                          </tr>";
                }
            ?>
        </table>
    </section>
</main>

<footer>
    <p>&copy; 2024 ONG Natureza Viva</p>
</footer>
</body>
</html>
<?php
mysqli_close($conection);
?>
