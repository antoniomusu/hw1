<?php 
    session_start();
    $error = array();
    if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["mail"]) && !empty($_POST["dataNascita"])){
        //connetto al database
        $conn = mysqli_connect("localhost", "root", "", "homework" ) or die("Errore: ".mysqli_connect_error());
        
        //#USERNAME
        //Assegnamento dell'input
        $username = $_POST["username"];
        $query = "SELECT username FROM user WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]) or die("Errore: ".$conn->error);
        $res = $stmt->get_result();
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        #PASSWORD
        $password = $_POST["password"];
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if(!$uppercase||!$lowercase||!$number ||strlen($password) < 8)
            $error[] = "Password non conforme";
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
 
        //#EMAIL
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
            $error[] = "Email non valida";
        }else{
            $email = strtolower($_POST["mail"]);
            //Preparo stringa con query
            $query = "SELECT * FROM user where mail = ?";
            //Chiedo risposta al database con escape
            $stmt = $conn->prepare($query);
            $stmt->execute([$email]) or die("Errore: ".$conn->error);
            $res = $stmt->get_result();
            //Verifico la presenza delle credenziali
            if($res->num_rows > 0){ 
                $error[] = "Email già in uso";
            
            }
        }
        if(count($error) == 0){
            $sql = "INSERT INTO user VALUES(?, ?, ?, ?, default, default)";
            $stmt ->prepare($sql);
            $stmt->execute([ $username, $password, $_POST["dataNascita"], $email]) or die("Errore ". $conn->error);
            $entryFlag= true;
        }
        mysqli_close($conn);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homework.css">
    <link rel="stylesheet" href="entry.css">
    <script src="entry.js" defer="true"></script>
    <title>login</title>
</head>
<body <?php if(isset($entryFlag)) echo "class='no-scroll'"?>>
   
    <div id="login_flex">
        <?php foreach($error as $err)
            echo "<p id='error'>$err</p>"
        ?>  
        <form name = "registration_form" method = 'post' class = "data" autocomplete="off" >
           
            <p>
                <label>Username <input type = 'text' name ="username" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?> ></label>
            </p>
            <p>
                <label>Password <input type = 'password' name ="password"></label>
            </p>
            <p>
                <label>Email <input type = 'email' placeholder="example123@gmail.com" name ="mail"<?php if(isset($_POST["mail"])){echo "value=".$_POST["mail"];} ?>></label>
            </p>
            <p>
                <label>Conferma Password <input type = 'password' name ="cpassword"></label>
            </p>    
            <p>
                <label>Data di nascita <input type="date" name="dataNascita" min="1900-01-01" max="2010-01-01"<?php if(isset($_POST["dataNascita"])){echo "value=".$_POST["dataNascita"];} ?>></label>
            </p>
            <p>    
                <input type="submit" value="Registrati">
            </p>
            <a href="login.php">Hai già un account?</a>
        </form>
        <div id="message" class = "hidden">
            <h3>La Password deve contenere:</h3>
            <p id="letter" class="invalid"><b>Almeno una lettera minuscola</b></p>
            <p id="capital" class="invalid"> <b>Almeno una lettera maiuscola</b></p>
            <p id="number" class="invalid"><b>Almeno un numero</b></p>
            <p id="length" class="invalid"><b>Minimo 8 caratteri</b></p>
        </div>
    </div>
    <div id='modal-logout' <?php if(!isset($entryFlag)) echo "class = 'hidden'"?>>
            <img src='images/entry.png' class='waifu-img'>
            <div>
                <p>Registrazione effettuata con successo!</p>
                <button>Okay</button>
            </div>
    </div>
    <?php 
        include "components/footer.php"; 
    ?>

</body>
</html>