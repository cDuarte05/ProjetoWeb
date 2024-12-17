<head>
    <meta http-equiv = 'refresh' content = '3; url = ../pages/login.php'>
    <link rel='stylesheet' href='../style.css'>
</head>
<?php
    session_start();
    if (isset ($_SESSION['usuario'])) {
        $user = $_SESSION['usuario'];
       ?>
        <div class="popup">
            <b><p class="popup">Até mais <?php echo"$user" ?>, redirecionando</p></b>
        </div>
       <?php
    } else {
        ?>
        <div class="popup">
            <b><p class="popup">Você não está em uma conta, redirecionando</p></b>
        </div>
       <?php
    }
    session_destroy();
?>
