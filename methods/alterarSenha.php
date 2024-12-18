<?php
    include("conection.php");
    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo"<script>alert('Por favor, acesse uma conta para ter acesso à essa página')</script>";
        header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver logado
        exit;
    } else {
        $novaSenha = $_POST['novaSenha'];
        $usuario = $_SESSION['usuario'];
        $senha = $_SESSION['senha'];
        $sql_query = "UPDATE usuario SET senha = '$novaSenha' WHERE nomeUsuario = '$usuario' AND senha = '$senha' ";
        echo "<head>";
        echo "    <meta http-equiv = 'refresh' content = '3; url = ../pages/login.php'/>";
        echo "    <link rel='stylesheet' href='../style.css'>";
        echo "</head>";
        try {
            mysqli_query($conection, $sql_query);
            echo "<div class='popup'><p class='popup'>Senha atualizada</p></div>"; 
        } catch (mysqli_sql_exception $e) {
            echo "<div class='popup'><p class='popup'>Erro ao tentar atualizar a senha: {$e->getMessage()}</p></div>"; 

        }
    }
?>