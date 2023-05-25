<?php
    //Avvio la sessione
    session_start();
    $text = "Per accedere ai contenuti devi prima effettuare il login:";
    $source= "images/login.png";
    
    if(isset($SESSION["username"])){
        //Reindirizzo alla home
        header("Location: home.php");
        exit;
    }

    //Verifico l'esistenza di dati POST
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        //connetto al database
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        //Preparo stringa con query
        $query = "SELECT * FROM user where username = ?";
        //Chiedo risposta al database e faccio l'escape dei dati
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]) or die("Errore: ".mysqli_error($conn));
        $res = $stmt->get_result();
        mysqli_close($conn);
        //Verifico la correttezza delle credenziali
        if (mysqli_num_rows($res) > 0) {
            // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
            $user = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $user['password'])){
                //Imposto la variabile di sessione
                $_SESSION["username"] = $_POST["username"];
                //Rimando alla home
                header("Location: home.php");
                exit;
            }
        }
        //Segnalo l'errore
        $error = true;
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homework.css">
    <script src="login.js" defer="true"></script>
    <title>login</title>
</head>
<body>
    
    <div id="login_flex">
        <?php
        if(isset($error)){
            $text = "Ops.. Credenziali errate!"; 
            $source = "images/error.png";
        }
            echo  "<h1>$text</h1>";
            echo  "<img src= $source>";         
        ?>
        <form class = "data" name = "access_form" method = 'post' autocomplete= "off">
            <p>
                <label>Username <input type = 'text' placeholder="User" name ="username"></label>
            </p>
            <p>
                <label>Password <input type = 'password' placeholder="Password" name ="password"></label>
            </p>
            <p>    
                <input type="submit" value="Login">
            </p>
            <a href="">Password dimenticata?</a>
            <a href="entry.php">Non hai ancora un account?</a>
        </form>
    </div>
    <?php 
        include "components/footer.php"; 
    ?>
</body>
</html>