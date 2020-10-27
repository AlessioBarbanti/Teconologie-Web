<?php
ob_start();
session_start();
require_once("bootstrap.php");
require_once("component.php");

if(isset($_POST["add"])){
  if(!isset($_SESSION['utente'])){
    header("Location: Login.php");
  }
}

if(isset($_POST["add"]) && isset($_SESSION['utente'])){
  if(isset($_SESSION["cart"])){
    $item_id = array_column($_SESSION['cart'], "id");

    if(in_array($_POST["id"],$item_id)){
      echo '<script>alert("Item già presente nel carrello")</script>';
      echo '<script>windows.location="home.php"</script>';
    }else{
      $count = count($_SESSION['cart']);
      $item_added = array(
        'id' => $_POST['id']
      );

      $_SESSION['cart'][$count] = $item_added;

    }

  }else{
    $item_added = array(
      'id' => $_POST['id']
    );

    $_SESSION['cart'][0] = $item_added;
  }
}

?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
  <title>99Tickets</title>
  <meta charset="utf-16">

  <link rel="shortcut icon" type="image/png" href="img/header/logo.png">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=B612:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="index.css">
  <script src="index.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <script type="text/javascript">
  $(window).bind("resize", function () {
    this.location.reload(true);
  });
</script>
</head>




<body style="height: 100vh; background-color: #121212; text-align: center;">

  <?php require_once ("header.php") ?>
  <!--  INIZIO MODAL --><div class="">
  <?php
  $concerti = $dbh->getConcert();
  foreach ($concerti as $concerto){
    if($concerto["n_biglietti"] == 0){
      modalSoldOut($concerto["titolo"],$concerto["luogo"], $concerto["data"], $concerto["ora"], $concerto["prezzo"], UPLOAD_DIR."soldOut.jpg",$concerto["descrizione"], $concerto["id"]);
    }else{
      modalAvailable($concerto["titolo"],$concerto["luogo"], $concerto["data"], $concerto["ora"], $concerto["prezzo"], UPLOAD_DIR.$concerto["immagine"],$concerto["descrizione"], $concerto["id"]);
    }
    
  }
  ?>
</div>

<!-- FINE MODAL -->



<div id="diamond-carousel" class="h-75" style="margin-right: 10%; margin-left: 10%;">
  <div class="MagicScroll" data-options="mode: carousel; speed: 1000; autoplay: 2000; width: 100%; height: 100%; scrollOnWheel: false" style="background-color: #121212; z-index: 1;">
    <?php
    $concerti = $dbh->getConcertlimit(7);
    foreach ($concerti as $concerto){
      concert1($concerto["titolo"], UPLOAD_DIR.$concerto["immagine"], $concerto["id"]);
    }
    ?>
  </div>
</div>

<div id="first-carousel"class="container-fluid h-50" style="margin-top: 10%; margin-bottom: 10%; z-index: -1;  height: 50vw;">
  <div class="d-flex justify-content-center text-center" style="background-color: #121212;">
    <hi class="text-left" style="font-size: 4vw;">In scadenza...</h1>
    </div>
    <div style="background-color: #121212;" class="MagicScroll" data-options="items: 4; step: 2; speed: 1300; autoplay: 2000; width: 100%; height: 100%; scrollOnWheel: false" style=" padding: 0px 15vw;">
      <?php
      $concerti = $dbh->getConcertEnding(8);
      foreach ($concerti as $concerto){
        concert2($concerto["titolo"], UPLOAD_DIR.$concerto["immagine"], $concerto["id"]);
      }
      ?>
    </div>
  </div>

  <div id="" class="container-fluid mb-5" style="margin-top: 15%; margin-bottom: 10%; z-index: -1;">
    <div class="d-flex justify-content-center text-center" style="background-color: #121212;">
      <h1 class="text-center" style="font-size: 3vw;">Non hai ancora trovato quello che cerchi? <br> Cerca fra tutti gli eventi!</h1>
      </div>
    </div>
  </div>

  <!-- TUTTI GLI EVENTI -->

  <div id="searchbar" class="input-group nav-item w-75 mx-auto mb-5">
    <input id="myInput" type="search" class="form-control" placeholder="Cerca..." style="background-color: #121212; border-width:3px; border-color: #1db954;">
  </div>

<div class="mx-5">


    <table class="table mx-2 vertical-align" style="color: #818181">
      <tbody id="myTable">
      <?php 
        $concerti = $dbh->getAllConcert();
        foreach($concerti as $concerto){
          allElem($concerto["titolo"], UPLOAD_DIR.$concerto["immagine"], $concerto["id"]);
        }
         ?>
      </tbody>
    </table>
</div>


  <footer class="pt-5 mt-5 d-sm-flex justify-content-around text-center text-decoration-none ">
    <div class="explore-footer p-3 col-xl-4">
      <h2>Esplora</h2>
      <a href="#">Il mio Account</br></a>
      <a href="#">Ordini</br></a>
      <a href="#">Pagina Iniziale</br></a>
      <a href="Login.php">Login</a>
    </div>

    <div class="p-3 col-xl-4">
      <h2>Seguici!</h2>
      <span class="d-flex justify-content-center">
        <a href="#" class="login100-social-item" style="background-color: #3b5998;"><i class="fa fa-facebook"></i></a>
        <a href="#" class="login100-social-item" style="background-color: #1da1f2;"><i class="fa fa-twitter"></i></a>
        <a href="#" class="login100-social-item" style="background-color: #ea4335;"><i class="fa fa-google"></i></a>
      </span>

    </div>

    <div class="p-3 col-xl-4">
      <h2>Contattaci</h2>
      <p>Mail: Mail@fake.com</p>
      <p>Tel: 1234567890</p>
    </div>
  </footer>
  <div class="justify-content-around p-5 text-center">
    copyright F.A.N.
  </div>
</body>
</html>

<link type="text/css" rel="stylesheet" href="magicscroll-trial/magicscroll/magicscroll.css"/>
<script type="text/javascript" src="magicscroll-trial/magicscroll/magicscroll.js"></script>
