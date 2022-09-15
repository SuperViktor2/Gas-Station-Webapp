<?php
error_reporting(E_ERROR);

if(!isset($_SERVER['HTTPS'])) {
        $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header("Location:$redirect");
} 
require '../baza.class.php';
require '../sesija.class.php';
Sesija::kreirajSesiju();

if(!isset($_COOKIE['loginNum'])) {
        setcookie('loginNum', 4, time() + (86400 * 30), "/");
}

$veza = new Baza();
$veza->spojiDB();

$greska = array();
$korime = $_POST['korime'];
$lozinka = $_POST['lozinka'];
$zapamti = $_POST['zapamti'];
$vrijeme = date("Y-m-d H:i:s");

$sql = "SELECT * FROM Korisnik WHERE username='$korime' AND lozinka='$lozinka'";
$update = "UPDATE Korisnik SET blokiran = '1' WHERE username = '$korime'";
$log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
            VALUES (
            '$korime',
            'Prijava',
            '$vrijeme'
        )";

$log2 = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
            VALUES (
            '$korime',
            'Blokiran',
            '$vrijeme'
        )";
if (isset($_POST['submit'])) {

    foreach ($_POST as $k => $v) {
        if (empty($v)) {
            array_push($greska, "Nije popunjeno: " . $k);
        }
    }

    $odg = $veza->selectDB($sql);

    if ($odg->num_rows > 0) {
        while ($red = $odg->fetch_assoc()) {
            if($red["blokiran"] == 0){
                $tip = $red["TipKorisnika_idTipKorisnika"];
                Sesija::kreirajKorisnika($korime, $tip); 
                $_SESSION['loginCount'] = 1;
                $_SESSION['id'] = $red['idKorisnik'];
                $_SESSION['korisnik'] = $red['username'];  
                header('Location: ../popis2.php');
                $veza->updateDB($log);
                
            } else {
                echo "Korisnicki racun blokiran, pokusatje kasnije.";
                $veza->updateDB($log2);
            }
        }
    } else {
        // echo 'Netočna lozinka ili korisničko ime! <br>';
        if ($_SESSION['loginCount'] == NULL) {
            $_SESSION['loginCount'] = 1;
        }

        if (isset($_SESSION['loginCount'])){
            $_SESSION['loginCount']++;
            // echo "broj pokusaja: " . var_dump($_SESSION['loginCount']) . "<br>";
            // echo "Kolacic: " . var_dump($_COOKIE['loginNum']) . "<br>";
            if ($_SESSION['loginCount'] > $_COOKIE['loginNum']) {
                $_SESSION['loginCount'] = 1;
                $veza->updateDB($update);
            }
        }
    }

   if (empty($greska)) {
        if(isset($zapamti)) {
            setcookie("korime", $korime, time()+ 3600);
        } else {
            setcookie("korime","");
        }

    } else {
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
    </head>

    <body id="body">
        <header>
            <div class="navbar">
                <a href="../index.php"><img id="logo" 
                    src="../materijali/logo.png" alt="logo" class="naslovnica"></a>

                <a href="#" class ="naslovnica" id="naslov">
                    Prijava
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
        <p class="upute">Unesite korisničko ime i lozinku u obrazac za prijavu. Imate 3 pokušaja.</p>

        <button type="button" 
        onclick="document.getElementById('body').style.letterSpacing = '.15rem';">
        Mod za disleksiju</button>
        
        <div class="forma">
            <form name="prijava" id="forma" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="korime">Korisničko ime: </label>
                <input id="korime" class="txtBox" name="korime" type="text" placeholder="Korisničko ime" autofocus
                value="<?php if(isset($_COOKIE["korime"])) { echo $_COOKIE["korime"]; } ?>"
                /><br>

                <label for="lozinka">Lozinka: </label>
                <input id="lozinka" class="txtBox" name="lozinka" type="password" placeholder="Lozinka" size="30"/><br>

                <a href="passreset.php">Zaboravljena lozinka</a>
                <input type="checkbox" id="zapamti" name="zapamti" value="zapamti">
                <label for="zapamti"> Zapamti me</label><br>

            </form>

            <input name="submit" class="gumb" type="submit" value="Prijava" form="forma"/>
        </div>
        <span>vgoles lozinka - admin</span><br>
        <span>kgoles loznk - moderator</span><br>
        <span>lol 1 - registrirani</span><br>

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