<?php
    session_start();
    if (isset ($_SESSION['usuario'])) {
        echo "Até mais ". $_SESSION['nome'];
    } else {
        echo "<br>Você não está em uma conta.";
    }
    session_destroy();
?>
<head>
    <meta http-equiv = 'refresh' content = '3; url = ../pages/login.php'>
</head>