<?php

include('../conexao.php');
include('../protect.php');

if($_SESSION['cargo'] == 'operador'){

    debug_to_console('failure');
    die();    

}

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

$request_body = file_get_contents('php://input');

$data = json_decode($request_body, true);

$item = isset($data['item'])?$data['item']: 0;

if ($item != 0){

    $produtonovo = $item['produtonovo'];
    $valornovo = $item['valornovo'];

    if(strlen($produtonovo) == 0){

        debug_to_console(1);

    }
    else if(strlen($valornovo) == 0){

        debug_to_console(2);

    }
    else{

        $query_select = "SELECT Produtos FROM produtosdb";

        attquery();

        $select_produtos = $mysqli->query($query_select) or die('Falha na execução! Error:' . $mysqli->error);

        while($idproduto = mysqli_fetch_assoc($select_produtos)){

            foreach ($idproduto as $produtoprocurado){

                if(trim(strtolower(removerAcentos($produtoprocurado))) == trim(strtolower(removerAcentos($produtonovo)))){

                    debug_to_console(3);
                    die();

                }
            }
        }

        $sql_insert = "INSERT INTO produtosdb (ID, Produtos, Valores) VALUES (NULL, '$produtonovo', '$valornovo')";

        attquery();

        $insert_produtos = $mysqli->query($sql_insert) or die('Falha na execução! Error:' . $mysqli->error);

        if($insert_produtos){

            debug_to_console(4);

        }
        else{

            debug_to_console(5);

        }
    }
}




?>