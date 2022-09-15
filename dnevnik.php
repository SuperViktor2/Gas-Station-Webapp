<?php
error_reporting(E_ERROR);
    require 'sesija.class.php';
    Sesija::kreirajSesiju();

    if ($_SESSION['uloga'] < 4) {
        header('Location: logout.php');
    }
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

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="jquery/dataTables.js"></script>


        <style>
            @media print {
                header, footer {
                    display: none;
                }
            }
        </style>
    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="index.php"><img id="logo" 
                    src="materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Dnevnik
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
        <button onclick="window.print(); return false;">Ispis</button>
        <div class="info">

            <?php

                print "
                    <table id='tablica'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Korisnik</th>
                                <th>Aktivnost</th>
                                <th>Datum i vrijeme</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                require 'baza.class.php';
                $veza = new Baza();
                $veza->spojiDB();

                $sql = "SELECT * FROM Dnevnik";
                $odg = $veza->selectDB($sql);

                while ($red = $odg->fetch_assoc()) {
                    print "<tr>";
                    print "<td>" . $red['idDnevnik'] . "</td>";
                    print "<td>" . $red['korisnik'] . "</td>";
                    print "<td>" . $red['akcija'] . "</td>";
                    print "<td>" . $red['vrijeme'] . "</td>";
                    print "</tr>"; 
                }

                echo "</table>";
            ?>
        </div>
      </div>

        <footer>

            <div class="validator">
                <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2021%2Fzadaca_01%2Fvgoles%2Fpopis.php#textarea"> 
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