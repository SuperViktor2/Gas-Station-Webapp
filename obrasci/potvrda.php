<?php
error_reporting(E_ERROR);

if(!isset($_SERVER['HTTPS'])) {
        $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header("Location:$redirect");
} 
require '../baza.class.php';
require '../sesija.class.php';
Sesija::kreirajSesiju();

$veza = new Baza();
$veza->spojiDB();

$korime = $_POST['korime'];
$actkey = $_POST['actkey'];
$vrijeme = date("Y-m-d H:i:s");
$istek = 0;

$sql = "SELECT actkey FROM Korisnik WHERE username = '$korime'";
$provjera = "SELECT vrijeme FROM Korisnik WHERE username='$korime'";
$update = "UPDATE Korisnik SET blokiran = '0' WHERE username = '$korime'";
$log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
            VALUES (
            '$korime',
            'Registriran',
            '$vrijeme'
        )";

if (isset($_POST['submit'])) {

    $i = $veza->selectDB($provjera);
    if($i ->num_rows > 0) {
        while ($j = $i->fetch_assoc()) {
            if($vrijeme > $j["vrijeme"]) {
                $istek = 1;
            }
        }
    }

    $odg = $veza->selectDB($sql);

    if ($odg->num_rows > 0) {
        while ($red = $odg->fetch_assoc()) {
            if($red["actkey"] == $actkey){
                if ($istek != 1) {
                    $veza->updateDB($update);
                    $veza->updateDB($log);
                    header('Location: prijava.php');
                } else {echo "Isteklo vrijeme za aktivaciju.";}
            } else {echo "Pogresan kod za aktivaciju";}
        }
    }


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
    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="../index.php"><img id="logo" 
                    src="../materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Potvrda
                </a>
            </div>
        </header>

      <div class="container">
        <p class="upute">Unesite korisničko ime i lozinku u obrazac za prijavu.</p>
        <div class="forma">
            <form name="prijava" id="forma" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="korime">Korsiničko ime: </label>
                <input id="korime" class="txtBox" name="korime" type="text" placeholder="Unesite korisničko ime" autofocus /><br>

                <label for="actkey">Aktivacijski kod: </label>
                <input id="actkey" class="txtBox" name="actkey" type="text" placeholder="XXXXX"/><br>

            </form>

            <input name="submit" class="gumb" type="submit" value="Aktiviraj račun" form="forma"/>
        </div>

      </div>

        <footer>

            <div class="validator">
                <a href="https://validator.w3.org/nu/?showsource=yes&doc=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2021%2Fzadaca_01%2Fvgoles%2Fobrasci%2Fprijava.php"> 
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