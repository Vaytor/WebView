<?php

include_once('../conexao.php');

$obj_db = new db();
//Realizando a conexão
$mysqli = $obj_db->conec_mysql();

//Verificando se já existe uma conta criada com esse email
$query = "select * from seg_usuarios";
//Realizado o select no banco 
$result = $mysqli->query($query);

while($dados = mysqli_fetch_assoc($result)) {
  
  if($dados["ativo"] == 1){
    $dados["ativo"] = "Sim";
  }else{
    $dados["ativo"] = "Não";
  }

  echo "<tr>
          <td scope='col'><a href='../editarUsuario/editarUsuario.php?idUser=".$dados["id"]."'>Editar</a></td>
          <td scope='col'>".$dados["nome"]."</td>
          <td scope='col'>".$dados["ativo"]."</td>
        </tr>";

}