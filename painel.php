<?php

include('protect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/painel.css" media='screen'>
    <title>Painel</title>
</head>
<body>

    <script src="https://kit.fontawesome.com/5a10958f37.js" crossorigin="anonymous"></script>

    <button id="buttonsair" onclick="location.href='logout.php';"> Sair <i class="fa-solid fa-door-open"></i></button>
    
    <i class="fa-solid fa-address-card fa-6x"></i>

    <br>

    <img src="imagens/painel do funcionario.PNG" alt="Painel do Funcionário" title="Painel do Funcionário" id='simbolo'>

    <br>
    
    <div id='subtitulo'>Bem vindo ao Painel, <?php echo $_SESSION['nome']; ?></div>
    
    <fieldset id='campopainel'>

        <div>
            <button onclick="location.href='sistema_vendas.php';" class='buttonpainel'> Sistema de Vendas <i class="fa-solid fa-cart-shopping"></i></button>
        </div>

        <br>

        <div>
            <button onclick="location.href='addremprodutos.php';"  class='buttonpainel' <?php if($_SESSION['cargo'] == 'operador'){ ?> disabled <?php } ?>> Gerenciar Produtos <i class="fa-solid fa-bag-shopping"></i></button>
        </div>

        <br>

        <div>
            <button onclick="location.href='cargos.php';"  class='buttonpainel' <?php if($_SESSION['cargo'] == 'operador'){ ?> disabled <?php } ?>> Gerenciar Funcionários e Cargos <i class="fa-solid fa-users-gear"></i></button>
        </div>

        <br>

        <div>
            <button onclick="location.href='relatorio.php';" class='buttonpainel'<?php if($_SESSION['cargo'] != 'diretor'){ ?> disabled <?php } ?>> Relatório de Vendas <i class="fa-regular fa-clipboard"></i></button>
        </div>

    </fieldset>
    
</body>
</html>