<?php

include_once('../conexao.php');

$obj_db = new db();
//Realizando a conexão
$mysqli = $obj_db->conec_mysql();

//Se entrar aqui é o login
if(!empty($_POST['username']) && !empty($_POST['password'])){

    //Recuperando valores dos campos de login
    $user = $_POST['username'];
    $senha = $_POST['password'];

    //Verificando se já existe uma conta criada com esse email
    $query = "select * from seg_usuarios where email = '$user' AND senha = '".md5($senha)."' ";
    //Realizado o select no banco 
    $result = $mysqli->query($query);
    
    //Verificando se ocorreu erro na query
    if(!$result){
    
        die("Erro: ".$mysqli->error);
        
    //Se não retornou nenhuma linha quer dizer que não existe um email cadastrado
    }else if(mysqli_num_rows($result) > 0){

        //Recuperando dados da consulta
        $dados = mysqli_fetch_assoc($result);

        if($dados['ativo'] == '0'){
            echo "<script>alert('Usuário Inativo.');</script>";
        }else{
            //Recuperando o id do usuário
            //Iniciando a sessão
            session_start();
            $_SESSION['user_id'] = $dados['id'];
            header("Location: ../home/home.php");
        }
    //Se o usuários já existir
    }else{  
        //Enviando para a tela de cadastro falando que a conta já existe
        echo "<script>alert('Email e/ou senha não encontrado.');</script>";
    }
    
    //Limpando a query
    mysqli_free_result($result);
    //Fechando a conexão
    $mysqli->close();

    echo "<script>location.href = 'login.php'</script>";

}elseif(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['passwd']) ){

    //Recuperar valor dos campos do cadastro
    $nome_cad = $_POST['nome'];
    $email_cad = $_POST['email'];
    $senha_cad = $_POST['passwd'];
    
    //Verificando se já existe uma conta criada com esse email
    $query = "select * from seg_usuarios where email = '$email_cad' ";
    //Realizado o select no banco 
    $result = $mysqli->query($query);
    
    //Verificando se ocorreu erro na query
    if(!$result){
    
        die("Erro: ".$mysqli->error);
        
    //Se não retornou nenhuma linha quer dizer que não existe um email cadastrado
    }else if(mysqli_num_rows($result) == 0){
        //Query para inserir o usuários no banco
        $query = "insert into seg_usuarios(nome, email, senha, ativo) 
        values('$nome_cad', '$email_cad', '".md5($senha_cad)."', '1')";
        //Realizado o insert no banco
        $result = $mysqli->query($query);
        //Verificando se ocorreu algum erro 
        if(!$result){
            die("Erro: ".$mysqli->error);
        }else{
            //Enviando para a index com mensagem de conta criada
            echo "<script>alert('Usuário cadastrado com sucesso!.');</script>";
        
        }
    //Se o usuários já existir
    }else{       
        //Enviando para a tela de cadastro falando que a conta já existe
        echo "<script>alert('Usuário já cadastrado.');</script>";
    }
    
    //Limpando a query
    mysqli_free_result($result);
    //Fechando a conexão
    $mysqli->close();

    echo "<script>location.href = 'login.php'</script>";

}else{
    echo "<script>alert('Para realizar login é preciso digitar um email e senha.'); location.href = 'login.php'</script>";
}