<?php  ob_start();
session_start();
require_once 'dbconnect.php';


// se sei già loggato ti fa saltare il login
if (!isset($_SESSION['utente'])) {
  header("Location: login.php");
  exit;
  }

$IDutente = $_SESSION['utente'];

//ottengo le info che mi servono
$resSelect=mysqli_query($conn, "SELECT  cognome, telefono, email FROM utente WHERE ID='$IDutente'");
$rowSelect=mysqli_fetch_array($resSelect);

$_SESSION['cognome'] = $rowSelect['cognome'];
$_SESSION['telefono'] = $rowSelect['telefono'];
$_SESSION['email'] = $rowSelect['email'];

//se il pulsante è stato premuto
if ( isset($_POST['btn-change']) ) {

  // previene inserimenti da tastiera dannosi
  $phone = trim($_POST['phone']);
  $phone = strip_tags($phone);
  $phone = htmlspecialchars($phone);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  $pass2 = trim($_POST['pass2']);
  $pass2 = strip_tags($pass2);
  $pass2 = htmlspecialchars($pass2);

  // convalida password
  if(($pass!="") && (strlen($pass) < 8)) {
    $error = true;
    $passError = "La password deve essere formata da almeno 8 caratteri.";
  }

  if($pass2 != $pass){
    $error = true;
    $pass2Error = "Le password non corrispondono.";
  }


  // convalida numero di telefono
   if (($phone!="") && (strlen($phone) != 10)) {
    $error = true;
    $phoneError = "I numeri di telefono hanno 10 cifre";
  } else if(!preg_match("/^[0-9]*$/", $phone)) {
    $error = true;
    $phoneError = "Il numero di telefono deve contenere solo cifre";
  }

  // se non ci sono errori continua col signup
  if( !$error ) {
    //prendo password e telefono nel caso i campi restino vuoti
    $resVuoto=mysqli_query($conn, "SELECT  telefono, password FROM utente WHERE ID='$IDutente'");
    $rowVuoto=mysqli_fetch_array($resVuoto);

    //se i campi sono vuoti setto la variabile con i valori che gia aveva nel db
    if($phone==""){
      $phone=$rowVuoto['telefono'];
    }if($pass==""){
      // cryptagio password SHA256();
      $password=$rowVuoto['password'];
    }else{
      $password = hash('sha256', $pass);
    }
    //faccio l'update dei valori
    $queryUpdate = "UPDATE utente SET telefono='$phone', password='$password' WHERE ID='$IDutente'";
    $resUpdate = mysqli_query($conn, $queryUpdate);

    if ($resUpdate) {
      $successMSG = 'Il tuo profilo è stato aggiornato correttamente';
    } else {
      $errMSG = "Qualcosa è andato storto, riprovare più tardi... ";
    }
  }
}

