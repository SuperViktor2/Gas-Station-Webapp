<?php
error_reporting(E_ERROR);
    // require '../baza.class.php';
    require '../sesija.class.php';

    Sesija::kreirajSesiju();

    if ($_SESSION['uloga'] < 3) {
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
                    Točionice goriva
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
        <p class="upute">Dodavanje/Ažuriranje točionica</p>

        <button onclick="window.print(); return false;">Ispis</button>
        
        <div class="info">
            <?php
                print "
                    <table id='tablica'>
                        <thead>
                            <tr>
                                <th>ID mjesta</th>
                                <th>Status</th>
                                <th>Gorivo</th>
                                <th>Cijena goriva</th>
                                <th>Kolicia goriva</th>
                                <th>id goriva</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                require '../baza.class.php';
                $veza = new Baza();
                $veza->spojiDB();

                $idKorisnik = $_SESSION['id'];
                $sql2 = "SELECT Pumpa_idPumpa FROM Korisnik WHERE idKorisnik = '$idKorisnik'";
                $odg2 = $veza->selectDB($sql2);

                while ($red2 = $odg2->fetch_assoc()) {
                    $moderira = $red2['Pumpa_idPumpa'];
                }

                $sql = "SELECT m.idMjesto, m.status, vrstaGoriva.Naziv, Gorivo.cijena, Gorivo.kolicina, Gorivo.idGorivo from Pumpa p 
                        LEFT JOIN Mjesto m ON p.idPumpa = m.idPumpa 
                        LEFT JOIN Gorivo on m.idMjesto = Gorivo.idMjesto 
                        LEFT JOIN vrstaGoriva on Gorivo.idvrstaGoriva = vrstaGoriva.idVrste WHERE p.idPumpa = '$moderira'";
                $odg = $veza->selectDB($sql);

                while ($red = $odg->fetch_assoc()) {
                    if ($red['kolicina'] == 0) {
                        print "<tr style='font-weight: bold;'>";
                        print "<td>" . $red['idMjesto'] . "</td>";
                        print "<td>" . $red['status'] . "</td>";
                        print "<td>" . $red['Naziv'] . "</td>";
                        print "<td>" . $red['cijena'] . "</td>";
                        print "<td>" . $red['kolicina'] . "</td>";
                        print "<td>" . $red['idGorivo'] . "</td>";

                        print "</tr>"; 
                    } else {
                        print "<tr>";
                        print "<td>" . $red['idMjesto'] . "</td>";
                        print "<td>" . $red['status'] . "</td>";
                        print "<td>" . $red['Naziv'] . "</td>";
                        print "<td>" . $red['cijena'] . "</td>";
                        print "<td>" . $red['kolicina'] . "</td>";
                        print "<td>" . $red['idGorivo'] . "</td>";

                        print "</tr>";
                    }
                }

                echo "</table>";

                $opcija = $_GET['opcija'];
                $gorivo = $_GET['gorivo'];
                $mjesto = $_GET['mjesto'];
                $cijena = $_GET['cijena'];
                $status = $_GET['status'];
                $kolicina = $_GET['kolicina'];
                $id = $_GET['id'];


                $vrijeme = date("Y-m-d H:i:s");
                $korime = $_SESSION['korisnik'];
                $log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
                    VALUES (
                    '$korime',
                    'Izmjena goriva',
                    '$vrijeme'
                )";

                $insert = "INSERT INTO Gorivo (cijena, idMjesto, idvrstaGoriva, status, kolicina)
                        VALUES (
                        '$cijena',
                        '$mjesto',
                        '$gorivo',
                        '$status',
                        '$kolicina'
                    )";

                $update = "UPDATE Gorivo SET cijena = '$cijena', idMjesto = '$mjesto', idvrstaGoriva = '$gorivo',
                            status = '$status', kolicina = '$kolicina' WHERE idGorivo = '$id'";

                if (isset($_GET['submit'])) {
                    if ($opcija == 'upload') {
                        $veza->updateDB($insert);
                        $veza->updateDB($log);
                        header( "refresh:1;url=dodjela.php" );

                    } elseif ($opcija == 'azuriraj') {
                        $veza->updateDB($update);
                        $veza->updateDB($log);
                        header( "refresh:1;url=dodjela.php" );

                    }
                }
            ?>
        </div>
        <div class="forma">
            <form name="gorivo" id="forma" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php
                    $sql3 = "SELECT * FROM vrstaGoriva";
                    $odg3 = $veza->selectDB($sql3);

                    echo "<ul style='list-style: none; float: left; text-align: left; color: white;'>";
                    while ($red3 = $odg3->fetch_assoc()) {
                        echo "<li>" . $red3['idVrste'] . ', ' . $red3['Naziv'];
                    }
                    echo "</ul>";

                ?>
                <select name="opcija" id="opcija" class="id" onchange="fja()" style="margin-bottom: 20px;">
                  <option value="upload">Upload</option>
                  <option value="azuriraj">Ažuriranje</option>
                </select> <br>

                <div id="azuriranje">
                    <input id="id" class="txtBox" name="id" type="number" placeholder="Unesite ID goriva"/><br>
                </div>

                <input id="gorivo" class="txtBox" name="gorivo" type="number" placeholder="Unesite ID vrste goriva"/><br>

                <input id="mjesto" class="txtBox" name="mjesto" type="number" placeholder="Unesite ID mjesta"/><br>

                <input id="cijena" class="txtBox" name="cijena" type="number" step="0.01" placeholder="Unesite cijenu goriva"/><br>

                <label for="status">Odaberi status goriva</label><br>
                <select name="status" id="status" class="status">
                  <option value="Na raspolaganju">Na raspolaganju</option>
                  <option value="Nije na raspolaganju">Nije na raspolaganju</option>
                </select> <br>

                <input id="kolicina" class="txtBox" name="kolicina" type="number" placeholder="Unesite kolicinu goriva"/><br>


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