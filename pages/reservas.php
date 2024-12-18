<?php 
include ("../methods/conection.php");
session_start(); ?>
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
                <img class="logo" src="../images/logomarca.png" alt="Logo da ONG, duas mãos em formato de concha segurando uma planta crescendo, em estilo de desenho simples.">
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
                <body>
                    <main>
                        <h2>Agendamentos aguardando resposta:</h2>
                            <?php
                                $sql = "SELECT id, usuario_id, data_agendamento, horario_inicio, horario_fim, status 
                                FROM agendamentos WHERE status = 'pendente' OR 
                                status = 'aberto_com_ocorrencia';";
                                $result = mysqli_query($conection, $sql);
                                $total = mysqli_num_rows($result);
                                if ($total > 0) {
                                    ?>
                                        <div class="table">
                                        <table class="listaPendentes">
                                        <tr>
                                            <th>Pedido</th> 
                                            <th>Usuário</th> 
                                            <th>Data</th>
                                            <th>Horário Início</th>
                                            <th>Horário Fim</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    <?php
                                    for ($i = 0; $i < $total; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        echo "<tr><td>{$row['id']}</td>
                                        <td>{$row['usuario_id']}</td>
                                        <td>{$row['data_agendamento']}</td>
                                        <td>{$row['horario_inicio']}</td>
                                        <td>{$row['horario_fim']}</td>
                                        <td>{$row['status']}</td>
                                        <td>
                                        <form style='display:flex; flex-direction:row' method='POST' action='../methods/responderAgendamento.php'>
                                            <button type='submit' name='aceitar' value='{$row['id']}'>Aceitar</button>
                                            <button type='submit' name='rejeitar' value='{$row['id']}'>Rejeitar</button>
                                        </form>
                                        </td></tr>";    
                                    }
                                } else {
                                    echo "<p>Não existem agendamentos em aberto.</p>";
                                }
                            ?>
                        </table>
                        </div>
                        <h2>Agendamentos respondidos:</h2>
                            <?php
                                $sql = "SELECT id, usuario_id, data_agendamento, horario_inicio, horario_fim, status 
                                FROM agendamentos 
                                WHERE status = 'confirmado' OR
                                status = 'finalizado'";
                                $result = mysqli_query($conection, $sql);
                                $total = mysqli_num_rows($result);
                                if ($total > 0) {
                                    ?>
                                        <div class="table">
                                        <table class="listaRespondidas">
                                            <tr>
                                                <th>Pedido</th> 
                                                <th>Usuário</th> 
                                                <th>Data</th>
                                                <th>Horário Início</th>
                                                <th>Horário Fim</th>
                                                <th>Status</th>
                                            </tr>
                                    <?php
                                    for ($i = 0; $i < $total; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        echo "<tr><td>{$row['id']}</td>
                                        <td>{$row['usuario_id']}</td>
                                        <td>{$row['data_agendamento']}</td>
                                        <td>{$row['horario_inicio']}</td>
                                        <td>{$row['horario_fim']}</td>
                                        <td>{$row['status']}</td></tr>";
                                    }
                                } else {
                                    echo "<p>Não existem agendamentos respondidos.</p>";
                                }
                            ?>
                        </table>
                        </div>
                    </main>
                </body>
            <?php
        } else {
            ?>
                <header>
                <img class="logo" src="../images/logomarca.png" alt="Logo da ONG, duas mãos em formato de concha segurando uma planta crescendo, em estilo de desenho simples.">
                <?php
                    if (isset ($_SESSION['usuario'])) {
                        echo "<h1>Bem Vindo, ". $_SESSION['nome']; echo "</h1>";
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
                <body>
                    <main>
                            <?php
                                $sql = "SELECT id, usuario_id, data_agendamento, horario_inicio, horario_fim, status 
                                FROM agendamentos 
                                WHERE (status != 'confirmado' OR
                                status != 'finalizado') AND
                                usuario_id = '{$_SESSION['usuario']}'";
                                $result = mysqli_query($conection, $sql);
                                $total = mysqli_num_rows($result);
                                if ($total > 0) {
                                    ?>
                                    <div class="table">
                                    <table class="listaPendentes">
                                        <tr>
                                            <th>Pedido</th> 
                                            <th>Usuário</th> 
                                            <th>Data</th>
                                            <th>Horário Início</th>
                                            <th>Horário Fim</th>
                                            <th>Status</th>
                                        </tr>
                                    <?php
                                    for ($i = 0; $i < $total; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        echo "<tr><td>{$row['id']}</td>
                                        <td>{$row['usuario_id']}</td>
                                        <td>{$row['data_agendamento']}</td>
                                        <td>{$row['horario_inicio']}</td>
                                        <td>{$row['horario_fim']}</td>
                                        <td>{$row['status']}</td></tr>";
                                    }
                                } else {
                                    echo "<p>Você não possuí nenhum agendamento registrado.</p>";
                                }
                            ?>
                        </table>
                        </div>
                    </main>
                </body>
            <?php
        }
    } else {
        ?>
            <header>
            <img class="logo" src="../images/logomarca.png" alt="Logo da ONG, duas mãos em formato de concha segurando uma planta crescendo, em estilo de desenho simples.">
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

