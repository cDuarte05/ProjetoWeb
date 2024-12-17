<?php
session_start();
include "../methods/conection.php";
if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"] != "admin") {
    header("Location: login.php");
    exit(); //adicionar um tempo e mensagem de alert
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['cadastrar_espaco'])){
    $espacoName = $_POST['nome_espaco'];
    $descricao = $_POST['descricao'];

    $SQL = "INSERT INTO espacos (nome, descricao) value ('$espacoName', '$descricao')";   
    $resultado = mysqli_query($conection,$SQL);
    if(mysqli_num_rows($resultado) > 0){
        echo "Operação realizada com sucesso !";
    }else{
        echo "ERRO, nenhuma linha alterada";
    }
}
    //consulta e preparação do filtro
$filtro = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filtrar_agendamentos'])) {
    $espacoSelecionado = $_POST['espaco'];
    $mesSelecionado = $_POST['mes'];

     $filtro = "WHERE 1=1";
    if ($espacoSelecionado != "") {
        $filtro .= " AND espaco_id = '$espacoSelecionado'";
    }
    if ($mesSelecionado != "") {
        $filtro .= " AND MONTH(data_agendamento) = '$mesSelecionado'";
    }
}
?>

<?php
    mysqli_close($conection);
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Gerenciar Espaços</title>
</head>
<body>
<header>
    <h1>Gerenciamento de Espaços</h1>
    <h2>Bem-vindo, Administrador</h2>
    <form class = 'login' action='../methods/realizarLogout.php'>
        <input class = 'login' type='submit' value='Sair'>
    </form>   
</header>

<nav id="menu">
    <a id="op1" href="index.html"> Sobre nós </a>
    <a href="reservas.php">Ver reservas</a>
<!-- no decorrer das funções, adicionar no menu-->
</nav>

<main>
    <!-- Formulário para cadastro de novos espaços -->
    <section>
        <h2>Cadastrar Novo Espaço</h2>
        <form action="" method="POST">
            <label for="nome_espaco">Nome do Espaço:</label>
            <input type="text" id="nome_espaco" name="nome_espaco" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3" required></textarea>

            <button type="submit" name="cadastrar_espaco">Cadastrar</button>
        </form>
    </section>

    <!-- Consulta de agendamentos -->
    <section>
        <h2>Consultar Agendamentos</h2>
        <form action="" method="POST">
            <label for="espaco">Filtrar por Espaço:</label>
            <select id="espaco" name="espaco">
                <option value="">Todos</option>
                <?php
                    $SQL = "SELECT id, nome from espacos";
                    $resultado = mysqli_query( $conection,$SQL); 
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                ?>
            </select>

            <label for="mes">Filtrar por Mês:</label>
            <select id="mes" name="mes">
                <option value="">Todos</option>
                <?php
                    for ($i = 1; $i <= 12; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                ?>
            </select>

            <button type="submit" name="filtrar_agendamentos">Consultar</button>
        </form>

        <h3>Resultados:</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Espaço</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Status</th>
            </tr>
            <?php
                $sql = "SELECT agendamentos.id, espacos.nome AS espaco, agendamentos.data, agendamentos.horario, agendamentos.status 
                        FROM agendamentos 
                        JOIN espacos ON agendamentos.espaco_id = espacos.id
                        $filtro"; //variavel definida la em cima
                $resultado = mysqli_query($conection, $sql);
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['espaco'] . "</td>
                            <td>" . $row['data'] . "</td>
                            <td>" . $row['horario'] . "</td>
                            <td>" . $row['status'] . "</td>
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

