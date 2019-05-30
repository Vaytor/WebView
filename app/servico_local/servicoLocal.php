<?php

session_start();
//Verificando usuário logado
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){

    header("Location: ../login/login.php");

}

include_once('servicoLocal.html');

if(!empty($_SESSION['html2'])){
    
    echo '<div class="container">
        <table class="table" style="text-align: center">
            <thead>
                <tr>
                <th scope="col" style="text-align: center" colspan="2">Treinador</th>
                </tr>
            </thead>
            <tbody>';

    echo $_SESSION['html2'];

    echo '</tbody>
        </table> 
    </div>';

    $_SESSION['html2'] = "";

}