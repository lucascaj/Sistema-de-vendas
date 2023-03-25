<?php

    include('conexao.php');
    include('protect.php');

    if($_SESSION['cargo'] != 'diretor'){

        echo "<script language='javascript' type='text/javascript'>alert('Você não tem permissão para acessar essa página!');window.location.href='painel.php';</script>";
        die();

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
    };
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/relatorio.css" media='screen'>
    <title>Relatorio de Vendas</title>
</head>
<body>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5a10958f37.js" crossorigin="anonymous"></script>

    <div id='campobuttons'>

        <button id="buttonsair" onclick="location.href='logout.php';"> Sair <i class="fa-solid fa-door-open"></i></button>

        <button id="buttonvoltar" onclick="location.href='painel.php';"> Voltar <i class="fa-solid fa-rotate-left"></i></button>

    </div>

    <i class="fa-regular fa-clipboard fa-6x"></i>

    <br>

    <img src="imagens/relatorio de vendas.PNG" alt="Relatório de Vendas" title='Relatório de Vendas' id='titulo'>
     
    <br>

    <div>
        <fieldset id='fieldsearch'>

            <label for="procurar"><i class="fa-solid fa-magnifying-glass fa-sm"></i></label>
            <label for="procurar">Pesquisar:</label>
            <input type="text" name="procurar" id="procurar" autocomplete='off' placeholder='ID'>

            <select name="optionsearch" id="selectinfo">
                <option value="id" selected>ID</option>
                <option value="data">Data</option>
                <option value="loja">Loja</option>
                <option value="produto">Produto</option>[
                <option value="valor">Valor Total</option>
            </select>

        </fieldset>

        <script>

            $('#selectinfo').on('change', function(){

                selected = $('#selectinfo option:selected').text()

                $('#procurar').attr('placeholder', selected);

                $("tr:gt(0)").show()

                if($('#selectinfo option:selected').val() == 'data'){

                    $('#procurar').attr('type', 'date')

                }
                else{

                    $('#procurar').attr('type', 'text').val("")

                }
                
            })

            $('#procurar').on('input', function(){

                tamanho = $('tr:gt(0)').length

                if($('#selectinfo option:selected').val() == 'id'){

                    var procurado = $(this).val().trim()

                    $("tr:gt(0)").hide()

                    var row = $("td:nth-child(1)").text().replace('Código de Venda', "").trim()
                    var row_split = row.split(" ")    

                    for(var i = 0; i < tamanho; i++){

                        if(row_split[i].includes(procurado)){

                            $("tr:contains("+ row_split[i] +")").show()

                            }
                        }
                    }

                if($('#selectinfo option:selected').val() == 'data'){

                    var procurado = $(this).val().replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');

                    $("tr:gt(0)").hide()

                    var row = $("td:nth-child(2)").text().replace('Data', "").trim()
                    var row_split = row.split(" ")

                    for (var i = 0; i < tamanho; i++){

                        if(row_split[i].includes(procurado)){

                            $("tr:contains("+ row_split[i] +")").show()

                        }

                    }


                }

                if($('#selectinfo option:selected').val() == 'loja'){

                    var procurado = $(this).val().trim()

                    $("tr:gt(0)").hide()

                    var row = $("td:nth-child(3)").text().replace('ID da Loja', '').trim()
                    var row_split = row.split(" ")

                    for (var i = 0; i < row_split.length; i++){

                        if(row_split[i].replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n").toLowerCase().includes(procurado.replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n").toLowerCase())){

                            $("tr:contains("+ row_split[i] +")").show()

                        }
                    }
                }

                if($('#selectinfo option:selected').val() == 'produto'){

                    var procurado = $(this).val().trim()

                    $("tr:gt(0)").hide()

                    var row = $("td:nth-child(4)").text().replace('Produto(s) e Quantidade(s)', "").trim()
                    var row_split = row.split(" ")

                    for (var i = 0; i < row_split.length; i++){

                        if(row_split[i].replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n").toLowerCase().includes(procurado.replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n").toLowerCase())){

                            $("tr:contains("+ row_split[i] +")").show()

                        }
                    }
                }

                if($('#selectinfo option:selected').val() == 'valor'){

                    var procurado = $(this).val().toString().trim()
                    var row_split = []

                    $("tr:gt(0)").hide()

                    <?php

                        $sql_select3 = "SELECT Valor_Total FROM historico ORDER BY Codigo_Venda";

                        attquery();

                        $select_valores = $mysqli ->query($sql_select3);

                        while($row = mysqli_fetch_assoc($select_valores)){

                            $valor_total = $row['Valor_Total'];

                        ?>

                            row_split.push(<?php echo $valor_total ?>.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}).replace("R$", "").trim())

                        <?php } ?>
                    
                    for (var i = 0; i < tamanho; i++){

                        if(procurado.replace(".", "").length >= 4){

                            if(row_split[i].replace(".", "").includes(procurado.replace(".", ""))){

                                $("tr:contains("+ row_split[i] +")").show()

                            }    

                        }
                        else{

                            if(row_split[i].replace(".", "").includes(procurado)){

                                $("tr:contains("+ row_split[i] +")").show()

                            }
                        }
                    }
                }
            })
            
                

</script>

        
    </div>

    <br>

    <div>

        <fieldset id='fieldhistorico'>
        
        <div id='labelicon1'>
            <i class="fa-solid fa-circle fa-2xs"></i>
            <label for="historico">Histórico de Vendas:</label>
        </div>

            <table border="1">

                <tr id='rowcolumns'>
                    <td>Código de Venda</td>
                    <td>Data</td>
                    <td>ID da Loja</td>
                    <td>Produto(s) e Quantidade(s)</td>
                    <td>Valor Total(R$)</td>
                </tr>

                <?php

                $sql_select2 = "SELECT * FROM historico ORDER BY Codigo_Venda";

                attquery();

                $select_historico = $mysqli ->query($sql_select2);

                while($row = mysqli_fetch_assoc($select_historico)){

                    $produtos_exploded = explode(', ' , $row['Produtos']);
                    $quantidades_exploded = explode(', ', $row['Quantidades']);

                ?>
                        <tr id = 'rowtable'>
                            <td> <?php echo $row['Codigo_Venda'] ?></td>
                            <td> <?php echo $row['Data'] ?></td>
                            <td> <?php echo $row['ID_Loja'] ?></td>
                            <td> <?php 

                                for($i=0 ; $i<count($produtos_exploded) ; $i++){

                                    echo $produtos_exploded[$i]."(". $quantidades_exploded[$i].")";
                                    if($i+1<count($produtos_exploded)){

                                        echo ", ";

                                    };
                                };
                            
                            ?></td>
                            <td><?php echo number_format($row['Valor_Total'], 2, ",", ".") ?></td>
                        </tr>

                    <?php } ?>
            </table>
            
        </fieldset>

        
        
    </div>

    <br>

    <fieldset>

    <div id='divlucrobruto'>

        <label for="vendastotais"><i class="fa-solid fa-sack-dollar fa-sm"></i> Lucro Bruto:</label>
        <?php

            $sql_select = "SELECT SUM(Valor_Total) AS Lucro_Bruto FROM historico";

            attquery();

            $select_valortotal = $mysqli -> query($sql_select);

            if($select_valortotal){

                $lucrobruto = mysqli_fetch_assoc($select_valortotal);

                echo "R$ ". number_format($lucrobruto['Lucro_Bruto'], 2, ",", ".");

            }
            
        ?>

    </div>

    </fieldset>

</body>
</html>