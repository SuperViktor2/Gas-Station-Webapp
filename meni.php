<?php
error_reporting(E_ERROR);

// require 'sesija.class.php';
// Sesija::kreirajSesiju();

session_start();

$putanja = dirname($_SERVER['REQUEST_URI'], 1);

 // echo "$putanja";

// if($putanja == "/webdip") {
//   if($_SESSION['uloga'] == NULL) {
//     echo "
//           <li><a href=\"$putanja/dokumentacija.html\">Dokumentacija</a></li>
//           <li><a href=\"$putanja/o_autoru.html\">Autor</a></li>
//           <li><a href=\"$putanja/popis.php\">Popis</a></li>
//           <li><a href=\"$putanja/multimedija.php\">Multimedija</a></li>
//           <li><a href=\"$putanja/obrasci/prijava.php\">Prijava</a></li>
//           <li><a href=\"$putanja/obrasci/registracija.php\">Registracija</a></li>
//       ";
//   }

//   if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] >= 3 && $_SESSION["uloga"] != NULL) {
//       echo "<li><a href=\"obrasci/mjesta.php\">Točionice</a></li>";
//   }

//   if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] == 4 && $_SESSION["uloga"] != NULL) {
//       echo "<li><a href=\"$putanja/dnevnik.php\">Dnevnik</a></li>";
//       echo "<li><a href=\"$putanja/blokirani.php\">Blokirani</a></li>";
//       echo "<li><a href=\"obrasci/lokacije.php\">Lokacije</a></li>";
//       echo "<li><a href=\"obrasci/pumpe.php\">Pumpe</a></li>";
//       echo "<li><a href=\"obrasci/moderatori.php\">Moderatori</a></li>";
//       echo "<li><a href=\"obrasci/gorivo.php\">Gorivo</a></li>";


//  }

//  if($_SESSION['uloga'] != NULL) {
//     echo "<li><a href=\"$putanja/popis2.php\">Popis</a></li>";
//     echo "<li><a href=\"$putanja/multimedija.php\">Multimedija</a></li>";
//     echo "<li><a href=\"obrasci/obrazac.php\">Obrazac</a></li>";
//     echo "<li><a href=\"$putanja/statistika.php\">Statistika</a></li>";
//     echo "<li><a href=\"$putanja/logout.php\">Odjava</a></li>";
//   } 
// } else {
//   if($_SESSION['uloga'] == NULL) {
//     echo "
//           <li><a href=\"../dokumentacija.html\">Dokumentacija</a></li>
//           <li><a href=\"../o_autoru.html\">Autor</a></li>
//           <li><a href=\"../popis.php\">Popis</a></li>
//           <li><a href=\"../multimedija.php\">Multimedija</a></li>
//           <li><a href=\"$putanja/prijava.php\">Prijava</a></li>
//           <li><a href=\"$putanja/registracija.php\">Registracija</a></li>
//       ";
//   }

//   if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] >= 3 && $_SESSION["uloga"] != NULL) {
//       echo "<li><a href=\"$putanja/mjesta.php\">Točionice</a></li>";
//   }

//   if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] == 4 && $_SESSION["uloga"] != NULL) {
//       echo "<li><a href=\"../dnevnik.php\">Dnevnik</a></li>";
//       echo "<li><a href=\"../blokirani.php\">Blokirani</a></li>";
//       echo "<li><a href=\"$putanja/lokacije.php\">Lokacije</a></li>";
//       echo "<li><a href=\"$putanja/pumpe.php\">Pumpe</a></li>";
//       echo "<li><a href=\"$putanja/moderatori.php\">Moderatori</a></li>";
//       echo "<li><a href=\"$putanja/gorivo.php\">Gorivo</a></li>";



//  }

//  if($_SESSION['uloga'] != NULL) {
//     echo "<li><a href=\"../popis2.php\">Popis</a></li>";
//     echo "<li><a href=\"../multimedija.php\">Multimedija</a></li>";
//     echo "<li><a href=\"$putanja/obrazac.php\">Obrazac</a></li>";
//     echo "<li><a href=\"../statistika.php\">Statistika</a></li>";
//     echo "<li><a href=\"../logout.php\">Odjava</a></li>";
//   } 
// }

