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

}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo $output;
}

$request_body = file_get_contents('php://input');

$data = json_decode($request_body, true);

$item = isset($data['item'])?$data['item']: 0;

if (isset($item['login']) || isset($item['senha'])){

    if(strlen($item['nome']) == 0){
        debug_to_console(1);
    } else if(strlen($item['login']) == 0){
        debug_to_console(2);
    } else if(strlen($item['senha']) == 0){
        debug_to_console(3);
    }else{

        $nome = $mysqli->real_escape_string($item['nome']);
        $login = $mysqli->real_escape_string($item['login']);
        $senha = $mysqli->real_escape_string($item['senha']);
        $cargo = $mysqli->real_escape_string($item['cargo']);

        $query_select = "SELECT * FROM usuarios WHERE login = '$login'";
        attquery();
        $sql_query1 = $mysqli->query($query_select) or die('Falha na execução! Error:' . $mysqli->error);
        $quantidade = $sql_query1 -> num_rows;

        $query_select2 = "SELECT nome FROM usuarios";
        attquery();
        $sql_query2 = $mysqli->query($query_select2) or die('Falha na execução! Error:' . $mysqli->error);

        while($row = mysqli_fetch_assoc($sql_query2)){

            foreach($row as $cname => $cvalue){

                if(strcasecmp($cvalue, $nome) != 0){

                    continue;

                }
                else{

                    debug_to_console(4);
                    die();

                }

            }

        }

        if($quantidade > 0){

            debug_to_console(5);
            die();

        }
        else{

            $senha_cryp = password_hash($senha, PASSWORD_DEFAULT);
            $sql_query3 = "INSERT INTO usuarios (ID, nome, login, senha, cargo) VALUES (NULL,'$nome','$login','$senha_cryp', '$cargo')";
            $insert = $mysqli -> query($sql_query3);
            
            if($insert){

                debug_to_console(6);
                die();
                
            }
            else{

                debug_to_console(7);
                die();

            }



        }  
    }
}


?>