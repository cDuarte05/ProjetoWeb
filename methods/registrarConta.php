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
        echo "Erro ao tentar comunicao com o banco: ".$e->getMessage(); 
    }
    if (mysqli_num_rows($check) == 0 && $novoUsuario != 'admin') {
        $sql_query = "INSERT INTO usuario VALUES ('$novoUsuario','$novoNome','$novaSenha');";
        mysqli_query($conection, $sql_query);
        ?>
            <div class="popup">
                <b><p class="popup">Usuário cirado com sucesso!</p></b>
                <a class="popup" href='../pages/login.php'>Voltar</a>
            </div>
        <?php
        mysqli_close($conection);
    } else {
        ?>
            <div class="popup">
                <b><p class="popup">Nome de usuário já existente. <br> Tente Novamente com outro nome, ou tente
                realizar login com o nome existente.</p></b>
                <a class="popup" href='../pages/login.php'>Voltar</a>
            </div>
        <?php
        mysqli_close($conection);
    }

// TODO: esturdar sobre o estado não case sensitive do phpMyAdmin por causa do jeito que ele vai tratar senhas (letras minusculas e maiusculas são vistas igualmente)
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Login/Logout</title>
</head>