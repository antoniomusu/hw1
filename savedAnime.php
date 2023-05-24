<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET["username"])){
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        $result = array();
        $query = "SELECT * FROM savedanime where username = ?";
        //Chiedo risposta al database e faccio l'escape dei dati
        $stmt = $conn->prepare($query);
        $stmt->execute([$_GET["username"]]) or die("Errore: ".mysqli_error($conn));
        $res = $stmt->get_result();
        while ($row = mysqli_fetch_assoc($res)) {
            $result[]=$row;
        }
        mysqli_close($conn);
        echo json_encode($result);
    }
?>