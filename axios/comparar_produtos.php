<?php

include('../conexao.php');
include('../protect.php');

function removerAcentos($texto){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$texto);
}

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

    $produtoatual = $item['produtoatual'];
    $produtonovo = $item['produtonovo'];
    $valornovo = $item['valornovo'];
    $valoratual = $item['valoratual'];

    if(strlen($produtonovo) == 0){
        debug_to_console(1);
    } else if(strlen($valornovo) == 0){
        debug_to_console(2);
    } else{

        $sql_select = 'SELECT Produtos FROM produtosdb';
        attquery();
        $select_produtos = $mysqli -> query($sql_select);

        while($row = mysqli_fetch_assoc($select_produtos)){

            foreach($row as $cname => $cvalue){

                if(strcasecmp(trim(removerAcentos($cvalue)), trim(removerAcentos($produtonovo))) != 0){

                    continue;

                }
                else if($valornovo == $valoratual){

                    debug_to_console(3);
                    die();

                }
            }
        }
        $sql_update = "UPDATE produtosdb SET Produtos = '{$produtonovo}', Valores = '{$valornovo}' WHERE Produtos = '{$produtoatual}'";
        attquery();
        $update_produtos = $mysqli -> query($sql_update);

        if($update_produtos){

            debug_to_console(4);

        }
        else{

            debug_to_console(5);

        }
    }
}

?>