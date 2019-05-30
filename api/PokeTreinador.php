<?php

if(isset($_GET['id'])){
    include_once('../app/conexao.php');

    $obj_db = new db();
    //Realizando a conexão
    $mysqli = $obj_db->conec_mysql();

    $id_poke = $_GET['id'];
    //Verificando se já existe uma conta criada com esse email
    $query = "SELECT id, nome, email FROM seg_usuarios WHERE id=$id_poke";

    //Realizado o select no banco 
    $result = $mysqli->query($query);

    if($result->num_rows > 0){

        $dados = mysqli_fetch_assoc($result);

        $id = $dados['id'];
        $nome = $dados['nome'];
        $email = $dados['email'];

        //Verificando se já existe uma conta criada com esse email
        $query = "SELECT idPokedex, nomePokemon, move1, move2, move3, move4, lvPokemon
        FROM poke_treinador WHERE id_treinador = $id";

        //Realizado o select no banco 
        $result = $mysqli->query($query);
        $dados = mysqli_fetch_assoc($result);
        $pokemons = array(
                    
                    );

        while($dados = mysqli_fetch_assoc($result)) {

            array_push($pokemons, array(
                    'Pokedex' => $dados['idPokedex'],
                    'Pokemon' => $dados['nomePokemon'],
                    'LvPokemon' => $dados['lvPokemon'],
                    'Movimentos' => array(
                        'Movimento 1' => $dados['move1'],
                        'Movimento 2' => $dados['move2'],
                        'Movimento 3' => $dados['move3'],
                        'Movimento 4' => $dados['move4']
                    )
                )
            );
        }

        
        $treinador = array(
            'nome' => $nome,
            'email' => $email,
            'Pokemons' => $pokemons
        );
        
        $jsonPoke = json_encode($treinador);

        echo $jsonPoke;

    }else{
        die('Treinador não encontrado.');
    }

}