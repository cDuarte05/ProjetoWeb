<?php
    include "conexao.php";
    $novoUsuario = $_POST['novoUsuario'];
    $novaSenha = $_POST['novaSenha'];
    $sql_query = "INSERT INTO usuario VALUES (NULL, '$novoUsuario',$novaSenha);";
    mysqli_query($conexao, $sql_query);
    echo "Usuario criado com sucesso";
    mysqli_close($conexao);
    echo "<br><a href='../index.html'>Voltar</a>"
?>