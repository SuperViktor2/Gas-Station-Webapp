<?php
require 'sesija.class.php';
require 'baza.class.php';
Sesija::kreirajSesiju();

$veza = new Baza();
$veza->spojiDB();

$korime = $_SESSION["korisnik"];

$_SESSION["uloga"] = null;

$vrijeme = date("Y-m-d H:i:s");
$log = "INSERT INTO Dnevnik (korisnik, akcija, vrijeme)
   VALUES (
       	'$korime',
    	'Odjava',
       	'$vrijeme'
   )";

$veza->updateDB($log);

Sesija::obrisiSesiju();
header('Location: obrasci/prijava.php');
exit;

?>