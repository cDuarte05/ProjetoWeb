<?php
    include "conexao.php";
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $sql_query = "SELECT * FROM usuario WHERE nome = '$usuario' AND senha = $senha";
    $login = mysqli_query($conexao, $sql_query);
    if (mysqli_num_rows($login) == 0) {
        echo "Falha de Login";
        echo "<br><a href='../index.html'>Voltar</a><br>";
    } else {
        $conta = mysqli_fetch_row($login);
        echo "Id = $conta[0]<br>";
        echo "Nome = $conta[1]<br>";
        echo "Senha = $conta[2]<br>";
        echo "<br><a href='../index.html'>Voltar</a><br>";
    }
?>