<?php
    try {
        $conection = mysqli_connect('localhost','root','');
    } catch (mysqli_sql_exception $e) {
        echo "Erro ao tentar conectar com o servidor: ".$e->getMessage();
    }
    try {
        $db = mysqli_select_db($conection,'projetoweb'); // pensemos em um nome para sempre usar
    } catch (mysqli_sql_exception $e) {
        echo "Erro ao tentar conectar com o banco: ".$e->getMessage();
    }
?>