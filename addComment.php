<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_POST['animeID']) && isset($_POST['comment'])){
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        $add = "INSERT INTO COMMENTS(user, animeID, comment, date, title) VALUES(?,?,?, default, ?)";
        //Chiedo risposta al database e faccio l'escape dei dati
        $stmt = $conn->prepare($add);
        $stmt->execute([$_SESSION["username"], $_POST["animeID"], $_POST["comment"], $_POST["title"]]) or die("Errore: ".mysqli_error($conn));
        mysqli_close($conn);
    }
?>