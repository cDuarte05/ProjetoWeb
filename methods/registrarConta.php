<?php
    include "conection.php";
    $novoUsuario = $_POST['novoUsuario'];
    $novoNome = $_POST['nome'];
    $novaSenha = $_POST['novaSenha'];
    $novoUsuario = strtolower($novoUsuario);
    $sql_query = "SELECT * FROM usuario WHERE nomeUsuario = '$novoUsuario';"; 
    try {
        $check = mysqli_query($conection, $sql_query);
    } catch (mysqli_sql_exception $e) {
        echo "Erro ao tentar realizar registro: ".$e->getMessage(); 
    }
    if (mysqli_num_rows($check) == 0 || $novoUsuario != 'admin') {
        $sql_query = "INSERT INTO usuario VALUES ('$novoUsuario','$novoNome','$novaSenha');";
        mysqli_query($conection, $sql_query);
        echo "Usuario criado com sucesso";
        mysqli_close($conection);
        echo "<br><a href='../pages/login.php'>Voltar</a>";
    } else {
        echo "Nome de usuario já existente. <br> Tente novamente com outro nome, ou tente realizar login o com o nome existente.";
        mysqli_close($conection);
        echo "<br><a href='../pages/login.php'>Voltar</a>";
    }

// TODO: esturdar sobre o estado não case sensitive do phpMyAdmin por causa do jeito que ele vai tratar senhas (letras minusculas e maiusculas são vistas igualmente)
?>