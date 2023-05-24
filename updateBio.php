<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    //$data = json_decode(file_get_contents('php://input'), true);  
    if(isset($_POST["bio"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        $add = "UPDATE user SET BIO = ? where username = ?";
        $stmt = $conn->prepare($add);
        $stmt->execute([$_POST['bio'], $_SESSION['username']]) or die("Errore: ".$conn->error);
        mysqli_close($conn);
    }
?>