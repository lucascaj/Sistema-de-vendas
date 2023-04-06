<?php

include('../conexao.php');
include('../protect.php');

function attquery(){

    global $mysqli;

        while ($mysqli->next_result()) {
            if ($result = $mysqli->store_result()) {
                $result->free();
            }
    }

};

$request_body = file_get_contents('php://input');

$data = json_decode($request_body, true);

$item = isset($data['item'])?$data['item']: 0;

if(isset($item['nome'])){

    $nome = $item['nome'];

    $sql_select = "SELECT cargo FROM usuarios WHERE nome = '{$nome}'";

    attquery();

    $cargo = $mysqli -> query($sql_select);

    while($row = mysqli_fetch_assoc($cargo)){
        foreach($row as $cname => $cvalue){
            print("$cvalue");
        }
    }

};

?>  