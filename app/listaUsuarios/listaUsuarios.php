<?php

session_start();
//Verificando usuário logado
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){

    header("Location: ../login/login.php");

}

include_once('listaUsuarios_header.html');

include_once('listaUsuariosControl.php');

include_once('listaUsuarios_bottom.html');