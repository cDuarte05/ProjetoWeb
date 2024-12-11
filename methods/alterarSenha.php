<?php
    include("conection.php");
    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo "<head>";
        echo "    <meta http-equiv = 'refresh' content = '3; url = ../pages/login.php'/>;";
        echo "</head>";
        echo "Você não possue nenhuma conta conectada <br>";
    } else {
        $novaSenha = $_POST['novaSenha'];
        $usuario = $_SESSION['usuario'];
        $senha = $_SESSION['senha'];
        $sql_query = "UPDATE usuario SET senha = '$novaSenha' WHERE nomeUsuario = '$usuario' AND senha = '$senha' ";
        echo "<head>";
        echo "    <meta http-equiv = 'refresh' content = '3; url = ../pages/login.php'/>;";
        echo "</head>";
        try {
            mysqli_query($conection, $sql_query);
            echo "Senha atualizada<br>"; 
        } catch (mysqli_sql_exception $e) {
            echo "<br>Erro ao tentar atualizar a senha: ". $e->getMessage();
        }
    }
?>