<?php
    include "conection.php";
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $usuario = strtolower($usuario);
    $sql_query = "SELECT * FROM usuario WHERE nomeusuario = '$usuario' AND senha = '$senha'";
    ?>
        <head>
            <link rel='stylesheet' href='../style.css'>
        </head>
    <?php
    try {
        $login = mysqli_query($conection, $sql_query);
    } catch (mysqli_sql_exception $e) {
        ?>
            <div class="popup">
                <b><p class="popup">Erro ao comunicar com o banco: <?php echo "".$e->getMessage() ?></p></b>
                <a class="popup" href='../pages/login.php'>Voltar</a>
            </div>
        <?php
    }
    if (mysqli_num_rows($login) == 0) {
        ?>
            <div class="popup">
                <b><p class="popup">Usuário ou senha incorretos</p></b>
                <a class="popup" href='../pages/login.php'>Voltar</a>
            </div>
        <?php
    } else {
        session_start();
        $conta = mysqli_fetch_row($login);
        $_SESSION['usuario'] = $conta[0];
        $_SESSION['nome'] = $conta[1];
        $_SESSION['senha'] = $conta[2];
        if ($conta[0] == 'admin') {
            if ($conta[2] == '123456') {
                ?>
                    <div class="popup">
                        <p>Como primeiro acesso de administrador, por favor, altere a senha: <br></p>
                        <form action="alterarSenha.php" method="POST">
                            <input style="width: 200px;" required name="novaSenha" type="password" placeholder="Insíra a nova senha de admin">
                            <input type="submit" value="Alterar">
                        </form>
                    </div>
                <?php
            } else {
                echo "<head>";
                echo "    <meta http-equiv = 'refresh' content = '2; url = ../pages/login.php'/>";
                echo "    <link rel='stylesheet' href='../style.css'>";
                echo "</head>";
                ?>
                    <div class="popup">
                        <b><p class="popup">Bem vindo <?php echo"{$_SESSION['usuario']}" ?>, redirecionando</p></b>
                    </div>
                <?php
            }
        } else {
            echo "<head>";
            echo "    <meta http-equiv = 'refresh' content = '2; url = ../pages/login.php'/>";
            echo "    <link rel='stylesheet' href='../style.css'>";
            echo "</head>";
            ?>
                <div class="popup">
                    <b><p class="popup">Olá <?php echo"{$_SESSION['usuario']}" ?>, redirecionando</p></b>
                </div>
            <?php
        }
    }
?>