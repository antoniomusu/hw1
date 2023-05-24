<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
    $query = "SELECT * FROM user where username = ?";
    //Chiedo risposta al database e faccio l'escape dei dati
    $stmt = $conn->prepare($query);
    $stmt->execute([$_GET["username"]]) or die("Errore: ".mysqli_error($conn));
    $res = $stmt->get_result();
    if($res->num_rows > 0){
        while ($row = mysqli_fetch_assoc($res)) {
            $mail = $row['mail'];
            $dataNascita = $row['dataNascita'];
            $avatar = $row['avatar'];
            $bio = $row['BIO'];
        }
    }else
    {
        header("Location: home.php");
    }
    
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homework.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="homework.js" defer="true"></script>
    <script src="profile.js" defer="true"></script>
    <title>profile</title>
</head>
<body>
    <?php include "components/navbar.php";?>
  
    <div id="logo">
        <img src= 
        <?php 
            echo $avatar; 
            if($_GET['username'] == $_SESSION['username'])
            echo " id='profileImage'";
        ?>>
    </div>

    <div class ="content">
        <div id= "change-image" class="hidden"></div>
        <?php 
            echo "<p>Username: ".$_GET["username"]." </p>";
            echo "<p>Email: $mail</p>";
            echo "<p>Data di nascita: $dataNascita </p>";
            if($_GET['username'] == $_SESSION['username']){
                echo "<form>  
                        <textarea id ='bio' name='bio'>$bio</textarea></br>
                        <button>Modifica Bio</button>
                    </form>";
            }
            else
                echo "<p id='bio'> $bio </p>";
        ?>
        <h1>Anime Salvati</h1>
        <div id="container">
        </div>
    </div>

    <?php 
        include "components/logout.php";
        include "components/footer.php"; 
    ?>

</body>
</html>