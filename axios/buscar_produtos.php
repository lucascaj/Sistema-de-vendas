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

if($_SESSION['cargo'] == 'operador'){

    debug_to_console('failure');
    die();    

}

$request_body = file_get_contents('php://input');

$data = json_decode($request_body, true);

$item = isset($data['item'])?$data['item']: 0;

if($item != 0){

    $produtoatual = $item['produto'];

    $sql_select = "SELECT Valores FROM produtosdb WHERE Produtos = '{$produtoatual}'";

    attquery();

    $selectproduto = $mysqli->query($sql_select);

    if($selectproduto){

        while($row = mysqli_fetch_assoc($selectproduto)){
            foreach($row as $cname => $cvalue){
                debug_to_console("$cvalue");
            }
        }

    }
}

?>