<?php

$host = '';
$usuario = '';
$senha = '';

$mysqli = new mysqli($host, $usuario, $senha);

if($mysqli->error){
    die('Falha ao conectar ao banco de dados: ' . $mysqli->error);
}

$sql = "CREATE DATABASE IF NOT EXISTS logins;
        USE logins;";

$sql .= "CREATE TABLE IF NOT EXISTS usuarios(
            ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
            nome Varchar(100),
            login Varchar(30),
            senha Varchar(80),
            cargo ENUM('operador', 'gerente', 'diretor'),
            Primary Key (ID)) ENGINE = MyISAM";

if(mysqli_multi_query($mysqli, $sql) === FALSE){
    echo 'Erro ao criar a tabela!' . mysqli_error($mysqli);
}

?>
