<?php

    include('conexao.php');
    include('protect.php');

    if($_SESSION['cargo'] == 'operador'){

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/cargos.css" media='screen'>
    <title>Gerenciar Cargos</title>

</head>
<body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script src="https://kit.fontawesome.com/5a10958f37.js" crossorigin="anonymous"></script>

    <div id='campobuttons'>

        <button id="buttonsair" onclick="location.href='logout.php';"> Sair <i class="fa-solid fa-door-open"></i></button>

        <button id="buttonvoltar" onclick="location.href='painel.php';"> Voltar <i class="fa-solid fa-rotate-left"></i></button>

    </div>

    <i class="fa-solid fa-users-gear fa-6x"></i>

    <br>

    <img src="imagens/gerenciamento de funcionarios.PNG" alt="Gerenciamento de Funcionários" title='Gerenciamento de Funcionários' id='titulo'>

    <div>
    <fieldset id='fieldsearch'>
        <div id='divfieldsearch'>

            <label for="" class='search'><i class="fa-solid fa-magnifying-glass fa-sm"></i> </label>
            <label for="" class='search' id='labelprocurar'>Pesquisar:</label>
            <input type="text" name="procurar" id="procurar" class='search' autocomplete='off' placeholder='Nome'>
            
            <label for="" class='radio' hidden><i class="fa-solid fa-check fa-sm"></i></label>
            <label for="" class='radio' id='labelselecionar' hidden>Selecionar:</label>
            <input type="radio" id='radio1' name='radio' class='radio box' value='operador' hidden> <label for="radio1" class='radio' id='labelradio' hidden>Operador</label>
            <input type="radio" id='radio2' name='radio' class='radio box' value='gerente' hidden> <label for="radio2" class='radio' id='labelradio' hidden>Gerente</label>
            <?php if($_SESSION['cargo'] == 'diretor'){ ?> <input type="radio" id='radio3' name='radio' class='radio box' value='diretor' hidden> <label for="radio3" class='radio' id='labelradio' hidden>Diretor</label> <?php } ?>
        
            <select name="optionsearch" id="selectinfo">
                    <option value="nome"selected>Nome</option>
                    <option value="cargo">Cargo</option>
            </select>
            
            <button type='button' id='addfunc' href='#janela2' rel='modal' <?php if($_SESSION['cargo']!= 'diretor'){ ?> disabled <?php } ?>><i class="fa-solid fa-user-plus fa-sm"></i> Cadastrar Funcionário</button>

            

            
        </div>
    </fieldset>
    </div>
    
    <fieldset id='fieldnomes'>

    <div id='labelicon1'>

        <i class="fa-solid fa-circle fa-2xs"></i>
        <label for="">Funcionários:</label>

    </div>

        <ol>

        <?php

        $sql_select1 = "SELECT nome, cargo FROM usuarios WHERE cargo != 'diretor' AND nome != '{$_SESSION['nome']}' ORDER BY nome";

        attquery();

        $nomes = $mysqli -> query($sql_select1);

        $count = 0;

        while($row = mysqli_fetch_assoc($nomes)){

            ++$count;

            echo "<div class='btn-group'><li> <i class='fa-solid fa-user'></i> {$row['nome']} ({$row['cargo']}) <div id='buttonsfunc'><button type='button' class='editarfunc' id='editarfunc{$count}' href='#janela1' rel='modal'>Editar <i class='fa-solid fa-user-pen fa-xs'></i></button> <button type='button' class='removerfunc' id='removerfunc{$count}'>Remover <i class='fa-solid fa-trash fa-xs'></i></button></div></li> <br> </div>";

    }

        ?>
        
    </ol>

    </fieldset>

    <div class="window" id="janela1">
        <button id='buttonfechar' class='fechar' href="#"><i class="fa-solid fa-xmark fa-2x"></i></button>
        <div id='divtitulomodal'>
            <img src="imagens/alterar funcionario.PNG" alt="Alterar Funcionário" id='titulomodal'>
        </div>

        <br>

        <fieldset id='fieldmodal'>

        <form method="POST" action="cargos.php">

            <p>

            <div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" autocomplete="off">
            </div>

            <br>

            <div>
                <label for="cargoselect">Cargo:</label>
                <select name="cargos" id="cargoselect">
                    <option value="operador">Operador</option>
                    <option value="gerente">Gerente</option>
                    <?php if($_SESSION['cargo'] == 'diretor'){ echo "<option value='diretor'>Diretor</option>"; }?>
                </select>
            </div>

            <br>

            <div>
                <button type='button' id='alterarfunc' name='alterar'>Alterar <i class='fa-solid fa-user-pen fa-sm'></i></button>
            </div>

            </p>

        </form>

        </fieldset>

        
    
    </div>

    <div class="window" id="janela2">
        <button id='buttonfechar' class='fechar' href="#"><i class="fa-solid fa-xmark fa-2x"></i></button>
        <div id='divtitulomodal'>
            <img src="imagens/novo funcionario.PNG" alt="Novo Funcionário" id='titulomodal'>
        </div>

        <fieldset id='fieldmodal'>

        <form method="POST" action="cargos.php">

            <p>

            <div>
                <label for="nome2">Nome:</label>
                <input type="text" name="nome" id="nome2" autocomplete="off">
            </div>

            <br>

            <div>
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" autocomplete="off">
            </div>

            <br>

            <div>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" autocomplete="off">
            </div>

            <br>

            <div>
                <label for="cargoselect2">Cargo:</label>
                <select name="cargos" id="cargoselect2">
                    <option value="operador">Operador</option>
                    <option value="gerente">Gerente</option>
                    <?php if($_SESSION['cargo'] == 'diretor'){ echo "<option value='diretor'>Diretor</option>"; }?>
                </select>
            </div>

            <br>

            <div>
                <button type='button' id='adicionar' name='adicionar'>Adicionar <i class="fa-solid fa-user-plus fa-sm"></i></button>
            </div>

            </p>

        </form>

        </fieldset>
        
    
    </div>
    
<!-- mascara para cobrir o site --> 
<div id="mascara"></div>

    <script>

        $(document).ready(function(){

            <?php if($_SESSION['cargo'] != 'diretor'){ ?> 
                
            $('.removerfunc').prop('disabled', true);      
                
                <?php } ?>

            $('#selectinfo').on('change', function(){

                $('.btn-group').show()

                if($('#selectinfo option:selected').val() == 'cargo'){

                    $('.search').hide()
                    $('.radio').show()
                
                }
                else{

                    $('.radio').hide()
                    $('.search').show()

                }

             })

            

            })

            $('#procurar').on('input', function(){

                tamanho = $('li').length

                procurado = $(this).val().toLowerCase().replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n")

                $('.btn-group').hide()

                for(var i=0; i<tamanho; i++){

                    var nome = $("li:eq("+ i +")").text().replace('Editar  Remover', '').replace('(operador)', '').replace('(gerente)', '').replace('(diretor)', '').trim()
                    nome_lowercase = nome.toLowerCase().replace(/[áàãâä]/gi,"a").replace(/[éè¨ê]/gi,"e").replace(/[íìïî]/gi,"i").replace(/[óòöôõ]/gi,"o").replace(/[úùüû]/gi, "u").replace(/[ç]/gi, "c").replace(/[ñ]/gi, "n")

                    if(nome_lowercase.includes(procurado)){

                        $(".btn-group:contains('"+ nome +"')").show()

                    }

                    }

            })

            $('.radio.box').on('input', function(){
                
                var value = $(this).val()

                $('.btn-group').hide()

                if(value == 'operador'){

                    $(".btn-group:contains('(operador)')").show()

                }
                else if(value == 'gerente'){

                    $(".btn-group:contains('(gerente)')").show()

                }
                else if(value == 'diretor'){

                    $(".btn-group:contains('(diretor)')").show()

                }

            })

            $('.editarfunc').on('click', function(ev){

                ev.preventDefault();
        
                var id = $(this).attr("href");
                nomeatual = $(this).parent().parent().text().replace('Editar  Remover','').replace('(operador)', '').replace('(gerente)', '').replace('(diretor)', '').trim()

                axios.post('axios/buscar_nomes.php', {
                    item: {'nome':nomeatual},
                })
                .then(response =>{

                    cargo = response['data'].trim();

                    $("#cargoselect").val(cargo);
                    $('#nome').val(nomeatual);

                })
                .catch(err =>{

                    console.log(err);

                });

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
        
            $('.fechar').click(function(ev){
                ev.preventDefault();
                $("#mascara").hide();
                $(".window").hide();
            });

            $('#alterarfunc').on('click', function(){

                var nome = $('#nome').val();
                var cargo = $('#cargoselect').val();

                axios.post('axios/comparar_nomes.php', {
                    item: {'nome':nome, 'nomeatual':nomeatual, 'cargo':cargo},
                })
                .then(response =>{

                    if(response['data'] == 1){

                        alert('Alterações realizadas com sucesso!!!');
                        location.reload();


                    }
                    else if(response['data'] == 2){

                        alert('Não foi possível realizar alterações!!! Verifique o nome e o cargo.');  

                    }

                })
                .catch(err =>{

                    console.error(err)

                })

            })

            $('#addfunc').on('click', function(ev){

                <?php if($_SESSION['cargo'] != 'diretor'){ ?>

                alert('Você não tem permissão para acessar essa página!');
                window.location.href='cargos.php';
                die();

                <?php } ?>

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

            })

            $('#adicionar').on('click', function(){

                var nome = $('#nome2').val();
                var login = $('#login').val();
                var senha = $('#senha').val();
                var cargo = $('#cargoselect2').val();

                axios.post('axios/comparar_cadastro.php', {
                    item: {'nome':nome, 'login':login, 'senha': senha, 'cargo': cargo},
                })
                .then(response =>{

                    if(response['data']==1){

                        alert('Preencha o nome do funcionário!');
                        
                    }
                    else if(response['data']==2){

                        alert('Preencha o login!');

                    }
                    else if(response['data']==3){

                        alert('Preencha a senha!');

                    }
                    else if(response['data']==4){

                        alert('Nome de funcionário já existente!');

                    }
                    else if(response['data']==5){

                        alert('Login já existente!');

                    }
                    else if(response['data']==6){

                        alert('Usuário cadastrado com sucesso!');
                        location.reload();
                        
                    }
                    else if(response['data']==7){

                        alert('Não foi possível cadastrar o usuário!');
                        location.reload();

                    }
            })
                .catch(err =>{

                    console.log(err);

                });

            })

            $('.removerfunc').on('click', function(){

                <?php if($_SESSION['cargo'] != 'diretor'){ ?>

                    alert('Você não tem permissão para remover funcionários!');
                    window.location.href='cargos.php';
                    die();

                <?php } ?>
                
                var nome = $(this).parent().parent().text().replace('Editar  Remover', '').replace('(operador)', '').replace('(gerente)', '').replace('(diretor)', '').trim()

                axios.post('axios/remover_func.php', {
                    item: {'nome': nome},
                })
                .then(response =>{

                    if(response['data'] == 'sucess'){

                        alert('Funcionário removido com sucesso!!!');
                        location.reload();

                    }

                    if(response['data'] == 'failure'){

                        alert('Não foi possível remover o funcionário!!!');

                    }

                })
                .catch(err =>{

                    console.error(err)

                })
            
            })    

    </script>


    
</body>
</html>