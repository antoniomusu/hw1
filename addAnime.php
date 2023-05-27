<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['animeID'])){
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        $query = "SELECT * FROM savedanime where username = ? AND animeID = ?";
        //Chiedo risposta al database e faccio l'escape dei dati
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION["username"], $_GET["animeID"]]) or die("Errore: ".mysqli_error($conn));
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            //Se c'è elimino
            $delete = "DELETE FROM SAVEDANIME WHERE username=? and animeID=?";
            //Chiedo risposta al database e faccio l'escape dei dati
            $stmt = $conn->prepare($delete);
            $stmt->execute([$_SESSION["username"], $_GET["animeID"]]) or die("Errore: ".mysqli_error($conn));
        }else{
            $add = "INSERT INTO SAVEDANIME(username, animeID, image, title) VALUES(?,?,?,?)";
            //Chiedo risposta al database e faccio l'escape dei dati
            $stmt = $conn->prepare($add);
            $stmt->execute([$_SESSION["username"], $_GET["animeID"], $_GET["image"],$_GET["title"]]) or die("Errore: ".mysqli_error($conn));
        }
        mysqli_close($conn);
    }
?>