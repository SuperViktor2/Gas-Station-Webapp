<?php

class Baza {

    // const server = "localhost";
    // const korisnik = "root";
    // const lozinka = "";
    // const baza = "WebDiP2021x028";

    const server = "localhost";
    const korisnik = "WebDiP2021x028";
    const lozinka = "admin_JXse";
    const baza = "WebDiP2021x028";


    private $veza = null;
    private $greska = '';

    function spojiDB() {
         $this->veza = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        if ($this->veza->connect_errno) {
            echo "Neuspješno spajanje na bazu: " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }

        return $this->veza;
    }

    function zatvoriDB() {
        $this->veza->close();
    }

    function selectDB($upit) {
        $rezultat = $this->veza->query($upit);
        if ($this->veza->connect_errno) {
            echo "Greška kod upita: {$upit} - " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        if (!$rezultat) {
            $rezultat = null;
        }
        return $rezultat;
    }

    function updateDB($upit) {
        $veza = self::spojiDB();
        if ($rezultat = $veza->query($upit)) {
            self::zatvoriDB($veza);
            return $rezultat;
        }

        echo "Pogreška: ".$veza->error;
        self::prekidVeze($veza);

        return $rezultat;
    }
}

?>