// ------- ZA BARKU ------------------------------------------------------------------------------
if($putanja == "/WebDiP/2021_projekti/WebDiP2021x028") {
if($_SESSION['uloga'] == NULL) {
    echo "
          <li><a href=\"$putanja/dokumentacija.html\">Dokumentacija</a></li>
          <li><a href=\"$putanja/o_autoru.html\">Autor</a></li>
          <li><a href=\"$putanja/popis.php\">Popis</a></li>
          <li><a href=\"$putanja/multimedija.php\">Multimedija</a></li>
          <li><a href=\"$putanja/obrasci/prijava.php\">Prijava</a></li>
          <li><a href=\"$putanja/obrasci/registracija.php\">Registracija</a></li>
      ";
  }

  if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] >= 3 && $_SESSION["uloga"] != NULL) {
      echo "<li><a href=\"obrasci/mjesta.php\">Točionice</a></li>";
  }

  if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] == 4 && $_SESSION["uloga"] != NULL) {
      echo "<li><a href=\"$putanja/dnevnik.php\">Dnevnik</a></li>";
      echo "<li><a href=\"$putanja/blokirani.php\">Blokirani</a></li>";
      echo "<li><a href=\"obrasci/lokacije.php\">Lokacije</a></li>";
      echo "<li><a href=\"obrasci/pumpe.php\">Pumpe</a></li>";
      echo "<li><a href=\"obrasci/moderatori.php\">Moderatori</a></li>";
      echo "<li><a href=\"obrasci/gorivo.php\">Gorivo</a></li>";
      echo "<li><a href=\"obrasci/konf.php\">Konfiguracija sustava</a></li>";
 }

 if($_SESSION['uloga'] != NULL) {
    echo "<li><a href=\"$putanja/popis2.php\">Popis</a></li>";
    echo "<li><a href=\"$putanja/multimedija.php\">Multimedija</a></li>";
    echo "<li><a href=\"obrasci/obrazac.php\">Obrazac</a></li>";
    echo "<li><a href=\"$putanja/statistika.php\">Statistika</a></li>";
    echo "<li><a href=\"$putanja/logout.php\">Odjava</a></li>";
  } 
} else {
  if($_SESSION['uloga'] == NULL) {
    echo "
          <li><a href=\"../dokumentacija.html\">Dokumentacija</a></li>
          <li><a href=\"../o_autoru.html\">Autor</a></li>
          <li><a href=\"../popis.php\">Popis</a></li>
          <li><a href=\"../multimedija.php\">Multimedija</a></li>
          <li><a href=\"$putanja/prijava.php\">Prijava</a></li>
          <li><a href=\"$putanja/registracija.php\">Registracija</a></li>
      ";
  }

  if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] >= 3 && $_SESSION["uloga"] != NULL) {
      echo "<li><a href=\"$putanja/mjesta.php\">Točionice</a></li>";
  }

  if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] == 4 && $_SESSION["uloga"] != NULL) {
      echo "<li><a href=\"../dnevnik.php\">Dnevnik</a></li>";
      echo "<li><a href=\"../blokirani.php\">Blokirani</a></li>";
      echo "<li><a href=\"$putanja/lokacije.php\">Lokacije</a></li>";
      echo "<li><a href=\"$putanja/pumpe.php\">Pumpe</a></li>";
      echo "<li><a href=\"$putanja/moderatori.php\">Moderatori</a></li>";
      echo "<li><a href=\"$putanja/gorivo.php\">Gorivo</a></li>";
      echo "<li><a href=\"$putanja/konf.php\">Konfiguracija sustava</a></li>";



 }

 if($_SESSION['uloga'] != NULL) {
    echo "<li><a href=\"../popis2.php\">Popis</a></li>";
    echo "<li><a href=\"../multimedija.php\">Multimedija</a></li>";
    echo "<li><a href=\"$putanja/obrazac.php\">Obrazac</a></li>";
    echo "<li><a href=\"../statistika.php\">Statistika</a></li>";
    echo "<li><a href=\"../logout.php\">Odjava</a></li>";
  } 
}
// ----------------------------------------------------------------------------------------------
?>