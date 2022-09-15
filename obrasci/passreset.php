<?php
error_reporting(E_ERROR);

require '../baza.class.php';
require '../sesija.class.php';
Sesija::kreirajSesiju();

$veza = new Baza();
$veza->spojiDB();

$korime = $_POST['korime'];
$vrijeme = date("Y-m-d H:i:s");
$newpass = rand(1000, 9999);
$email = $_POST['email'];

$update = "UPDATE Korisnik SET lozinka = '$newpass' WHERE username = '$korime'";

$log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
   VALUES (
      '$korime',
      'Resetirana_lozinka',
      '$vrijeme'
   )";

$naslov = "Nova lozinka";
$headers = "From: vgoles@foi.hr \r\n";
$poruka = '
   Vaši podatci za login
   ------------------------
   Username: '.$korime.'
   Password: '.$newpass.'
';


if (isset($_POST['submit'])) {
    $veza->updateDB($update);
    $veza->updateDB($log);
    mail($email, $naslov, $poruka, $headers);
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
    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="../index.php"><img id="logo" 
                    src="../materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Resetiraj lozinku
                </a>
            </div>
        </header>

      <div class="container">
        <p class="upute">Unesite korisničko ime i lozinku u obrazac za prijavu.</p>
        <div class="forma">
            <form name="prijava" id="forma" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="korime">Korsiničko ime: </label>
                <input id="korime" class="txtBox" name="korime" type="text" placeholder="Unesite korisničko ime" autofocus /><br>

                <label for="email">Email: </label>
                <input id="email" class="txtBox" name="email" type="text" placeholder="Unesite korisničko ime" autofocus /><br>

            </form>

            <input name="submit" class="gumb" type="submit" value="Resetiraj" form="forma"/>
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

