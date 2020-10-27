<?php
ob_start();
session_start();
require_once 'dbconnect.php';

$path = "https://api.telegram.org/bot1084851894:AAGAFI3xZFKk7u9tL-tpDIiMLkXeJLxTA9A";

if ((!isset($_SESSION['utente'])) || ($_SESSION['tipologia']!='2')) {
  header("Location: index.php");
  exit;
}

if(isset($_POST['btn'])){
  $idOrg = htmlspecialchars(strip_tags(trim($_POST['idutente'])));
  if($_POST['idutente']==""){
    $errMSG = "Inserisci l'id utente";
  }else{
    $queryRank = "UPDATE utente SET tipologia = '1' WHERE ID = '$idOrg' ";
    $resRank = mysqli_query($conn, $queryRank);
    $ar = mysqli_affected_rows($conn);

    if ($ar == 1) {
      $successMSG = "Utente aggiornato";
      $resOrg = mysqli_query($conn, "SELECT telegram FROM utente WHERE ID = '$idOrg'");
      $rowVOrg=mysqli_fetch_array($resOrg);

      $chatID=$rowVOrg['telegram'];
      if($chatID!=""){
        $message = "Upgrade eseguito sul tuo account, ora puoi organizzare Eventi";
        file_get_contents($path."/sendmessage?chat_id=" . $chatID . "&text=". $message);
      }
    } else {
      $errMSG = "Qualcosa è andato storto, riprovare più tardi... ";
    }
  }
}


?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>99Tickets - RankUp</title>

  <link rel="shortcut icon" type="image/png" href="img/header/logo.png">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=B612:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="index.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<body class="nice-bg">

      <?php require_once ("header.php") ?>
  <div class=" mx-auto d-flex align-items-center rounded my-5" style="border-style: solid; border-color: #1db954; max-width: 500px; background-color: #121212;"> <article class="card-body mx-auto" style="max-width: 400px; min-width:300px">
    <form class="my-3" method="post" action="" autocomplete="off">
      <div class="form-group input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-id-badge"></i> </span>
        </div>
        <label hidden for="id_utente">ID Utente</label>
        <input id="id_utente" name="idutente" class="form-control" placeholder="ID Utente" type="text">
      </div>
      <div class="form-group">
        <label for="btn" hidden> Rank up</label>
        <button id="btn" name="btn" type="submit" class="form-button btn btn-block">Rank UP!</button>
      </div> <!-- form-group// -->
    </form>
    <div class="text-danger"><?php echo "<span style=\"color:red\"> $errMSG </span>" ?></div>
    <div class="text-danger"><?php echo "<span style=\"color:green\"> $successMSG </span>" ?></div>

  </article>
</div>
</body>
</html>
