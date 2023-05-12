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
            cargo ENUM('operador', 'gerente', 'diretor') NOT NULL,
            Primary Key (ID)) ENGINE = MyISAM";

$sql .= "CREATE TABLE IF NOT EXISTS historico(
            Codigo_Venda Int UNSIGNED ZEROFILL NOT NULL,
            Data Varchar(30) NOT NULL,
            ID_Loja Varchar(50) NOT NULL,
            Produtos Text NOT NULL,
            Quantidades Text NOT NULL,
            Valor_Total Decimal(10,2) NOT NULL,
            Primary Key(Codigo_Venda)) ENGINE = MyISAM"
 
$sql .= "CREATE TABLE IF NOT EXISTS idlojas(
            ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
            Lojas Varchar(150) NOT NULL,
            Primary Key(ID)) ENGINE = MyISAM"

$sql .= "CREATE TABLE IF NOT EXISTS produtosdb(
            ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
            Produtos Varchar(100) NOT NULL,
            Valores Decimal(10,2) NOT NULL,
            Primary Key(ID)) ENGINE = MyISAM"

if(mysqli_multi_query($mysqli, $sql) === FALSE){
    echo 'Erro ao criar o banco de dados: ' . mysqli_error($mysqli);
}

?>
