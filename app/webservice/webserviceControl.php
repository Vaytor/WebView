<?php

if(!empty($_POST['pesquisa'])){

    //Possível nome do pokemon
    $nomePoke = $_POST['pesquisa'];
    
    //Url do JSON + nome pokemon
    $url = "https://pokeapi.co/api/v2/pokemon/".strtolower($nomePoke)."/";
    
    $headers = get_headers($url);
    $status = substr($headers[0], 9, 3);
    
    if ($status == '200') {
        
        $pokemons = json_decode(file_get_contents($url));
        $html = "";

        $html .= "<tr><td colspan='2'>Nº Pokédex: ".$pokemons->id."</td></tr>";
        $html .= "<tr><td colspan='2'>Nome: ".strtoupper($pokemons->name)."</td></tr>";
        $html .= "<tr><td><img src='".$pokemons->sprites->front_default."' alt='img'></td><td><img src='".$pokemons->sprites->back_default."' alt='img'></td></tr>";
        $html .= "<table class='table'> <thead><tr><th scope='col' style='text-align: center'>Habilidades</th></tr></thead>";
        $html .= "<tbody>";
        $count = 0;
        foreach ($pokemons->moves as $movimento){

            if($count > 3){
                break;
            }

            $movimento = strtoupper($movimento->move->name);
            $movimento = str_replace("-", " ", $movimento);
            $html .= "<tr><td>$movimento</td></tr>";
            $count++;
        }
        $html .= "<tbody></table> <div style='text-align: center'><a href='./webserviceControl.php?idPodex=$pokemons->id' class='btn btn-primary'>Capturar</a> </div>";

        session_start();
        $_SESSION['html'] = $html;
        echo "<script>location.href = './webservice.php'</script>";
        
    }else{

        echo "<script>alert('Pokémon não encontrado.')</script>";
        echo "<script>location.href = './webservice.php'</script>";

    }
    

}elseif(!empty($_GET['idPodex'])){

    session_start();

    include_once('../conexao.php');

    $url = "https://pokeapi.co/api/v2/pokemon/".strtolower($_GET['idPodex'])."/";

    $pokemons = json_decode(file_get_contents($url));

    //Verificando se o usuário tem mais de 6 pokemons
    $sql_poke = "SELECT id FROM poke_treinador WHERE id_treinador = ".$_SESSION['user_id'];

    $obj_db = new db();
    //Realizando a conexão
    $mysqli = $obj_db->conec_mysql();

    $result = $mysqli->query($sql_poke);

    if(!$result){
        die("Erro: ".$mysqli->error);
    }

    if($result->num_rows >= 6){

        echo "<script>alert('Você já possui 6 pokemons!')</script>";
        echo "<script>location.href = './webservice.php'</script>";

    }else{
        
        if(!empty($pokemons->moves[0]->move->name)){
            $move1 = $pokemons->moves[0]->move->name;
        }else{
            $move1 = "";
        }
        
        if(!empty($pokemons->moves[1]->move->name)){
            $move2 = $pokemons->moves[1]->move->name;
        }else{
            $move2 = "";
        }

        if(!empty($pokemons->moves[2]->move->name)){
            $move3 = $pokemons->moves[2]->move->name;
        }else{
            $move3 = "";
        }

        if(!empty($pokemons->moves[3]->move->name)){
            $move4 = $pokemons->moves[3]->move->name;
        }else{
            $move4 = "";
        }
        
        $lvPoke = rand(1, 100);

        $insert_poke = "INSERT INTO poke_treinador(id_treinador, idPokedex, nomePokemon, move1, move2, move3, 
        move4, lvPokemon) VALUES(".$_SESSION['user_id'].", ".$pokemons->id.", '".$pokemons->name."', 
        '".$move1."', '".$move2."', '".$move3."', '".$move4."', $lvPoke)";

        if($result = $mysqli->query($insert_poke)){
            echo "<script>alert('Pokemon capturado com sucesso!')</script>";
            echo "<script>location.href = './webservice.php'</script>";
        }else{
            die("Erro: ".$mysqli->error);
        }
    }
}else{
    echo "<script>alert('Digite o nome do pokémon!')</script>";
    echo "<script>location.href = './webservice.php'</script>";
}
