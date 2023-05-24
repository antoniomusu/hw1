<?php
    session_start();
    //Elimino la sessione corrente
    session_destroy();
    //Reindirizzo al login
    header("Location: login.php");
    exit;
?>