<?php

    include('conexao.php');
    include('protect.php');
    date_default_timezone_set("America/Fortaleza");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/sistema_vendas.css" media='screen'>
    <title>Sistema de Vendas</title>
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script src="http://cdn.date-fns.org/v1.0.0/date_fns.min.js"></script>
    <script src="https://kit.fontawesome.com/5a10958f37.js" crossorigin="anonymous"></script>

    <i class="fa-solid fa-cart-shopping fa-6x"></i>
    <br>
    <img src="imagens/sistema de vendas.PNG" alt="Sistema de Vendas" title='Sistema de Vendas' id='titulo'>
    
    <div id='campobuttons'>

        <button id="buttonsair" onclick="location.href='logout.php';"> Sair <i class="fa-solid fa-door-open"></i></button>

        <button id="buttonvoltar" onclick="location.href='painel.php';"> Voltar <i class="fa-solid fa-rotate-left"></i></button>

    </div>

    <fieldset id='fieldform'>

    <form>

        <div id='labelicon1'>
            <i class="fa-solid fa-circle fa-2xs"></i>
            <label for="" id='label1'>Informações da Venda</label>
        </div>
            
        <fieldset class='grupo' id='fieldset1'>
            <div class='campo'>
                <label for="codigovenda">Código de Venda:</label>
                <input type="number" name="codigovenda" id="codigovenda" min='1' required autocomplete="off">
            </div>

            <div class='campo'>
                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required autocomplete="off" value="<?php echo date('Y-m-d')?>">
            </div>

            <div class='campo'>
                <label for="idloja">ID da Loja:</label>
                <input type="search" list='pesquisarloja' name="idloja" id="idloja" required autocomplete="off">
                    <datalist id='pesquisarloja'>
                        <?php

                            $sql_query1 = 'SELECT Lojas FROM idlojas ORDER BY Lojas';

                            while ($mysqli->next_result()) {
                                if ($result = $mysqli->store_result()) {
                                    $result->free();
                                }
                            }

                            $selectlojas = $mysqli -> query($sql_query1);
                            $listalojas_php = [];

                            while($idlojas = $selectlojas->fetch_all(MYSQLI_ASSOC)){

                                foreach ($idlojas as $loja){

                                    $loja_implode = implode('', $loja);
                                    echo "<option value='$loja_implode'>";
                                    array_push($listalojas_php, $loja_implode);

                                }
                            
                            }

                        ?>
                        
                    </datalist>

            </div>

        </fieldset>

        <br>

        <div id='labelicon2'>
            <i class="fa-solid fa-circle fa-2xs"></i>
            <label for="" id='label2'>Produto(s) e Quantidade(s)</label>   
        </div>

        <fieldset class='grupo' id='fieldset2'>
            <div class='divfieldsetproduto'id='divfieldsetproduto1'>
                <fieldset class='grupo' id='fieldsetproduto1' style='background-color: #d2c1f5;'>
                    <div class='campo' id='camposelecioneproduto'>
                        <label id='labelselecioneproduto'for="selecioneproduto1">Produto:</label>
                        <input type="search" list='pesquisarproduto' name="selecioneproduto" id="selecioneproduto1" required autocomplete="off">
                            <datalist id='pesquisarproduto'>
                                <?php

                                $sql_query2 = 'SELECT Produtos, Valores FROM produtosdb ORDER BY Produtos';

                                while ($mysqli->next_result()) {
                                    if ($result = $mysqli->store_result()) {
                                        $result->free();
                                    }
                                }

                                $select_produtos = $mysqli -> query($sql_query2);

                                $valoresprodutos_php = [];
                                $listaprodutos_php = [];

                                while($produtos = $select_produtos -> fetch_all(MYSQLI_ASSOC)){

                                    foreach ($produtos as $produto){

                                        echo "<option value= '$produto[Produtos]'>";
                                        array_push($listaprodutos_php, $produto['Produtos']);
                                        $valoresprodutos_php[$produto['Produtos']] = $produto['Valores'];

                                    }
                                }

                                ?>
                            </datalist>
                    </div>                        

                    <div class='campo' id='campoquantidade'>

                        <label id='labelquantidade'for="quantidade1">Quantidade:</label>
                            <input type="number" name="quantidade" id="quantidade1" min='0' value='0' required/>
                    
                    </div>
                

                    <div class='campobutton' id='campobuttonremover'>

                        <button type='button' class='removerproduto' id='removerproduto1'>Remover <i class="fa-solid fa-trash"></i></button>
                    
                    </div>

                    <br>

                    <div class='numbervalue' id='valorunitario'>

                        <label id='labelvalorunitario'for="target1">Valor Unitário:</label>
                            <strong id="target1"></strong>
                    
                    </div>
                    
                </fieldset>

                <br class='separar_produtos' id='separarprodutos1'>

            </div>

            <div class='campobutton' id='campobutton'>
                    <button type='button' id=adicionarproduto><i class="fa-solid fa-plus fa-sm"></i> Produto</button>
            </div>
            
        </fieldset>

        <br>

        <script>

            var valoresprodutos = {}

            $.each(<?php echo json_encode($valoresprodutos_php); ?>, function(key, value){
                valoresprodutos[key.trim()] = value.trim();
            });

            var count = 1

            function gerar_idnovo(id){

                return id.replace(String(count-(count-1)), String(count));

            }

            function contador(){

                count +=1

            }

            $(document).ready(function (){

                var listprodutos = []
                var listvalores = []
                var listquantidades = []
                var valorfinal = 0
                var valorfinalformatado = ''
                var produtonovo = 0

                var listaprodutos = $.trim(<?php echo json_encode($listaprodutos_php); ?>);

                function rewrite_elements(){

                    $('#divfieldsetproduto'+ count).find('#separarprodutos'+count).attr('id', 'separarprodutos' + indicefieldset)
                    $('#fieldset2').find('#divfieldsetproduto'+count).attr('id', 'divfieldsetproduto' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#labelselecioneproduto').attr('for', 'selecioneproduto' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#selecioneproduto'+count).attr('id', 'selecioneproduto' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#labelvalorunitario').attr('for', 'target' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#target'+count).attr('id', 'target' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#labelquantidade').attr('for', 'quantidade' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#quantidade'+count).attr('id', 'quantidade' + (indicefieldset));
                    $('#fieldsetproduto' + count).find('#removerproduto'+count).attr('id', 'removerproduto' + (indicefieldset));
                    $('#fieldsetproduto' + count).attr('id', 'fieldsetproduto' + indicefieldset)

                    }

                function rewrite_values(){

                    listprodutos = []
                    listvalores = []
                    listquantidades = []
                    $('#registrarpedido').prop('disabled', true)
                    produtoinvalid = 0

                    var codvenda = $('#codigovenda').val();
                    var data = $('#data').val().replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                    var datasplit = data.split('/')
                    var data_atual = new Date().toLocaleString('pt-BR').substr(0,10);
                    data_atual = data_atual.split('/')
                    var idloja = $('#idloja').val();

                    var listalojas = <?php echo json_encode($listalojas_php); ?>;

                    lojaverified = 0;
                    Object.keys(listalojas).forEach((item) => {
                        var lojaprocurada = listalojas[item];
                        if (idloja.trim() == lojaprocurada.trim() ){
                            lojaverified = 1;
                    }
                    })

                    for (var i = 1; i <= count; i++){

                        valorformatado = []
                        valorfinal = 0

                        var produto = $('#selecioneproduto'+i).val()
                        if (listaprodutos.indexOf(produto) != -1){

                            listprodutos.push(produto)
                            var valor = parseInt(valoresprodutos[produto]);
                            listvalores.push(valor)

                        }
                        else{

                            listprodutos.push(0)
                            listvalores.push(0)

                        }
                        
                        var quantidade = parseInt($('#quantidade'+i).val());
                    listquantidades.push(quantidade)

                        if (count == i){

                            produtonovo = 0
                                
                            for (var n = 0; n < listprodutos.length; n++){

                                if (listprodutos[n] == '' & listquantidades[n] == 0 | isNaN(listquantidades[n])){

                                    produtonovo += 1

                                    }

                                valorformatado.push(listvalores[n].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));

                                if (listvalores[n]>0){

                                    $('#target'+(n+1)).html(valorformatado[n])
                            
                                }
                                else{

                                    $('#target'+(n+1)).html('')
                                    

                                }
                                
                                if (listvalores[n]>0 & listquantidades[n]>0){

                                    valorfinal += listquantidades[n]*listvalores[n]
                                    valorfinalformatado = valorfinal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                                    $('#targetvalorfinal').html(valorfinalformatado)

                                    }
                                }
                                
                            for ( var n = 0; n < listprodutos.length; n++){

                                if (listaprodutos.indexOf(listprodutos[n]) != -1 & listquantidades[n] > 0){

                                    produtoinvalid = 0;

                                }
                                else if(listaprodutos.indexOf(listprodutos[n]) == -1 | listquantidades[n] == 0 | isNaN(listquantidades[n])) {

                                    produtoinvalid = 1;
                                    $('#registrarpedido').prop('disabled', true);
                                    break

                                    }
                                }
                            }
                        }

                    if (produtonovo == 0 & produtoinvalid == 0){    
                        var ano = parseInt(datasplit[2]);
                        var mes = parseInt(datasplit[1]);
                        var dia = parseInt(datasplit[0]);
                        var anoatual = parseInt(data_atual[2])
                        var mesatual = parseInt(data_atual[1])
                        var diaatual = parseInt(data_atual[0])
                        var comparardatas = dateFns.compareAsc(new Date(ano, (mes-1), dia), new Date(anoatual, (mesatual-1), diaatual))
                        if(comparardatas <= 0 & ano >= 1000 & data.length == 10){
                            if(codvenda > 0  & lojaverified === 1){
                                $('#registrarpedido').prop('disabled', false)
                                
                            }
                        }
                        else{
                                console.log('Data Inválida!!!')
                                $('#registrarpedido').prop('disabled', true)
                            }
                    
                    }
                    else{
                        $('#registrarpedido').prop('disabled', true)
                    }

                }
                
                $('#adicionarproduto').on('click', function (){

                    contador()
                    produtonovo += 1

                    novodivfieldsetproduto = gerar_idnovo('divfieldsetproduto1')

                    var DivFieldsetProdutoNode = $('#divfieldsetproduto1')
                    var clone = DivFieldsetProdutoNode.clone(true).attr('id', novodivfieldsetproduto).prop("style", $('#fielsetproduto1').attr("style"))
                    $('#fieldset2').append(clone);

                    $('#'+ novodivfieldsetproduto).find('#fieldsetproduto1').attr('id', gerar_idnovo('fieldsetproduto1'))
                    $('#'+ novodivfieldsetproduto).find('#labelselecioneproduto').attr('for', gerar_idnovo('selecioneproduto1'));
                    $('#'+ novodivfieldsetproduto).find('#selecioneproduto1').attr('id', gerar_idnovo('selecioneproduto1')).val('');
                    $('#'+ novodivfieldsetproduto).find('#labelvalorunitario').attr('for', gerar_idnovo('target1'));
                    $('#'+ novodivfieldsetproduto).find('#target1').attr('id', gerar_idnovo('target1')).html('');
                    $('#'+ novodivfieldsetproduto).find('#labelquantidade').attr('for', gerar_idnovo('quantidade1'));
                    $('#'+ novodivfieldsetproduto).find('#quantidade1').attr('id', gerar_idnovo('quantidade1')).val(0);
                    $('#'+ novodivfieldsetproduto).find('#removerproduto1').attr('id', gerar_idnovo('removerproduto1'));
                    $('#'+ novodivfieldsetproduto).find('#separarprodutos1').attr('id', gerar_idnovo('separarprodutos1'));

                    $('#campobutton').appendTo('#fieldset2');

                    valorfinal = 0
                    valorformatado = []
                        
                    rewrite_values()

                })

                $('.removerproduto').on('click', function(){

                    indicefieldset = parseInt($(this).attr('id').replace(/[^0-9]/g,''))

                    if(valorfinal>0 & count>1){
                            
                        listprodutos.splice((indicefieldset-1), 1)
                        listvalores.splice((indicefieldset-1), 1)
                        listquantidades.splice((indicefieldset-1), 1)
                        
                        valorfinal = 0
                        valorformatado = []
                            
                        for (n=0 ; n<listprodutos.length; n++){

                            valorformatado.push(listvalores[n].toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
                            valorfinal += listquantidades[n]*listvalores[n]
                            
                        }
                        
                        if(valorfinal>0){
                            valorfinalformatado = valorfinal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                            $('#targetvalorfinal').html(valorfinalformatado);
                        }
                        else{
                            $('#targetvalorfinal').html('');
                        }

                        rewrite_elements()
                        
                        $(this).parent().parent().parent().remove()
                        count -= 1

                    }                 
                    else if (indicefieldset>=1 & count>1){
                        
                        rewrite_elements()
                        
                        $(this).parent().parent().parent().remove()
                        count -= 1
                        
                    }
                    else{

                        $('#selecioneproduto1').val('')
                        $('#quantidade1').val(0)
                        $('#target1').html('')
                        $('#targetvalorfinal').html('')

                    }
                    
                    rewrite_values()

                            })
        
                $('.grupo').on('change', function(){
                    
                    rewrite_values()
                                                                            
                                        })

                $('#registrarpedido').on('click', function(){

                    var codigovenda = $('#codigovenda').val().trim()
                    var data = $('#data').val().replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1').split('/')
                    var idloja = $('#idloja').val().trim()

                    axios.post('axios/historico.php', {
                        item:{'Codigo Venda': codigovenda, 'Data': data, 'ID Loja': idloja, 'Produto(s)': listprodutos, 'Quantidade(s)': listquantidades, 'Valor Final': valorfinal},
                    })
                    .then(response=>{

                        console.log(response);

                        if(response['data'] == 1){

                            alert('Venda registrada com sucesso!');
                            location.reload();

                        }
                        else if(response['data'] == 2){

                            alert('Não foi possível registrar a venda!');

                        }
                        else if(response['data'] == 3){

                            alert('Código de Venda já existente!');

                        }

                    })
                    .catch(err=>{

                        console.log(err);

                    })
                        })               
                            })

                
                                            
        </script>

        <fieldset class='grupo' id='fieldset3'>
            
        <div class='numbervalue' id='valorfinal'>
            <label for="targetvalorfinal">Valor Final:</label>
                <strong id="targetvalorfinal"></strong>
        </div>

        </fieldset>

        <button type='button' id='registrarpedido' disabled>Enviar</button>

    </form>

</fieldset>
    

</body>

</html>