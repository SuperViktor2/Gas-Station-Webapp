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
                    Pumpe
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
        <p class="upute">Dodavanje/Ažuriranje benzinskih pumpi</p>
        <button onclick="window.print(); return false;">Ispis</button>
        <div class="info">
            <?php

                $id = $_GET['id'];
                $opcija = $_GET['opcija'];
                $lokacija = $_GET['lokacija'];
                $pumpa = $_GET['pumpa'];


                print "
                    <table id='tablica'>
                        <thead>
                            <tr>
                                <th>ID lokacije</th>
                                <th>Lokacija</th>
                                <th>ID Pumpe</th>
                                <th>Pumpa</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                require '../baza.class.php';
                $veza = new Baza();
                $veza->spojiDB();

                $vrijeme = date("Y-m-d H:i:s");
                $korime = $_SESSION['korisnik'];
                $log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
                    VALUES (
                    '$korime',
                    'Izmjena Pumpe',
                    '$vrijeme'
                )";

                $sql = "SELECT l.idLokacija as id, l.naziv as naziv, p.idPumpa as idPumpa, p.naziv as pumpa FROM Lokacija l
                        LEFT JOIN Pumpa p on l.idLokacija = p.idLokacija";

                $odg = $veza->selectDB($sql);

                while ($red = $odg->fetch_assoc()) {
                    print "<tr>";
                    print "<td>" . $red['id'] . "</td>";
                    print "<td>" . $red['naziv'] . "</td>";
                    print "<td>" . $red['idPumpa'] . "</td>";
                    print "<td>" . $red['pumpa'] . "</td>";
                    print "</tr>"; 
                }

                echo "</table>";

                $sql2 = "SELECT * FROM Lokacija WHERE naziv = '$lokacija'";
                $lokacije = $veza->selectDB($sql2);

                if (isset($_GET['submit'])) {
                    if ($opcija == 'upload') {
                        if ($odg->num_rows > 0) {
                            while ($red = $lokacije->fetch_assoc()) {

                                $insertPumpa = "INSERT INTO Pumpa (naziv, idLokacija)
                                    VALUES (
                                    '$pumpa',
                                    {$red['idLokacija']}
                                )";

                                $veza->updateDB($insertPumpa);
                            }
                        } 

                        header( "refresh:1;url=pumpe.php" );
                    } 
                    elseif ($opcija == 'azuriraj') {
                        if ($odg->num_rows > 0) {
                            while ($red = $lokacije->fetch_assoc()) {

                                $update = "UPDATE Pumpa SET naziv = '$pumpa', idLokacija = {$red['idLokacija']} WHERE idPumpa = '$id'";
                                $veza->updateDB($update);
                                header( "refresh:1;url=pumpe.php" );

                            }
                        }
                    }
                    $veza->updateDB($log);
                }
            ?>
        </div>
        <div class="forma">

            <form name="lokacije" id="forma" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <select name="opcija" id="opcija" class="id" onchange="fja();" style="margin-bottom: 20px;">
                  <option value="upload">Upload</option>
                  <option value="azuriraj">Ažuriranje</option>
                </select> <br>

                <div id="azuriranje">
                    <label for="id">ID Pumpe</label>
                    <input id="id" class="txtBox" name="id" type="number" placeholder="Unesite ID pumpe"/><br>
                </div>

                <label for="pumpa">Pumpa </label>
                <input id="pumpa" class="txtBox" name="pumpa" type="text" placeholder="Unesite Pumpu" autofocus /><br>

                <label for="lokacija">Lokacija </label>
                <input id="lokacija" class="txtBox" name="lokacija" type="text" placeholder="Unesite Lokaciju" /><br>
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