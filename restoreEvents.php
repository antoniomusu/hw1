<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    $result=array();
    $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
    $query= "SELECT TIME(date) as time, animeID, title, type FROM EVENT WHERE user= ? and DATE(date) > DATE_SUB(current_date(), interval 1 day) order by time desc";
    //Chiedo risposta al database e faccio l'escape dei dati
    $stmt = $conn->prepare($query);
    $stmt->execute([$_SESSION["username"]]) or die("Errore: ".mysqli_error($conn));
    $res = $stmt->get_result();
    while ($row = mysqli_fetch_assoc($res)) {
        $result[]=$row;
    }
    mysqli_close($conn);
    echo json_encode($result);
    
?>