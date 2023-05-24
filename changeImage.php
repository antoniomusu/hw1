<?php
    $img_endpoint = "https://api.waifu.pics/many/sfw/waifu";

    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
        exit;
    }
    
    if(!isset($_GET['avatar'])){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $img_endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,"{}");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($curl);
        curl_close($curl);
        
    }else{
    $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
    $add = "UPDATE user SET avatar = ? where username = ?";
    $stmt = $conn->prepare($add);
    $stmt->execute([$_GET['avatar'], $_SESSION['username']]) or die("Errore: ".$conn->error);
    mysqli_close($conn);
    }
?>