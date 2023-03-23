
<?php

include('conexao.php');
include('protect.php');

if($_SESSION['cargo'] == 'operador'){

    echo "<script language='javascript' type='text/javascript'>alert('Você não tem permissão para acessar essa página!');window.location.href='painel.php';</script>";
    die();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/addremprodutos.css" media='screen'>
    <title>Gerenciamento de Produtos</title>
</head>

<body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script src="https://kit.fontawesome.com/5a10958f37.js" crossorigin="anonymous"></script>

<div id='campobuttons'>

        <button id="buttonsair" onclick="location.href='logout.php';"> Sair <i class="fa-solid fa-door-open"></i></button>

        <button id="buttonvoltar" onclick="location.href='painel.php';"> Voltar <i class="fa-solid fa-rotate-left"></i></button>

</div>
    
<i class="fa-solid fa-bag-shopping fa-6x"></i>
<br>
<img src="imagens/gerenciamento de produtos.PNG" alt="Gerenciamento de Produtos" title='Gerenciamento de Produtos' id='titulo'>

<div>
    <fieldset id='fieldsearch'>
        <div>

            <label for="procurar" id='labelprocurar'> <i class="fa-solid fa-magnifying-glass fa-sm"></i> Pesquisar:</label>
            <input type="text" name="procurar" id="procurar" autocomplete='off' placeholder='Produto'>

            <button id="adicionarproduto" href="#janela1" rel="modal"><i class="fa-solid fa-plus fa-sm"></i> Adicionar Produto</button>
        </div>
    </fieldset>
</div>

<fieldset>

    <div id='labelicon1'>

        <i class="fa-solid fa-circle fa-2xs"></i>
        <label for="">Produtos:</label>

    </div>
    

    <ol>

    <?php

        function attquery(){

            global $mysqli;

            while ($mysqli->next_result()) {
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
            }

        };

        $sql_select1 = 'SELECT Produtos FROM produtosdb';

        attquery();

        $produtos = $mysqli->query($sql_select1) or die("<script language='javascript' type='text/javascript'>alert('Falha na execução! Error: {$mysqli -> error}');window.location.href='addremprodutos.php';</script>");
        $quantidade = $produtos -> num_rows+1;

        $sql_alter = "ALTER TABLE produtosdb AUTO_INCREMENT = {$quantidade}";

        attquery();

        $mysqli -> query($sql_alter);
        
        $count = 0;

        foreach ($produtos as $produto){
            
            ++$count;

            $produto = implode('', $produto);
            echo "<div class='btn-group'><li> {$produto} <div id='buttonsproduto'><button type='button' class='editarproduto' id='editarproduto{$count}' href='#janela2' rel='modal'>Editar Produto <i class='fa-solid fa-pen-to-square fa-xs'></i></button> <button type='button' class='removerproduto' id='removerproduto{$count}'>Remover <i class='fa-solid fa-trash fa-xs'></i></button></div></li> <br> </div> ";

        };
    ?>

    </ol>

    

</fieldset>

<div class="window" id="janela1">
    <button id='buttonfechar' class='fechar' href="#"><i class="fa-solid fa-xmark fa-2x"></i></button>
    <?php

        if($_SESSION['cargo'] == 'operador'){

            echo "<script language='javascript' type='text/javascript'>alert('Você não tem permissão para acessar essa página!');window.location.href='painel.php';</script>";
            die();

        }

    ?>
    <div id='divtitulomodal'>
        <img src="imagens/novo produto.PNG" alt="Novo Produto" title='Novo Produto' id='titulomodal'>
    </div>

    <br>

    <fieldset id='fieldmodal'>

        <form method="POST" action="addremprodutos.php">
        <p>

        <div id='divproduto'>
            <label for="produto">Produto:</label>
            <input type="text" name="produto" id="produto" autocomplete="off">
        </div>

        <br>

        <div id='divvalor'>
            <label for="valor">Valor(R$):</label>
            <input type="number" name="valor" id="valor">
        </div>

        <div id='aviso'></div>

        <br>

        <button type='button' id='adicionar' name='adicionar' ><i class="fa-solid fa-plus fa-sm"></i> Adicionar</button>

        </p>

        </form>

    </fieldset>
    
</div>

<div class="window" id="janela2">
    <button id='buttonfechar' class='fechar' href="#"><i class="fa-solid fa-xmark fa-2x"></i></button>

    <?php

        if($_SESSION['cargo'] == 'operador'){

            echo "<script language='javascript' type='text/javascript'>alert('Você não tem permissão para acessar essa página!');window.location.href='painel.php';</script>";
            die();

        }

    ?>

    <div id='divtitulomodal'>
        <img src="imagens/editar produto.PNG" alt="Editar Produto" title='Editar Produto' id='titulomodal'>
    </div>
    
    <br>

    <fieldset id='fieldmodal'>

        <form method="POST" action="addremprodutos.php">
        <p>

        <div>
            <label for="produtoselected">Produto:</label>
            <input type="text" name="produtoselected" id="produtoselected" autocomplete="off">
        </div>


        <br>

        <div>
            <label for="valoratual">Valor(R$):</label>
            <input type="number" name="valoratual" id="valornovo">
        </div>

        <br>

        <button type='button' id='alterarproduto' name='alterar'><i class='fa-solid fa-pen-to-square fa-xs'></i> Alterar</button>

        </p>

        </form>

    </fieldset>

</div>
  
<div id="mascara"></div>

<script>

    function rewrite_li(){

        for(i = indice; i < indice_total; i++){

            $('.btn-group').find('#removerproduto'+(i+1)).attr('id', 'removerproduto' + i);

        }     


    }

    $(document).ready(function(){

        $('#procurar').on('input', function(){

            tamanho = $('li').length

            procurado = $(this).val().toLowerCase().replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n")

            $('.btn-group').hide()

            for(var i=0; i<tamanho; i++){

                var produto = $("li:eq("+ i +")").text().replace('Editar Produto  Remover', '').trim()
                produto_lowercase = produto.toLowerCase().replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n")

                if(produto_lowercase.includes(procurado)){

                    $(".btn-group:contains('"+ produto +"')").show()

                }

                }

            })

        $('.removerproduto').on('click', function(){

            indice = parseInt($(this).attr('id').replace(/[^0-9]/g,''))

            indice_total = parseInt($( ".btn-group li" ).length)

            rewrite_li()

            $(this).parent().parent().parent().remove()

            axios.post('axios/remover_produtos.php', {
                item: {'indice': indice, 'indice_total': indice_total},
            })
                .then(response => {

                    if(response['data'] == 'sucess'){

                        alert('Produto removido com sucesso!');

                    }
                    else if(response['data'] == 'failure'){

                        alert('Não foi possível remover o produto!');

                    }
            
                })
                .catch(err => {
                    console.error(err);
                });


        })

        $("#adicionarproduto").click( function(ev){
            ev.preventDefault();
    
            var id = $(this).attr("href");
    
            var alturaTela = $(document).height();
            var larguraTela = $(window).width();
        
            //colocando o fundo preto
            $('#mascara').css({'width':larguraTela,'height':alturaTela});
            $('#mascara').fadeIn(1000); 
            $('#mascara').fadeTo("slow",0.8);
    
            var left = ($(window).width() /2) - ( $(id).width() / 2 );
            var top = ($(window).height() / 2) - ( $(id).height() / 2 );
        
            $(id).css({'top':top,'left':left});
            $(id).show();

        });

        $('#adicionar').on('click', function(){

            var produtonovo = $('#produto').val()
            var valornovo = $('#valor').val()

            axios.post('axios/comparar_produtos2.php', {
                item: {'produtonovo': produtonovo, 'valornovo': valornovo},
            })
            .then(response => {

                if(response['data'] == 1){

                    alert('Preencha o nome do produto!')
                    
                }
                else if(response['data'] == 2){

                    alert('Preencha  o valor do produto!')

                }
                else if(response['data'] == 3){

                    alert('Produto já existente!')

                }
                else if(response['data'] == 4){

                    alert('Produto cadastrado com sucesso!')
                    location.reload()

                }
                else if(response['data'] == 5){

                    alert('Não foi possível cadastrar o produto!')
                    location.reload()

                }

            })
            .catch(err => {

                console.log(err);

            })

        });

        $('.editarproduto').click(function(ev){
            ev.preventDefault();

            produtoatual = $(this).parent().parent().text().replace('Editar Produto  Remover', '').trim()

            axios.post('axios/buscar_produtos.php', {
                item: {'produto': produtoatual},
            })
            .then(response=>{

                valoratual = response['data'];

                $('#produtoselected').val(produtoatual)
                $('#valornovo').val(valoratual)

            })
            .catch(err=>{

                console.log(err);

            })
    
            var id = $(this).attr("href");
    
            var alturaTela = $(document).height();
            var larguraTela = $(window).width();
        
            //colocando o fundo preto
            $('#mascara').css({'width':larguraTela,'height':alturaTela});
            $('#mascara').fadeIn(1000); 
            $('#mascara').fadeTo("slow",0.8);
    
            var left = ($(window).width() /2) - ( $(id).width() / 2 );
            var top = ($(window).height() / 2) - ( $(id).height() / 2 );
        
            $(id).css({'top':top,'left':left});
            $(id).show();   

        })

        $('#alterarproduto').on('click', function(){
            
            var produtonovo = $('#produtoselected').val()
            var valornovo = $('#valornovo').val()

            axios.post('axios/comparar_produtos.php', { 
                item: {'produtonovo': produtonovo, 'valornovo': valornovo, 'produtoatual': produtoatual, 'valoratual': valoratual},
            })
            .then(response=>{

                console.log(response)

                if(response['data'] == 1){

                    alert('Preencha o nome do produto!');

                }else if(response['data'] == 2){

                    alert('Preencha o valor do produto!');

                }else if(response['data'] == 3){

                    alert('Produto já existente!');

                }else if(response['data'] == 4){

                    alert('Produto alterado com sucesso!');
                    location.reload();

                }else if(response['data'] == 5){

                    alert('Não foi possível alterar o produto');
                    location.reload();

                }


            })
            .catch(err=>{

                console.log(err);

            })


        })
    
        $('.fechar').click(function(ev){
            ev.preventDefault();
            $("#mascara").hide();
            $(".window").hide();
    });
});

</script>

    
</body>
</html>