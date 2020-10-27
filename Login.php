<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 // se sei già loggato ti fa saltare il login
 if ( isset($_SESSION['utente'])!="" ) {
  header("Location: index.php");
  exit;
 }

 $error = false;

 if( isset($_POST['btn-login']) ) {

  // previene inserimenti da tastiera invalidi
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);


  if(empty($email)){
   $error = true;
   $emailError = "Inserire l'email.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Inserire un formato email valido.";
  }

  if(empty($pass)){
   $error = true;
   $passError = "Inserire la password.";
  }

  // se non ci sono errori continua col login
  if (!$error) {

   $password = hash('sha256', $pass); // cripta la password con SHA256

   $res=mysqli_query($conn, "SELECT ID, nome, password, tipologia, credito FROM utente WHERE email='$email'");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); // se email/pass sono corretti ritorna 1 row

   if( $count == 1 && $row['password']==$password ) {
    $_SESSION['utente'] = $row['ID'];
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['tipologia'] = $row['tipologia'];
    $_SESSION['credito'] = $row['credito'];
    header("Location: index.php");
   } else {
    $errMSG = "Credenziali errate...";
   }
  }
 }
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>99Tickets - Login</title>

  <link rel="shortcut icon" type="image/png" href="img/header/logo.png">

  <link type="text/css" rel="stylesheet" href="magicscroll-trial/magicscroll/magicscroll.css"/>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=B612:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="index.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body class="nice-bg d-flex align-items-center">
  <div class=" mx-auto d-flex align-items-center rounded" style="border-style: solid; border-color: #1db954; max-width: 500px; background-color: #121212;"> <article class="card-body mx-auto" style="max-width: 400px; min-width:300px">
    <div class="align-item-center d-flex justify-content-around">
      <a href="index.php">
        <div class="my-3" style="font-size:5vw;"> <img class="" style="margin: 2%;" src="img/header/logo.png" alt="99Tickets" width="75vw">
        </div>
      </a>
    </div>
    <span class="text-danger"><?php echo "<span style=\"color:red\"> $errMSG </span>" ?></span>
     <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
      <div class="form-group input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-user"></i> </span>
        </div>
        <label hidden for="email">La tua email</label>
        <input id="email" name="email" class="form-control" placeholder="Email" type="text">
      </div>
      <span class="text-danger"><?php echo "<span style=\"color:red\"> $emailError </span>" ?></span>
      <div class="form-group input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        </div>
        <label hidden for="pass">La tua password</label>
        <input id ="pass" name="pass" class="form-control" placeholder="Inserisci Password" type="password">
      </div> <!-- form-group// -->
      <span class="text-danger"><?php echo "<span style=\"color:red\"> $passError </span>" ?></span>
      <div class="form-group">
        <button name="btn-login" type="submit" class="form-button btn btn-block">Login</button>
      </div> <!-- form-group// -->
      <p class="text-center">Non hai un account?<a href="register.php">Registrati ora</a> </p>
    </form>
  </article>
</div>
</body>
</html>
