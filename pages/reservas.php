<?php session_start(); ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Reservas</title>
</head>
<?php
    if (isset($_SESSION['usuario'])) {
        if ($_SESSION['usuario'] == 'admin') {
            ?>
                <header>
                <?php
                    if (isset ($_SESSION['usuario'])) {
                        echo "<h1>Bem Vindo ". $_SESSION['nome']; echo "</h1>";
                        echo 
                        "
                            <form class = 'login' action='../methods/realizarLogout.php'>
                                <input class = 'login' type='submit' value='Sair'>
                            </form>       
                        ";
                    } else {
                        ?>
                            <div class='header_title'>
                                <h1>Bem Vindo</h1>  
                                <a class='login' href='login.php'>Login/Registro</a>
                            </div>
                        <?php
                    }
                ?>  
                </header>
                <nav id="menu">
                        <a id="op1" href="index.html"> Sobre nós </a>
                        <a id="op2" href="reservas.php"> Ver reservas</a>
                        <a id="op3" href="user.php"> Reservar Horário </a>
                        <?php if (isset($_SESSION['usuario'])) {
                                if($_SESSION['usuario'] == "admin") {echo " <a id='op3' href='gerenciamentoHorario.php'> Cadastrar horarios </a>";}
                        }?>
                </nav>
                <div class = "txt">
                    <h3>Seja bem vindo ao histórico de reservas da ONG Natureza Viva.</h3>
                </div>
            <?php
        } else {
            ?>
                <header>
                <?php
                    if (isset ($_SESSION['usuario'])) {
                        echo "<h1>Bem Vindo ". $_SESSION['nome']; echo "</h1>";
                        echo 
                        "
                            <form class = 'login' action='../methods/realizarLogout.php'>
                                <input class = 'login' type='submit' value='Sair'>
                            </form>       
                        ";
                    } else {
                        ?>
                            <div class='header_title'>
                                <h1>Bem Vindo</h1>  
                                <a class='login' href='login.php'>Login/Registro</a>
                            </div>
                        <?php
                    }
                ?>  
                </header>
                <nav id="menu">
                        <a id="op1" href="index.html"> Sobre nós </a>
                        <a id="op2" href="reservas.php"> Ver reservas</a>
                        <a id="op3" href="user.php"> Reservar Horário </a>
                        <?php if (isset($_SESSION['usuario'])) {
                                if($_SESSION['usuario'] == "admin") {echo " <a id='op3' href='registroEspacos.php'> Registrar espaço </a>";}
                        }?>
                </nav>
                <div class = "txt">
                    <h3>Seja bem vindo ao seu histórico de Reservas</h3>
                </div>
            <?php
        }
    } else {
        ?>
            <header>
            <?php
                if (isset ($_SESSION['usuario'])) {
                    echo "<h1>Bem Vindo ". $_SESSION['nome']; echo "</h1>";
                    echo 
                    "
                        <form class = 'login' action='../methods/realizarLogout.php'>
                            <input class = 'login' type='submit' value='Sair'>
                        </form>       
                    ";
                } else {
                    ?>
                        <div class='header_title'>
                            <h1>Bem Vindo</h1>  
                            <a class='login' href='login.php'>Login/Registro</a>
                        </div>
                    <?php
                }
            ?>  
            </header>
            <nav id="menu">
                    <a id="op1" href="index.html"> Sobre nós </a>
                    <a id="op2" href="reservas.php"> Ver reservas</a>
                    <a id="op3" href="user.php"> Reservar Horário </a>
                    <?php if (isset($_SESSION['usuario'])) {
                            if($_SESSION['usuario'] == "admin") {echo " <a id='op3' href='registroEspacos.php'> Registrar espaço </a>";}
                    }?>
            </nav>
            <div class = "txt">
                <h3>Seja bem vindo ao seu histórico de reservas.</h3>
            </div>
            <body>
                <main>
                    <section id="descricao">
                        <h2>Para ter acesso</h2>
                        <p>
                            Para fazer uso das funcionalidades presentes nessa página, por favor:
                        </p>
                    </section>

                    <section id="cta">
                        <h2>Acesse Agora</h2>
                        <p>
                            Faça o login ou cadastre-se para reservar os espaços e contribuir com a nossa causa.
                        </p>
                        <a href="login.php" class="botao">Acessar Sistema</a>
                    </section>
                </main>
            </body>
        <?php
    }
?>

