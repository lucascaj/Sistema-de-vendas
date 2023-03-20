<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/login.css" media='screen'>
    <title>Login</title>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5a10958f37.js" crossorigin="anonymous"></script>

<header class="fa-layers fa-fw">

    <i class="fa-solid fa-cart-shopping fa-3x"></i>
    <div id="linha-vertical"></div>
    <img src="imagens/sistema de vendas.PNG" alt="Sistema de Vendas" title='Sistema de Vendas' id='titulo'>

</header>
    
    <fieldset id='campologin'>

    <p id='subtitulo'>Login</p>
    <br>
    <i class="fa-solid fa-circle-user fa-6x fa-flip" style="--fa-animation-duration: 3s;"></i>

    <form method="POST" action='login.php'>

        <div><i class="fa-solid fa-user"></i><input type="text" name='login' id='login' autocomplete="off" placeholder='Usuário'></div>
        <br>
        <div><i class="fa-solid fa-key"></i><input type="password" name='senha' id='senha' placeholder='Senha'></div>
        <br>
        <button type="submit" id='entrar' name='entrar'> Entrar <i class="fa fa-solid fa-arrow-right"></i> </button> 

    </form>

    </fieldset>

    <?php

    include('conexao.php');

    function attquery(){

        global $mysqli;

        while ($mysqli->next_result()) {
            if ($result = $mysqli->store_result()) {
                $result->free();
            }
        }

    };
    
    if (isset($_POST['login']) || isset($_POST['senha'])){

        if(strlen($_POST['login']) == 0){
            echo "<script language='javascript' type='text/javascript'>alert('Preencha o login!');if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}</script>";
        } else if(strlen($_POST['senha']) == 0){
            echo "<script language='javascript' type='text/javascript'>alert('Preencha a senha!');if( window.history.replaceState ){window.history.replaceState( null, null, window.location.href );}</script>";
            
        }else{

            $login = $mysqli->real_escape_string(filter_input(INPUT_POST, 'login', FILTER_DEFAULT));
            $senha = $mysqli->real_escape_string(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));

            $sql_select = "SELECT * FROM usuarios WHERE login = '$login'";

            attquery();

            $select_login = $mysqli->query($sql_select) or die('Falha na execução! Error:' . $mysqli->error);
            $quantidade = $select_login -> num_rows;

            if($quantidade == 1){

                $usuario = $select_login->fetch_assoc();

                foreach($usuario as $cname => $cvalue){

                    if(password_verify($senha, $usuario['senha'])){

                        if(!isset($_SESSION)){
                            session_start();
                        }
        
                        $_SESSION['id'] = $usuario['id'];
                        $_SESSION['nome'] = $usuario['nome'];
                        $_SESSION['cargo'] = $usuario['cargo'];
        
                        header('Location: painel.php');

                    }
                    else{

                        echo "<script language='javascript' type='text/javascript'>alert('Login ou Senha incorretos!');window.location.href='login.php';</script>";

                    }
                } 
            }
            else {

                echo "<script language='javascript' type='text/javascript'>alert('Login ou Senha incorretos!');window.location.href='login.php';</script>";

            }
        }
    }
        
?>
    
</body>
</html>