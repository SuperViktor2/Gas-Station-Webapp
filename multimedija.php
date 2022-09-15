<?php
error_reporting(E_ERROR);
    require 'sesija.class.php';
    Sesija::kreirajSesiju();
?>
<!DOCTYPE html>

<html lang="hr">
    <head>
        <title>Dizajn</title>
        <link rel="stylesheet" type="text/css" href="css/vgoles.css">
        <!-- link za navigation icon -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 

        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="author" content="Viktor Goleš">
        <meta name="title" content="Dizajn">
        <meta name="description" content="Zadaca 1, 17.3.2021.">
        <meta name="keywords" content="FOI, HTML, CSS, Dizajn">

    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="index.php"><img id="logo" 
                    src="materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Multimedija
                </a>

                <a href="#meni" class="material-icons"
                 style="font-size: inherit;">menu</a>

                <ul id="meni">
                    <?php 
                        include 'meni.php';
                    ?> 
                </ul>
            </div>
        </header>

    <div class="container">
        <div class="categories">
          <input type = "button" onclick = "showAll()" value = "Svi">  
          <input type = "button" onclick = "sport()" value = "Sportski">
          <input type = "button" onclick = "fja()" value = "Obiteljski">
          <input type = "button" onclick = "fja()" value = "Oldtimeri">
        </div>

        <div class="multimedija">

            <div class="auto sport">
                <h1>Auto 1</h1>
                <img src="materijali/auto1.jpeg">
            </div>
            
            <div class="auto sport">
                <h1>Auto 2</h1>
                <img src="materijali/auto2.jpeg">
            </div>

            <div class="auto old">
                <h1>Auto 3</h1>
                <img src="materijali/auto3.jpeg">
            </div>

            <div class="auto obiteljski">
                <h1>Auto 4</h1>
                <img src="materijali/auto4.jpeg">
            </div>

            <div class="auto obiteljski">
                <h1>Auto 5</h1>
                <img src="materijali/auto5.jpeg">
            </div>

            <div id="auto obiteljski">
                <h1>Auto 6</h1>
                <img src="materijali/auto6.jpeg">
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/vgoles.js"></script>

        <footer>

            <div class="validator">
                <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2021%2Fzadaca_01%2Fvgoles%2Fmultimedija.php#textarea"> 
                    <img alt="HTML5 logo" src="https://barka.foi.hr/WebDiP/2021/materijali/zadace/HTML5.png" width="50" />
                </a>
            </div>            

            <p id="copyright">&copy; 2021 
                <a href="mailto:viktor.goles@gmail.com" class="author">
                Viktor Goleš
                </a>
            </p>

            <div class="validator">
                <a href="https://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2021%2Fzadaca_01%2Fvgoles%2Findex.php&profile=css3svg&usermedium=all&warning=1&vextwarning=&lang=en"> 
                    <img alt="CSS3 logo" src="http://barka.foi.hr/WebDiP/2021/materijali/zadace/CSS3.png" width="56" />
                </a>
            </div>
        </footer>
    </body>
</html>