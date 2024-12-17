<?php session_start(); ?>
<head> <!-- Por enquanto essas três linhas aqui só te jogam de volta pra outra tela -->
    <meta http-equiv = 'refresh' content = '1; url = user.php'/>
</head>
<?php echo "só pra não apontar hack";
    if (isset($_SESSION['usuario'])) {
        if ($_SESSION['usuario'] == 'admin') {
            ?>
                <body>
                    <p>Você é administrador</p>
                </body>
            <?php
        } else {
            ?>
                <body>
                    <p>Você é um usuário normal</p>
                </body>
            <?php
        }
    } else {
        ?>
            <body>
                <p>Você não está em nenhuma conta</p>
            </body>
        <?php
    }
?>