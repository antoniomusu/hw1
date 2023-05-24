<div id="header">
    <div class="overlay">
        <div id="navbar">
            <a class= "logout">Logout</a>
            <?php   
                echo "<a href='profile.php?username=$_SESSION[username]'>Profilo</a>";
            ?>
            <a href="home.php">Home</a>
            <a href="">Contattaci</a>
            <form name = "search" class = "searchbar" action="searchAnime.php" method= "get" autocomplete="off">
                <input type="text" placeholder = "Cerca Anime" name = "anime" required>
                <button type="submit" class="material-symbols-outlined">search</button>
            </form>               
        </div>
        <h1 id="mainName">MYWAIFUHAVEN</h1>
    </div>
    <span id = "menu" class="material-symbols-outlined">menu</span>
</div>
<div id="lateral_bar" class= "hidden">   
        <?php   
            echo "<a href='profile.php?username=$_SESSION[username]'><span class='material-symbols-outlined'>account_circle</span></a>";
        ?>
        <form name = "search" class = "searchbar" action="searchAnime.php" method= "get" autocomplete="off">
                <input type="text" placeholder = "Cerca Anime" name = "anime" required>
                <button type="submit" class="material-symbols-outlined">search</button>
        </form>            
        <a href="home.php"><span class="material-symbols-outlined">home</span></a>
        <a href=""><span class="material-symbols-outlined">settings</span></a>
        <a class= "logout"><span class="material-symbols-outlined">logout</span></a>
    </div>
</div>