//php MODAL
$path = "https://api.telegram.org/bot1084851894:AAGAFI3xZFKk7u9tL-tpDIiMLkXeJLxTA9A";

 if ( isset($_POST['btn']) ) {
   $tel = $_POST['tel'];
   $area = trim($_POST['area']);
   $area = strip_tags($area);
   $area = htmlspecialchars($area);

   $IDutente = $_SESSION['utente'];

   $resSelect=mysqli_query($conn, "SELECT  telefono FROM utente WHERE ID='$IDutente'");
   $rowSelect=mysqli_fetch_array($resSelect);

   $phone = $rowSelect['telefono'];

   if (strlen($area)>=10){


     if($tel){
       $message = "ID utente " . $_SESSION['utente'] . " richiede i poteri di organizzatore: " . $area;
       file_get_contents($path."/sendmessage?chat_id=-484877967&text=". $message . " e richiede di essere contattato telefonicamente: " . $phone);
     }else{
       $message = "ID utente " . $_SESSION['utente'] . " richiede i poteri di organizzatore: " . $area;
       file_get_contents($path."/sendmessage?chat_id=-484877967&text=". $message);
     }

      $area=" ";
      $successMSG="Richiesta effettuata con successo";
   }else{
     $errMSG="L'area per la richiesta è vuota o non raggiunge i 10 caratteri";
   }
 }
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
<body class="nice-bg" style="min-height: 0vh">

  <?php require_once ("header.php") ?>

  <!--  INIZIO MODAL -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div id="#" class="modal-content" style="border-style: solid; border-color: #1db954;  background-color: #121212;" >
          <div class="modal-body">


            <form class="form-check" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <label for="textarea">Specifiche dell'evento (max 100 caratteri):</label>
            <textarea id="textarea" name="area" type="text" class="text-field w-100 rounded mb-2" maxlength="100" style="resize: none; border-style: solid; border-color: #1db954;"></textarea>

            <div class="form-check my-2">
              <input name="tel" id="checkbox1" type="checkbox">
              <label for="checkbox1">Voglio essere contattato telefonicamente.</label>
            </div>


            <button name="btn" type="submit" class="form-button btn">Invia</button>
            </form>
          </div>
        </div>
      </div>
  </div>
    <!-- FINE MODAL -->

  <div class=" mx-auto my-5 rounded w-75 d-flex align-items-center" style="position: relative; top: 6vh; border-style: solid; border-color: #1db954; background-color: #121212">
    <article class="card-body m-auto w-75  h-100">
      <div class="text-center mb-5">
      </div>
      <div class="mb-5">


        <h2 class="card-title mt-3">I tuoi dati...</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

          <div class="form-group my-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              </div>
              <label for="name" hidden>Nome</label>
              <input name="name" id="name" class="form-control" placeholder="<?php echo($_SESSION['nome']); ?>" type="text" readonly>
            </div>
          </div>

          <div class="form-group  my-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
              </div>
              <label for="surname" hidden>Cognome</label>
              <input name="surname" id="surname" class="form-control" placeholder="<?php echo($_SESSION['cognome']); ?>" type="text" readonly>
            </div>
          </div>

          <div class="form-group my-3">
            <div class=" input-group">

              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
              </div>
              <label for="email" hidden>Email</label>
              <input name="email" id="email" class="form-control" placeholder="<?php echo($_SESSION['email']); ?>" type="email" readonly>
            </div>
          </div>

          <div class="form-group  my-3">
            <div class=" input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
              </div>
              <label for="phone" hidden>Telefono</label>
              <input name="phone" id="phone" class="form-control" placeholder="Numero di Telefono" type="text">
            </div>
            <span class="text-danger"><?php echo "<span style=\"color:red\"> $phoneError </span>" ?></span>
          </div>



          <div class="form-group my-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
              </div>
              <label for="pass" hidden>Password</label>
              <input name="pass" id="pass" class="form-control" placeholder="Nuova Password" type="password">
          </div>
            <span class="text-danger"><?php echo "<span style=\"color:red\"> $passError </span>" ?></span>
          </div>

          <div class="form-group my-3">
            <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
            </div>
            <label for="pass2" hidden>Ripeti Password</label>
            <input name="pass2" id="pass2" class="form-control" placeholder="Ripeti Password" type="password">
          </div>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $pass2Error </span>" ?></span>
        </div>

        <div class="">
          <span class="text-success"><?php echo $successMSG ?></span>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $errMSG </span>" ?></span>
          <div class="col-sm-3 mx-auto">
          <label for="btn-change" hidden>Aggiorna Profilo</label>
            <button name="btn-change" id="btn-change" type="submit" class="form-button btn btn-block">Aggiorna Profilo</button>
          </div>
        </div>
        </form>
      </div>
      <div class="mt-5">
        <p class="text-center"><a href="#" data-toggle="modal" data-target="#modal">Vorrei organizzare un concerto</a> </p>
      </div>
    </article>
  </div>
</body>
</html>
