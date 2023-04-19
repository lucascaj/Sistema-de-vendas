<?php

            include("../conexao.php");
            include("../protect.php");

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

            if(isset($item['indice'])){

                $indice = intval($item['indice']);
                
                $indice_total = intval($item['indice_total']);

                $sql_remove = "DELETE FROM produtosdb WHERE ID= ". $indice;

                attquery();

                $remove_produto = $mysqli -> query($sql_remove);

                if($remove_produto){

                    debug_to_console('sucess');

                }
                else{

                    debug_to_console('failure');

                }

                for ($i = $indice; $i <= $indice_total; $i++){

                    $sql_select2 = "UPDATE produtosdb SET ID = {$i} WHERE ID = ". $i+1;

                    attquery();

                    $mysqli -> query($sql_select2);

        };


        }

            
?>