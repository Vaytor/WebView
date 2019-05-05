<?php

class db{
    //Definindo dados de conexão
    private $server = "127.0.0.1";
    
    private $user = "root"; 
    
    private $senha = "";
    
    private $database = "projeto_mobile";

    public function conec_mysql(){
        
        //Conexão sendo criada
        $mysqli = mysqli_connect($this->server, $this->user, $this->senha, $this->database);
        //Verificando se ocorreu erro ao criar a conexão
        if(!$mysqli){
            die("Erro: ".$mysqli->error());  
        }
        //Retornando a conexão
        return $mysqli;
    }
}
