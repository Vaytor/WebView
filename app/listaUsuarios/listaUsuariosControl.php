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
    
    echo "<tr>
            <th scope='row'><a href='../editarUsuario/editarUsuario.php?idUser=".$dados["id"]."'>Editar</a></th>
            <td>".$dados["nome"]."</td>
            <td>".$dados["ativo"]."</td>
          </tr>";

}