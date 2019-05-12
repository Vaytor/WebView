<?php

if(!empty($_POST['pesquisa'])){

    //Possível nome do pokemon
    $nomePoke = $_POST['pesquisa'];
    
    //Url do JSON + nome pokemon
    $url = "https://pokeapi.co/api/v2/pokemon/".strtolower($nomePoke)."/";
    $pokemons = json_decode(file_get_contents($url));
   
    //Retornou dados
    if(!empty($pokemons->name)){
        
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
        $html .= "<tbody> </table>";

        session_start();
        $_SESSION['html'] = $html;
        echo "<script>location.href = './webservice.php'</script>";
        
    }else{

        echo "<script>alert('Pokémon não encontrado.')</script>";
        //echo "<script>location.href = './webservice.php'</script>";

    }
    

}else{
    echo "<script>alert('Digite o nome do pokémon!')</script>";
    echo "<script>location.href = './webservice.php'</script>";
}

