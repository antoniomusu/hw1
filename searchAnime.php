<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['anime'])){
        $dati = array("q" => $_GET['anime']);
        $dati = http_build_query($dati);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://api.jikan.moe/v4/anime?sfw&".$dati."&limit=12");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        $result = json_decode($result);
        curl_close($curl);
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="homework.js" defer="true"></script>
    <script src="searchAnime.js" defer="true"></script>
    <title>searchAnime</title>
</head>
<body>
    
<?php include "components/navbar.php";?>

    <div class ="content">
        <h1>Risultati per <?php echo $_GET['anime'];?>:</h1>
        <div id=container>
        <?php
            if(count($result->data)>0){
                foreach($result->data as $data){
                    echo "<div id=".$data->mal_id.">
                        <img src=".$data->images->jpg->image_url.">
                        <h3>$data->title</h3>
                    </div>";
                }
            }else{
                echo "<h1>Nessun risultato trovato!</h1>";
            }
        ?>
        </div>
        
    </div>
        <?php 
            include "components/logout.php";
            include "components/footer.php"; 
        ?>
</body>
</html>