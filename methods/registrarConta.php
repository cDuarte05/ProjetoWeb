<?php
    include "conection.php";
    $novoUsuario = $_POST['novoUsuario'];
    $novoNome = $_POST['nome'];
    $novaSenha = $_POST['novaSenha'];
    $sql_query = "INSERT INTO usuario VALUES ('$novoUsuario','$novoNome','$novaSenha');";
    mysqli_query($conection, $sql_query);
    echo "Usuario criado com sucesso";
    mysqli_close($conection);
    echo "<br><a href='../pages/login.php'>Voltar</a>"
?>