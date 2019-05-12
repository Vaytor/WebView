<?php

include_once('../conexao.php');

$obj_db = new db();
//Realizando a conexão
$mysqli = $obj_db->conec_mysql();

if(!empty($_POST['tipo_pesquisa'])){

    $tipo = $_POST['tipo_pesquisa'];
    
    $pesquisa = $_POST['pesquisa'];

    if(empty($pesquisa)){
        $query = "select * from seg_usuarios";
    }else{
        if($tipo == 'tudo'){
            $query = "select * from seg_usuarios WHERE nome like '%$pesquisa%' OR email like '%$pesquisa%'";  
        }elseif($tipo == 'nome'){
            $query = "select * from seg_usuarios WHERE nome like '%$pesquisa%'";
        }elseif($tipo == 'email'){
            $query = "select * from seg_usuarios WHERE email like '%$pesquisa%'";
        }
    }

    //Realizado o select no banco 
    $result = $mysqli->query($query);
    $html = "";
    while($dados = mysqli_fetch_assoc($result)) {
        
        if($dados["ativo"] == 1){
            $dados["ativo"] = "Sim";
        }else{
            $dados["ativo"] = "Não";
        }

        $html .= "<tr>
                    <td><a href='../editarUsuario/editarUsuario.php?idUser=".$dados["id"]."'> ".$dados["id"]." </a></td>
                    <td>".$dados["nome"]."</td>
                    <td>".$dados["email"]."</td>
                    <td>".$dados["ativo"]."</td>
                </tr>";

    }
    session_start();
    $_SESSION['html'] = $html;
    echo "<script>location.href = './pesquisar.php'</script>";

}

