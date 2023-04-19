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

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo $output;
}

if($_SESSION['cargo'] != 'diretor'){

    debug_to_console('failure');
    die();    

}

$request_body = file_get_contents('php://input');

$data = json_decode($request_body, true);

$item = isset($data['item'])?$data['item']: 0;

if(isset($item['nome'])){

    $nome = $item['nome'];

    $sql_delete = "DELETE FROM usuarios WHERE nome = '{$nome}'";

    attquery();

    $delete = $mysqli -> query($sql_delete);

    if($delete){

        debug_to_console('sucess');

    }
    else{

        debug_to_console('failure');

    }

}



?>