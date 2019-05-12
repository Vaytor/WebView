<?php

include_once('../conexao.php');

$obj_db = new db();
//Realizando a conexão
$mysqli = $obj_db->conec_mysql();

if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['id']) && !empty($_POST['ativo'])){

    //Recuperar valor dos campos do cadastro
    $nome_up = $_POST['nome'];
    $email_up = $_POST['email'];
    $ativo = $_POST['ativo'];
    $id = $_POST['id'];

    if(!empty($_POST['senha'])){
        $senha = $_POST['senha'];
        $query = "update seg_usuarios set nome = '$nome_up', senha='".md5($senha)."', email = '$email_up', ativo = '$ativo' WHERE id = $id";
    }else{
        $query = "update seg_usuarios set nome = '$nome_up', email = '$email_up', ativo = '$ativo' WHERE id = $id";
    }

    //Realizado o insert no banco
    $result = $mysqli->query($query);
    //Verificando se ocorreu algum erro 
    if(!$result){
        die("Erro: ".$mysqli->error);
    }else{
        //Enviando para a index com mensagem de conta criada
        echo "<script>alert('Usuário atualizado com sucesso!.');</script>";
        echo "<script>location.href = '../listaUsuarios/listaUsuarios.php'</script>";
    }
    
    //Limpando a query
    mysqli_free_result($result);
    //Fechando a conexão
    $mysqli->close();

}else{

    //Verificando se já existe uma conta criada com esse email
    $query = "select * from seg_usuarios where id = ".$_GET['idUser'];
    //Realizado o select no banco 
    $result = $mysqli->query($query);

    $dados = mysqli_fetch_assoc($result);

    echo '
    <div class="form-group">
        <label for="id" class="col-md-3 control-label">Usuário ID</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="id" value="'.$dados['id'].'" readonly>
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-md-3 control-label">Email</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="email" placeholder="Email" value="'.$dados['email'].'">
        </div>
    </div>
        
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Nome</label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="nome" placeholder="Nome Completo" value="'.$dados['nome'].'">
        </div>
    </div>

    <div class="form-group">
        <label for="ativo" class="col-md-3 control-label">Ativo ?</label>
        <div class="col-md-9">';

    if($dados['ativo'] == 0){
        echo 'Sim &nbsp; <input type="radio"  name="ativo" value="1" >
                Não &nbsp; <input type="radio"  name="ativo" value="0" checked> ';
    }  else{
        echo 'Sim &nbsp; <input type="radio"  name="ativo" value="1" checked>
                Não &nbsp; <input type="radio"  name="ativo" value="0">';
    }     

    echo'
        </div>
    </div>';

}