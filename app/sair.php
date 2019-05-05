<?php
    //Iniciando sessão
    session_start();

    //Destruindo a sessão
    session_destroy();
    header("Location: login/login.php");