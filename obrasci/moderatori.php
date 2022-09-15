<?php
error_reporting(E_ERROR);
    require '../sesija.class.php';

    Sesija::kreirajSesiju();

    if ($_SESSION['uloga'] < 4) {
        header('Location: ../logout.php');
    }

?>

<!DOCTYPE html>

<html lang="hr">
    <head>
        <title>Dizajn</title>
        <link rel="stylesheet" type="text/css" href="../css/vgoles.css">
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
        <script type="text/javascript" src="../jquery/dataTables.js"></script>

    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="../index.php"><img id="logo" 
                    src="../materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Moderatori
                </a>

                <a href="#meni" class="material-icons"
                 style="font-size: inherit;">menu</a>

                <ul id="meni">
                    <?php 
                        include '../meni.php';
                    ?> 
                </ul>
            </div>
        </header>

      <div class="container">
        <p class="upute">Dodjela moderatora</p>
        <button onclick="window.print(); return false;">Ispis</button>
        <div class="info">
            <?php

                $id = $_GET['id'];
                $korime = $_GET['korime'];
                $opcija = $_GET['opcija'];
                $admin = $_SESSION['korisnik'];

                print "
                    <table id='tablica'>
                        <thead>
                            <tr>
                                <th>ID korisnika</th>
                                <th>Username</th>
                                <th>ID pumpe</th>
                                <th>Moderira</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                require '../baza.class.php';
                $veza = new Baza();
                $veza->spojiDB();

                $sql = "SELECT * FROM `Korisnik` LEFT JOIN Pumpa on Pumpa_idPumpa = idPumpa";

                $odg = $veza->selectDB($sql);

                while ($red = $odg->fetch_assoc()) {
                    print "<tr>";
                    print "<td>" . $red['idKorisnik'] . "</td>";
                    print "<td>" . $red['username'] . "</td>";
                    print "<td>" . $red['idPumpa'] . "</td>";
                    print "<td>" . $red['naziv'] . "</td>";

                    print "</tr>"; 
                }

                echo "</table>";


                $vrijeme = date("Y-m-d H:i:s");
                $admin = $_SESSION['korisnik'];
                $log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
                    VALUES (
                    '$admin',
                    'Izmjena moderatora',
                    '$vrijeme'
                )";

                $dodjeli = "UPDATE Korisnik SET Pumpa_idPumpa = '$id', TipKorisnika_IdTipKorisnika = 3 WHERE username = '$korime'";
                $obrisi = "UPDATE Korisnik SET Pumpa_idPumpa = NULL, TipKorisnika_IdTipKorisnika = 2 WHERE username = '$korime'";

                if (isset($_GET['submit'])) {
                    if ($opcija == 'dodjeli') {
                        $veza->updateDB($dodjeli);
                        $veza->updateDB($log);
                        header( "refresh:1;url=moderatori.php" );
                    } elseif ($opcija == 'obrisi') {
                        $veza->updateDB($obrisi);
                        $veza->updateDB($log);
                        header( "refresh:1;url=moderatori.php" );
                    }
                }
            ?>
        </div>
        <div class="forma">

            <form name="lokacije" id="forma" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <select name="opcija" id="opcija" class="id" onchange="fja2()" style="margin-bottom: 20px;">
                  <option value="dodjeli">Dodjeli</option>
                  <option value="obrisi">Obriši</option>
                </select> <br>

                <label for="korime">Korisničko ime</label>
                <input id="korime" class="txtBox" name="korime" type="txtBox" placeholder="Unesite korisničko ime"/><br>

                <div id="azuriranje2">
                    <label for="id">ID Pumpa</label>
                    <input id="id" class="txtBox" name="id" type="number" placeholder="Unesite ID pumpe"/><br>
                </div>

            </form>


            <input name="submit" class="gumb" type="submit" value="Ažuriraj" form="forma"/>
        </div>


            <input name="submit" class="gumb" type="submit" value="Ažuriraj" form="forma"/>
        </div>
      </div>
      <script type="text/javascript" src="../js/vgoles.js"></script>

        <footer>
            <div class="validator">
                <a href="https://validator.w3.org/nu/?showsource=yes&doc=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2021%2Fzadaca_01%2Fvgoles%2Fobrasci%2Fobrazac.php"> 
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