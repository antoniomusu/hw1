<?php
    //avvia la sessione
    session_start();
    //Verifica di login
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homework.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="homework.js" defer="true"></script>
    <script src="home.js" defer="true"></script>
    <title>home</title>
</head>
<body>
    
    <?php include "components/navbar.php";?>

    <div class ="content">
        <?php
            echo "<h1> Benvenuto ".$_SESSION['username']. "!</h1>";   
        ?>
        <div>Le tue attività giornaliere:</div>
    </div>
    <?php 
        include "components/logout.php";
        include "components/footer.php"; 
    ?>

</body>
</html>