<?php
ob_start();
session_start();
if( isset($_SESSION['utente'])!="" ){
  header("Location: index.php");
}
include_once 'dbconnect.php';

$error = false;
$type = 0;   //indica la tipologia di utente: 0 per i clienti e 1 per gli organizzatori
$credit = 200; //credito di default per l'acquisto dei biglietti


if ( isset($_POST['btn-signup']) ) {

  // previene inserimenti da tastiera dannosi
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

  $surname = trim($_POST['surname']);
  $surname = strip_tags($surname);
  $surname = htmlspecialchars($surname);

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $phone = trim($_POST['phone']);
  $phone = strip_tags($phone);
  $phone = htmlspecialchars($phone);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  $pass2 = trim($_POST['pass2']);
  $pass2 = strip_tags($pass2);
  $pass2 = htmlspecialchars($pass2);

  //convalida del nome
  if (empty($name)) {
    $error = true;
    $nameError = "Inserisci nome";
  } else if (strlen($name) < 2) {
    $error = true;
    $nameError = "Il nome deve avere almeno 2 caratteri";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
    $error = true;
    $nameError = "Il nome può contenere solo lettere e spazi";
  }

  //convalida del Cognome
  if (empty($surname)){
    $error = true;
    $surnameError = "Inserisci cognome";
  } else if (strlen($name) < 2) {
    $error = true;
    $surnameError = "Il cognome deve avere almeno 2 caratteri";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$surname)) {
    $error = true;
    $surnameError = "Il cognome può contenere solo lettere e spazi";
  }

  //convalida email
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $error = true;
    $emailError = "Inserire un formato email valido.";
  } else {
    // controlla se l'email esiste o no
    $query = "SELECT email FROM utente WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    if($count!=0){
      $error = true;
      $emailError = "L'email inserita è già in uso da un altro utente";
    }
  }

  // convalida password
  if (empty($pass)){
    $error = true;
    $passError = "Inserire la Password.";
  } else if(strlen($pass) < 8) {
    $error = true;
    $passError = "La password deve essere formata da almeno 8 caratteri.";
  }

  if($pass2 != $pass){
    $error = true;
    $pass2Error = "Le password non corrispondono.";
  }

  // cryptagio password SHA256();
  $password = hash('sha256', $pass);


  // convalida numero di telefono
  if (empty($phone)) {
    $error = true;
    $phoneError = "Inserisci numero di telefono";
  } else if (strlen($phone) != 10) {
    $error = true;
    $phoneError = "I numeri di telefono hanno 10 cifre";
  } else if(!preg_match("/^[0-9]*$/", $phone)) {
    $error = true;
    $phoneError = "Il numero di telefono deve contenere solo cifre";
  }

  // se non ci sono errori continua col signup
  if( !$error ) {
    $query = "INSERT INTO utente (nome, cognome, password, email, telefono, credito, tipologia)
                    VALUES('$name', '$surname', '$password', '$email', '$phone', '$credit', '$type')";
    $res = mysqli_query($conn, $query);

    if ($res) {
      $errTyp = "success";
      $successMSG = "Registrazione effettuata con successo";
      unset($name);
      unset($email);
      unset($pass);
      unset($password);
      unset($surname);
      unset($phone);
    } else {
      $errTyp = "errore";
      $errMSG = "Qualcosa è andato storto, riprovare più tardi... ";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="it" dir="ltr" style="height: 100%;">
<head>
  <meta charset="utf-8">
  <title>99Tickets - Register</title>

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
<body class="nice-bg d-flex align-items-center">
  <div class=" mx-auto my-3 d-flex align-items-center rounded  w-75" style="border-style: solid; border-color: #1db954; max-width: 500px; background-color: #121212">


    <article class="card-body mx-auto" style="max-width: 400px; min-width:300px">
      <div class="align-item-center d-flex justify-content-around">
        <a href="index.php">
          <div> <img class="" style="margin: 2%;" src="img/header/logo.png" alt="99Tickets" width="75vw">
          </div>
        </a>
      </div>

      <h2 class="card-title mt-3">Registrati</h2>
      <span class="text-danger"><?php echo "<span style=\"color:red\"> $errMSG </span>" ?></span>
      <span class="text-danger"><?php echo "<span style=\"color:#1db954\"> $successMSG </span>" ?></span>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-user"></i> </span>
            </div>
            <label hidden for="name">Il tuo nome</label>
            <input id="name" name="name" class="form-control" placeholder="Nome" type="text">
          </div>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $nameError </span>" ?></span>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-user"></i> </span>
            </div>
            <label hidden for="surname">Il tuo cognome</label>
            <input id = "surname" name="surname" class="form-control" placeholder="Cognome" type="text">
          </div>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $surnameError </span>" ?></span>
        </div>

        <div class="form-group">
          <div class=" input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
            </div>
            <label hidden for="phone">Il tuo telefono</label>
            <input id="phone" name="phone" class="form-control" placeholder="Numero di Telefono" type="text">
          </div>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $phoneError </span>" ?></span>
        </div>


        <div class="form-group mt-3">
          <div class=" input-group">

            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
            </div>
            <label hidden for="email">La tua email</label>
            <input id="email" name="email" class="form-control" placeholder="E-mail" type="email">
          </div>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $emailError </span>" ?></span>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
            </div>
            <label hidden for="pass">La tua password</label>
            <input id="pass" name="pass" class="form-control" placeholder="Password" type="password">
          </div>
          <span class="text-danger"><?php echo "<span style=\"color:red\"> $passError </span>" ?></span>
        </div>

        <div class="form-group">
          <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
          <label hidden for="pass2">Ripeti Password</label>
          <input id="pass2" name="pass2" class="form-control" placeholder="Ripeti Password" type="password">
        </div>
        <span class="text-danger"><?php echo "<span style=\"color:red\"> $pass2Error </span>" ?></span>
      </div>

      <div class="form-group">
        <button name="btn-signup" type="submit" class="form-button btn btn-block">Crea Account</button>
      </div>
    </form>
    <p class="text-center">Hai già un account?<a href="login.php">Vai al Login</a> </p>
</article>
</div>
</body>
</html>
