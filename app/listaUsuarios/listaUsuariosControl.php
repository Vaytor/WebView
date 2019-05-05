<?php

include_once('../conexao.php');

$obj_db = new db();
//Realizando a conexão
$mysqli = $obj_db->conec_mysql();

//Verificando se já existe uma conta criada com esse email
$query = "select * from seg_usuarios where id = ".$_SESSION['user_id'];
//Realizado o select no banco 
$result = $mysqli->query($query);
$count = 1;
while($dados = mysqli_fetch_assoc($result)) {
    
    echo "<tr>
            <th scope='row'>".$count."</th>
            <td>".$dados["nome"]."</td>
            <td>".$dados["ativo"]."</td>
          </tr>";
    $count++;
}
        