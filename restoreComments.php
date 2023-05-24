<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    $result=array();
    if(isset($_GET['animeID'])){
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
            $query = "SELECT comment, user, avatar, date FROM COMMENTS JOIN USER on user=username WHERE animeID = ?";
            //Chiedo risposta al database e faccio l'escape dei dati
            $stmt = $conn->prepare($query);
            $stmt->execute([$_GET["animeID"]]) or die("Errore: ".mysqli_error($conn));
            $res = $stmt->get_result();
            while ($row = mysqli_fetch_assoc($res)) {
                $result[]=$row;
            }
            mysqli_close($conn);
            echo json_encode($result);
    }
?>