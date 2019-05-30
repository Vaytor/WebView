<?php

if(!empty($_POST['pesquisa'])){

    //Possível nome do pokemon
    $nomePoke = $_POST['pesquisa'];
    
    //Url do JSON + nome pokemon
    $url = "https://victor4hs.000webhostapp.com/ProjetoMobile/api/PokeTreinador.php?id=".strtolower($nomePoke);
    
    $headers = get_headers($url);
    $status = substr($headers[0], 9, 3);
    if ($status == '200') {
        
        $pokemons = json_decode(file_get_contents($url));

        $html = "";
        
        $html .= "<tr><td colspan='2'>Nome Treinador: ".strtoupper($pokemons->nome)."</td></tr>";
        $html .= "<tr><td colspan='2'>Email Treinador: ".$pokemons->email."</td></tr>";
        
        foreach ($pokemons->Pokemons as $pokemon){
            $html .= "<table class='table'> <thead><tr><th scope='col' style='text-align: center'>Pokémon</th></tr></thead>";
            $html .= "<tr><td colspan='2'>Nº Pokédex: ".$pokemon->Pokedex."</td></tr>";
            $html .= "<tr><td colspan='2'>Nome: ".strtoupper($pokemon->Pokemon)."</td></tr>";
            $html .= "<tr><td colspan='2'>Lv: ".$pokemon->LvPokemon."</td></tr>";
            $html .= "<table class='table'> <thead><tr><th scope='col' style='text-align: center'>Habilidades</th></tr></thead>";
            $html .= "<tbody>";
            $count = 0;
            
            foreach ($pokemon->Movimentos as $movimento){

                if($count > 3){
                    break;
                }

                $movimento = strtoupper($movimento);
                $movimento = str_replace("-", " ", $movimento);
                $html .= "<tr><td>$movimento</td></tr>";
                $count++;
            }

        }
        $html .= "<tbody></table>";

        session_start();
        $_SESSION['html2'] = $html;
        echo "<script>location.href = './servicoLocal.php'</script>";
    }
    

}else{
    echo "<script>alert('Digite o nome do pokémon!')</script>";
    echo "<script>location.href = './servicoLocal.php'</script>";
}
