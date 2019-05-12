<?php

session_start();
//Verificando usuário logado
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){

    header("Location: ../login/login.php");

}

include_once('editarUsuario.html');

include_once('editarUsuarioControl.php');

include_once('editarUsuario_bottom.html');