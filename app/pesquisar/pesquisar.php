<?php

session_start();
//Verificando usuário logado
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){

    header("Location: ../login/login.php");

}

include_once('pesquisar.html');

if(!empty($_SESSION['html'])){
    
    echo '<div class="container">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Ativo</th>
                </tr>
            </thead>
            <tbody>';

    echo $_SESSION['html'];

    echo '</tbody>
        </table>
    </div>';

    $_SESSION['html'] = "";

}