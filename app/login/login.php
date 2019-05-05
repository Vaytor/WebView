<?php

session_start();
//Verificando usuário logado
if(isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])){

    header("Location: ../home/home.php");

}

include_once('login.html');