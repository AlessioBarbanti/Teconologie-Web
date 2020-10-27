<?php 

session_start();
require_once("bootstrap.php");
require_once("component.php");

?>



<html lang="it" dir="ltr" style="height: 100%;">
<head>
  <meta charset="utf-8">
  <title>99Tickets - Ordini</title>

  <link rel="shortcut icon" type="image/png" href="img/header/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=B612:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="index.css">
  <script src="index.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body class="nice-bg" style="background-color: transparent">

  <?php require_once ("header.php") ?>

  <div class=" mx-auto my-5 rounded w-75 " style="position: relative; top: 4vh; border-style: solid; border-color: #1db954; background-color: #121212">
    <?php 
    if (!isset($_SESSION['utente'])){
      header("Location: Login.php");
      exit;
    }else{
          $idConcerti = $dbh->getTicket($_SESSION["utente"]);
          if(empty($idConcerti)){
            echo "<p class='text-center m-5'>Non hai ancora effetuato nessun ordine!</p>";
          }else{
            foreach ($idConcerti as $concerto){
            historyElem(UPLOAD_DIR.$concerto["immagine"], $concerto["titolo"], $concerto["prezzo"], $concerto["data"],$concerto["ora"], $concerto["data_acquisto"]);
        }
      }
    } 
    ?>
</div>
</body>
</html>
