<?php
error_reporting(E_ERROR);
    require '../baza.class.php';
    require '../sesija.class.php';

    Sesija::kreirajSesiju();

    $veza = new Baza();
    $veza->spojiDB();

    $greska = array();
    $ime = $_POST['ime'];
    $korime = $_POST['korime'];
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];
    $salt = rand(1000000, 9999999);
    $sha256 = hash('sha256', $lozinka . $salt);
    $vrijemeIsteka = time() + (7 * 60 * 60);
    $vrijeme = date("Y-m-d H:i:s", $vrijemeIsteka);

    $actkey = rand(10000, 99999);

    $insert = "INSERT INTO Korisnik (ime, email, username, lozinka, lozinkasha1, blokiran, actkey, TipKorisnika_IdTipKorisnika, vrijeme, salt)
            VALUES (
            '$ime',
            '$email',
            '$korime',
            '$lozinka',
            '$sha256',
            1,
            '$actkey',
            2,
            '$vrijeme',
            '$salt'
        )";

    $naslov = 'Verifikacija';
    $headers = "From: vgoles@foi.hr \r\n";
    $poruka = '
        Vaši podatci za login
        ------------------------
        Username: '.$korime.'
        Password: '.$lozinka.'
        Aktivacijski kod: '.$actkey.'

        Hvala na prijavi!
    ';

    $valuser = "SELECT username FROM Korisnik WHERE username='$korime'";
    
    if (isset($_POST['submit'])) {

        $odg = $veza->selectDB($valuser);

        if (mysqli_num_rows($odg) > 0) {
                array_push($greska, "Korisničko ime " . $korime . " već postoji!");
        } 

        foreach ($_POST as $k => $v) {
            if (empty($v)) {
                array_push($greska, "Nije popunjeno: " . $k);
            }
        }

        if ($lozinka != $_POST['potvrda']) {
            array_push($greska, "Lozinke nisu identicne!");
        }

        if(strlen($lozinka) < 5) {
        array_push($greska, "Lozinka mora imati vise od 5 znakova!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($greska, "Neispravan format emaila!");
        }

        if(!preg_match('/[A-Z]/', $korime)){
            array_push($greska, "Korisnicko ime mora imati barem jedno veliko slovo!");
        }

        if (empty($greska)) {

            if($veza->updateDB($insert)){
                echo "Korisnik je uspješno ažuriran!";
                mail($email, $naslov, $poruka, $headers);
                header('Location: potvrda.php');
            }
        }
        else {
            foreach ($greska as $key => $value) {
                echo $value . "<br>";
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

         <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="../index.php"><img id="logo" 
                    src="../materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Registracija
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
        <p class="upute">Popunite obrazac za registraciju traženim podatcima</p>
        <div class="forma">
            <form name="registracija" id="forma" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="ime">Ime i prezime: </label>
                <input id="ime" class="txtBox" name="ime" type="text" placeholder="Unesite ime" autofocus /><br>

                <label for="korime">Korsiničko ime: </label>
                <input id="korime" class="txtBox" name="korime" type="text" placeholder="Unesite korisničko ime"/><br>

                <label for="email">E-mail: </label>
                <input id="email" class="txtBox" type="email" name="email" placeholder="ldap@foi.hr"/>
                <br>
                
                 <label for="lozinka">Lozinka: </label>
                 <input id="lozinka" class="txtBox" name="lozinka" type="password" placeholder="Unesite lozinku" maxlength="50"/><br>

                <label for="potvrda">Ponovite lozinku: </label>
                <input id="potvrda" class="txtBox" name="potvrda" type="password" placeholder="Ponovno unesite istu lozinku" maxlength="50"/><br>

                <div class="g-recaptcha" data-sitekey="6Le87GEgAAAAAD6ZzgV5GOdBMeSVSU2wCYK50efh"></div>
            </form>

            <input name="submit" class="gumb" type="submit" value="Registriraj se" form="forma"/>
        </div>
      </div>

        <footer>

            <div class="validator">
                <a href="https://validator.w3.org/nu/?showsource=yes&doc=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2021%2Fzadaca_01%2Fvgoles%2Fobrasci%2Fregistracija.php"> 
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