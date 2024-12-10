<?php
    include "conection.php";
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $sql_query = "SELECT * FROM usuario WHERE nomeusuario = '$usuario' AND senha = $senha";
    $login = mysqli_query($conection, $sql_query);
    if (mysqli_num_rows($login) == 0) {
        echo "Falha de Login";
        echo "<br><a href='../pages/login.php'>Voltar</a><br>";
    } else {
        $conta = mysqli_fetch_row($login);
?>
        <head>
            <meta http-equiv = 'refresh' content = '4; url = ../pages/login.php'/>
        </head>
        <body>
<?php
        session_start();
        $_SESSION['usuario'] = $conta[0];
        $_SESSION['nome'] = $conta[1];
        $_SESSION['senha'] = $conta[2];
        echo $_SESSION['usuario']; echo "<br>";
        echo $_SESSION['nome']; echo "<br>";
        echo $_SESSION['senha']; echo "<br>";
        echo "Redirecionando á página princiapl. <br> Essa tela só existe para motivos de teste e desenvolvimento.";   
?>
        </body>
<?php
    }
?>