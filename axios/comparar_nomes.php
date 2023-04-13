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

if(isset($item['nome'])){

    $nome = $item['nome'];
    $cargo = $item['cargo'];
    $nomeatual = $item['nomeatual'];

   

    if(strlen($nome) == 0){

        debug_to_console(2);
        die();

    }

    $sqlcodeselect = "SELECT cargo FROM usuarios WHERE nome = '{$nomeatual}'";
    attquery();
    $selectcargo = $mysqli->query($sqlcodeselect) or die('Falha na execução! Error:' . $mysqli->error);
    $row = mysqli_fetch_assoc($selectcargo);
    foreach($row as $cname => $cvalue){
        $cargodb = $cvalue;
        }

    $sqlcodeselect = "SELECT nome FROM usuarios";
    attquery();
    $selectusuarios = $mysqli->query($sqlcodeselect) or die('Falha na execução! Error:' . $mysqli->error);

    while($row = mysqli_fetch_assoc($selectusuarios)){
        foreach($row as $cname => $cvalue){
            
            if(strcasecmp($cvalue, $nome) == 0){

                if(strcasecmp($nomeatual, $nome) == 0 and $cargo != $cargodb){

                    $sqlupdate2 = "UPDATE usuarios SET cargo = '{$cargo}' WHERE nome = '{$nomeatual}'";
                    attquery();
                    $sql_query2 = $mysqli->query($sqlupdate2) or die('Falha na execução! Error:' . $mysqli->error);

                    if($nomeatual != $nome){

                        $sqlupdate = "UPDATE usuarios SET nome = '{$nome}' WHERE nome = '{$nomeatual}'";
                        attquery();
                        $sql_query1 = $mysqli->query($sqlupdate) or die('Falha na execução! Error:' . $mysqli->error);

                        debug_to_console(1);

                        die;

                    }

                    debug_to_console(1);

                    die;


                }
                else if(strcasecmp($nomeatual, $nome) == 0 and $cargo == $cargodb){

                    if($nomeatual != $nome){

                        $sqlupdate = "UPDATE usuarios SET nome = '{$nome}' WHERE nome = '{$nomeatual}'";
                        attquery();
                        $sql_query1 = $mysqli->query($sqlupdate) or die('Falha na execução! Error:' . $mysqli->error);

                        debug_to_console(1);

                        die;

                    }

                    debug_to_console(2);

                    die;

                }
                else if(strcasecmp($nomeatual, $nome) != 0){

                    debug_to_console(2);

                    die;

                }
            }
            else if(strcasecmp($cvalue, $nome) != 0){

                continue;

                }
            }
        }

    if(strcasecmp($nomeatual, $nome) == 0 and $cargo != $cargodb){

        $sqlupdate2 = "UPDATE usuarios SET cargo = '{$cargo}' WHERE nome = '{$nomeatual}'";
        attquery();
        $sql_query3 = $mysqli->query($sqlupdate2) or die('Falha na execução! Error:' . $mysqli->error);

        if($nomeatual != $nome){

            $sqlupdate = "UPDATE usuarios SET nome = '{$nome}' WHERE nome = '{$nomeatual}'";
            attquery();
            $sql_query1 = $mysqli->query($sqlupdate) or die('Falha na execução! Error:' . $mysqli->error);

            debug_to_console(1);

            die;

        }

        debug_to_console(1);

        die;

    }
    else if(strcasecmp($nomeatual, $nome) == 0 and $cargo == $cargodb){

        if($nomeatual != $nome){

            $sqlupdate = "UPDATE usuarios SET nome = '{$nome}' WHERE nome = '{$nomeatual}'";
            attquery();
            $sql_query1 = $mysqli->query($sqlupdate) or die('Falha na execução! Error:' . $mysqli->error);

            debug_to_console(1);

            die;

        }

        debug_to_console(2);

        die;
        
    }
    else if(strcasecmp($nomeatual, $nome) != 0 and $cargo != $cargodb){

        $sqlupdate2 = "UPDATE usuarios SET cargo = '{$cargo}' WHERE nome = '{$nomeatual}'";
        attquery();
        $sql_query2 = $mysqli->query($sqlupdate2) or die('Falha na execução! Error:' . $mysqli->error);

        $sqlupdate = "UPDATE usuarios SET nome = '{$nome}' WHERE nome = '{$nomeatual}'";
        attquery();
        $sql_query1 = $mysqli->query($sqlupdate) or die('Falha na execução! Error:' . $mysqli->error);

        debug_to_console(1);

        die;

    }
    else if(strcasecmp($nomeatual, $nome) != 0 and $cargo == $cargodb){

        $sqlupdate = "UPDATE usuarios SET nome = '{$nome}' WHERE nome = '{$nomeatual}'";
        attquery();
        $sql_query3 = $mysqli->query($sqlupdate) or die('Falha na execução! Error:' . $mysqli->error);

        debug_to_console(1);

        die;    

        }

}

?>