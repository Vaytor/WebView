<?php

include_once('../conexao.php');

$obj_db = new db();
//Realizando a conexão
$mysqli = $obj_db->conec_mysql();

if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['passwd']) ){

    //Recuperar valor dos campos do cadastro
    $nome_cad = $_POST['nome'];
    $email_cad = $_POST['email'];
    $senha_cad = $_POST['passwd'];
    $ativo = $_POST['ativo'];

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
        values('$nome_cad', '$email_cad', '".md5($senha_cad)."', '$ativo')";
        //Realizado o insert no banco
        $result = $mysqli->query($query);
        //Verificando se ocorreu algum erro 
        if(!$result){
            die("Erro: ".$mysqli->error);
        }else{
            //Enviando para a index com mensagem de conta criada
            echo "<script>alert('Usuário cadastrado com sucesso!.');</script>";
            echo "<script>location.href = '../listaUsuarios/listaUsuarios.php'</script>";
        }
    //Se o usuários já existir
    }else{       
        //Enviando para a tela de cadastro falando que a conta já existe
        echo "<script>alert('Usuário já cadastrado.');</script>";
        echo "<script>location.href = 'cadastroUsuario.php'</script>";
    }
    
    //Limpando a query
    mysqli_free_result($result);
    //Fechando a conexão
    $mysqli->close();

}else{
    echo "<script>alert('Ocorreu um erro ao cadastrar usuário.'); location.href = 'cadastroUsuario.php'</script>";
}