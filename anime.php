<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['animeID'])){
        //Curl per dati dell'anime
        $dati = array("id" => $_GET['animeID']);
        $dati = http_build_query($dati);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://api.jikan.moe/v4/anime/".$_GET["animeID"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        $result = json_decode($result);
        curl_close($curl);
        //Verifico se è tra i salvati
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        $query = "SELECT * FROM savedanime where username = ? and animeid = ?";
        //Chiedo risposta al database e faccio l'escape dei dati
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION["username"],$_GET["animeID"]]) or die("Errore: ".mysqli_error($conn));
        $res = $stmt->get_result();
        if($res->num_rows>0) {
          $saved = true;  
        }
        mysqli_close($conn);
    }else{
        header("Location: home.php");
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
    <link rel="stylesheet" href="anime.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="homework.js" defer="true"></script>
    <script src="anime.js" defer="true"></script>
    <title><?php echo $result->data->title?></title>
</head>
<body>
    
    <?php include "components/navbar.php";?>

    <div id = "title">
        <div>
            <img id = "animeImage" src= <?php echo $result->data->images->jpg->image_url;?>>
        </div>
        <div id = "description">
            <div 
                <?php if(isset($saved)) 
                    echo "class='filled flexbox'";
                else
                    echo "class='unfilled flexbox'"; ?>>
                <span id = "name"><?php echo $result->data->title?></span>
                <span id = "like" class="material-symbols-outlined">favorite</span>
            </div>
            <div><?php echo $result->data->synopsis?></div>
        </div>
    </div>
    <section id= "anime-content">
        <div id= "information">
            <div>Tipo: <?php echo $result->data->type?></div>
            <div>Numero episodi: <?php echo $result->data->episodes?></div>
            <div>Anno di produzione: <?php echo $result->data->year?></div>
            <div>Tempo di uscita: <?php echo $result->data->aired->string?></div>
            <div>Studio di produzione: <?php echo $result->data->studios[0]->name?></div>
            <div>Produttori:
                <?php
                    foreach($result->data->producers as $producer) 
                        echo "$producer->name/"
                ?>
            </div>
            <div>Generi:
                <?php
                    foreach($result->data->genres as $genre) 
                        echo "$genre->name/"
                ?>
            </div>
        </div>
        <form id ="commentForm" name="comment">
            <p>Inserisci un commento qui:</p>
            <textarea name="comment" required></textarea>
            <input type="submit" value="Aggiungi il commento">
        </form>
        <div id="comments"></div>
    </section>
    
    <?php 
        include "components/logout.php";
        include "components/footer.php"; 
    ?>

</body>
</html>