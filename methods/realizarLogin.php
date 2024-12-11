<?php
    include "conection.php";
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $usuario = strtolower($usuario);
    $sql_query = "SELECT * FROM usuario WHERE nomeusuario = '$usuario' AND senha = '$senha'";
    try {
        $login = mysqli_query($conection, $sql_query);
    } catch (mysqli_sql_exception $e) {
        echo "Falha ao tentar se comunicar com o banco: ". $e->getMessage();
        echo "<br><a href='../pages/login.php'>Voltar</a><br>";
    }
    if (mysqli_num_rows($login) == 0) {
        echo "Usuário ou senha incorretos.";
        echo "<br><a href='../pages/login.php'>Voltar</a><br>";
    } else {
        session_start();
        $conta = mysqli_fetch_row($login);
        $_SESSION['usuario'] = $conta[0];
        $_SESSION['nome'] = $conta[1];
        $_SESSION['senha'] = $conta[2];
        if ($conta[0] == 'admin') {
            if ($conta[2] == '123456') {
                echo "Como primeiro acesso de administrador, por favor, altere a senha: <br>"
                ?>
                    <form action="alterarSenha.php" method="POST">
                        <input style="width: 200px;" required name="novaSenha" type="password" placeholder="Insíra a nova senha de admin">
                        <input type="submit" value="Alterar">
                    </form>
                <?php
            } else {
                echo "<head>";
                echo "    <meta http-equiv = 'refresh' content = '4; url = ../pages/login.php'/>";
                echo "</head>";
                echo $_SESSION['usuario']; echo "<br>";
                echo $_SESSION['nome']; echo "<br>";
                echo $_SESSION['senha']; echo "<br>";
                echo "Bem vindo Administrador, redirecionando para tela de login";
            }
        } else {
            echo "<head>";
            echo "    <meta http-equiv = 'refresh' content = '4; url = ../pages/login.php'/>";
            echo "</head>";
            echo $_SESSION['usuario']; echo "<br>";
            echo $_SESSION['nome']; echo "<br>";
            echo $_SESSION['senha']; echo "<br>";
            echo "Redirecionando a tela de login. <br> Essa tela só existe para motivos de teste e desenvolvimento.";   
        }
    }
?>