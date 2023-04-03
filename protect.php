<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['nome'])){
    
    echo "<script language='javascript' type='text/javascript'>alert('Você não pode acessar essa página!');window.location.href='login.php';</script>";
    die();   
}

?>