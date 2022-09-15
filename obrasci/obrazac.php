<?php
error_reporting(E_ERROR);
    // require '../baza.class.php';
    require '../sesija.class.php';

    Sesija::kreirajSesiju();

    if ($_SESSION['uloga'] == NULL) {
        header('Location: prijava.php');
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
                    Obrazac
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
        <p class="upute">Dodavanje/Ažuriranje vozila</p>
        <button onclick="window.print(); return false;">Ispis</button>
        
        <div class="info">
            <?php

                $id = $_GET['id'];
                $registracija = $_GET['registracija'];
                $marka = $_GET['marka'];
                $model = $_GET['model'];
                $brojac = $_GET['kilometri'];
                $slika = $_GET['slika'];
                $sifra = $_SESSION['id'];
                $opcija = $_GET['opcija'];

                // $filename = $_FILES["uploadfile"]["name"];
                // $tempname = $_FILES["uploadfile"]["tmp_name"];
                // $folder = "./image/" . $filename;

                print "
                    <table id='tablica'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Registracija</th>
                                <th>Marka</th>
                                <th>Model</th>
                                <th>Brojac</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                require '../baza.class.php';
                $veza = new Baza();
                $veza->spojiDB();

                $sql = "SELECT * FROM Vozilo where Korisnik_idKorisnik = '$sifra'";
                $odg = $veza->selectDB($sql);

                while ($red = $odg->fetch_assoc()) {
                    print "<tr>";
                    print "<td>" . $red['idvozilo'] . "</td>";
                    print "<td>" . $red['registracija'] . "</td>";
                    print "<td>" . $red['marka'] . "</td>";
                    print "<td>" . $red['model'] . "</td>";
                    print "<td>" . $red['brojac'] . "</td>";
                    print "</tr>"; 
                }

                echo "</table>";

                $insert = "INSERT INTO Vozilo (registracija, marka, model, brojac, slika, Korisnik_idKorisnik)
                        VALUES (
                        '$registracija',
                        '$marka',
                        '$model',
                        '$brojac',
                        '$slika',
                        '$sifra'
                    )";
                $update = "UPDATE Vozilo SET registracija = '$registracija', marka = '$marka', model = '$model', brojac = '$brojac', slika = '$slika' WHERE idvozilo = '$id'";

                $vrijeme = date("Y-m-d H:i:s");
                $korime = $_SESSION['korisnik'];
                $log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
                    VALUES (
                    '$korime',
                    'Unos vozila',
                    '$vrijeme'
                )";

                if (isset($_GET['submit'])) {
                    if ($opcija == 'upload') {
                        $veza->updateDB($insert);
                        $veza->updateDB($log);

                        header("Location: obrazac.php");
                    } elseif ($opcija == 'azuriraj') {
                        $veza->updateDB($update);
                        $veza->updateDB($log);

                    }
                }
            ?>
        </div>
        <div class="forma">
            <form name="vozila" id="forma" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <select name="opcija" id="opcija" class="id" onchange="fja()" style="margin-bottom: 20px;">
                  <option value="upload">Upload</option>
                  <option value="azuriraj">Ažuriranje</option>
                </select> <br>

                <div id="azuriranje">
                    <label for="id">ID vozila</label>
                    <input id="id" class="txtBox" name="id" type="number" placeholder="Unesite prijeđene kilometre"/><br>
                </div>

                <label for="registracija">Registracija </label>
                <input id="ime" class="txtBox" name="registracija" type="text" placeholder="Unesite registraciju" autofocus /><br>

                <label for="marka">Marka vozila </label>
                <input id="marka" class="txtBox" name="marka" type="text" placeholder="Unesite marku vozila"/><br>

                <label for="model">Model vozila </label>
                <input id="model" class="txtBox" name="model" type="text" placeholder="Unesite model vozila"/><br>
                    
                <label for="kilometri">Prijeđeni kilometri</label>
                <input id="kilometri" class="txtBox" name="kilometri" type="number" placeholder="Unesite prijeđene kilometre"/><br>

                <label for="uploadfile">Upload slike: </label>
                <input class="form-control" type="file" name="uploadfile" value="" />
            </form>
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