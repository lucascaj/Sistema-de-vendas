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

$request_body = file_get_contents('php://input');

$data = json_decode($request_body, true);

$item = isset($data['item'])?$data['item']: 0;

if($item != 0){



    $codigovenda = $item['Codigo Venda'];
    $data = implode('/', $item['Data']);
    $idloja = $item['ID Loja'];
    $produtos = implode(", ", $item['Produto(s)']);
    $quantidades = implode(", ", $item['Quantidade(s)']);
    $valorfinal = $item['Valor Final'];

    $sql_select = "SELECT Codigo_Venda FROM historico WHERE Codigo_Venda = ". $codigovenda;

    attquery();

    $select = $mysqli -> query($sql_select);

    $quantidade = $select -> num_rows;

    if($quantidade > 0){

        debug_to_console(3);
        die();

    }

    $sql_insert = "INSERT INTO historico(Codigo_Venda, Data, ID_Loja, Produtos, Quantidades, Valor_Total) VALUES ('$codigovenda', '$data', '$idloja', '$produtos', '$quantidades', '$valorfinal')";

    attquery();

    $insert = $mysqli -> query($sql_insert);

    if($insert){

        debug_to_console(1);

    }
    else{

        debug_to_console(2);

    }
}



?>