<?php
require_once("bootstrap.php");
session_start();

if (!isset($_SESSION['utente'])){
  header("Location: Login.php");
  exit;
}

if(isset($_GET["total"])){
  $_SESSION["number"] = $_GET["number"];
  $_SESSION["total"] = $_GET["total"];
  $_SESSION["credito_after"] = $_SESSION["credito"] - $_SESSION["total"];
  $_SESSION["credito_after"] = $_SESSION["credito"] - $_SESSION["total"];
  for($i = 0; $i < $_SESSION["number"]; $i++){
    $_SESSION["quantity".$i] = $_GET["quantity".$i];
    $_SESSION["ids".$i] = $_GET["id".$i];
  }
}





$templateParam["ids"] = $dbh->getShippingId();
//aggiorno i dati se esistono già o li salvo nel caso siano nuovi
if(isset($_POST["save"])){
  foreach ($templateParam["ids"] as $id){
    if($id["id_utente"] == $_SESSION["utente"]){
      $dbh->updateShipping($_SESSION["utente"], $_POST["nome"], $_POST["cognome"], $_POST["indirizzo"], $_POST["zip"], $_POST["telefono"], $_POST["email"]);
    }
  }
    if(!$_POST["nome"] == "" && !$_POST["cognome"] == "" && !$_POST["indirizzo"] == "" && !$_POST["zip"] == "" && !$_POST["telefono"] == "" && !$_POST["email"] == ""){
        $dbh->insertShipping($_SESSION["utente"], $_POST["nome"], $_POST["cognome"], $_POST["indirizzo"], $_POST["zip"], $_POST["telefono"], $_POST["email"]);
        $templateParam["dati"] = $dbh->getShipping($_SESSION["utente"]);
        foreach ($templateParam["dati"] as $dato){
            $_POST["nome"] = $dato["nome"];
            $_POST["cognome"] = $dato["cognome"];
            $_POST["indirizzo"] = $dato["indirizzo"];
            $_POST["zip"] = $dato["zip"];
            $_POST["telefono"] = $dato["telefono"];
            $_POST["email"] = $dato["email"];
        }
        unset($_POST["save"]);
    }
    echo '<script>alert("Dati Salvati!\n Aggiorna la pagina se non li vedi")</script>';
}

$_POST["nome"] = "";
$_POST["cognome"] = "";
$_POST["indirizzo"] = "";
$_POST["zip"] = "";
$_POST["telefono"] = "";
$_POST["email"] = "";

foreach ($templateParam["ids"] as $id){
    if($id["id_utente"] == $_SESSION["utente"]){
        $templateParam["dati"] = $dbh->getShipping($_SESSION["utente"]);
        foreach ($templateParam["dati"] as $dato){
            $_POST["nome"] = $dato["nome"];
            $_POST["cognome"] = $dato["cognome"];
            $_POST["indirizzo"] = $dato["indirizzo"];
            $_POST["zip"] = $dato["zip"];
            $_POST["telefono"] = $dato["telefono"];
            $_POST["email"] = $dato["email"];
        }
    }
}


?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=B612:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="index.css">
  <script src="checkout.js"></script>

  <script>
    window.onload=function(){
      history.pushState(window.location.href, null, "checkout.php")
    }

  </script>

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Checkout</title>
</head>
<body class="nice-bg py-5" style="  height: auto" >
  <div class=" mx-auto my-auto d-inblock align-items-center rounded w-75" style="border-style: solid; border-color: #1db954; background-color: #121212">
    <article class="card-body mx-auto">
      <div class="align-item-center d-flex justify-content-around">
        <a href="index.php">
          <div class="" style="font-size:5vw;"> <img class="" style="margin: 2%;" src="img/header/logo.png" alt="99Tickets" width="75vw">
          </div>
        </a>
      </div>

      <h2 class=" mt-3">Dati Fatturazione</h2>
      <form class="w-100" method="post">

        <div class="form-group input-group">

          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
          </div>
          <label hidden for="nome">Il tuo nome</label>
          <input id="nome" name="nome" class="form-control" placeholder="Nome" value="<?php echo $_POST["nome"] ?>" type="text">
        </div>

        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
          </div>
          <label hidden for="cognome">Il tuo cognome</label>
          <input id="cognome" name="cognome" class="form-control" placeholder="Cognome" value="<?php echo $_POST["cognome"] ?>" type="text">
        </div>

        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
          </div>
          <label hidden for="indirizzo">Il tuo indirizzo</label>
          <input id="indirizzo" name="indirizzo" class="form-control" placeholder="Indirizzo" value="<?php echo $_POST["indirizzo"] ?>" type="text">
        </div>
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
          <label hidden for="zip">Il codice postale</label>
          <input id="zip" name="zip" class="form-control" placeholder="Cap" value="<?php echo $_POST["zip"] ?>" type="number">
        </div>
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
          <label hidden for="telefono">Il tuo telefono</label>
          <input id="telefono" name="telefono" class="form-control" placeholder="Telefono" value="<?php echo $_POST["telefono"] ?>" type="tel">
        </div>
        <div class="form-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
          </div>
          <label hidden for="email">La tua email</label>
          <input id="email" name="email" class="form-control" placeholder="Email" value="<?php echo $_POST["email"] ?>" type="email">
        </div>
        <div class="form-group">
          <button type="submit" name="save" class="form-button btn btn-block">Save the Data!</button>
        </div>
      </form>
    </article>
    <article class="card-body mx-auto">
      <div class="panel panel-info">
        <div class="panel-body">
          <div class="form-group">
          <!--<h1 class="d-inline ml-3"><p class="fa fa-lock mr-2"></p>Pagamento Sicuro</h1>-->
          <div class="row ml-3">
          <h3><p class="fa fa-lock"></p>&emsp;Pagamento Sicuro</h3>
          </div>
            <div class="col-md-12"><h1>Tipo di pagamento:</h1></div>
            <div class="col-md-6">
              <select id="CreditCardType" name="CreditCardType" class="form-control">
                <option value="1">Conto Account</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="text-left"><h3 style="font-size:1.5rem">Credito: <?php echo $_SESSION["credito"] ?></h3></div>
            <div class="text-left"><h3 style="font-size:1.5rem">Nuovo Credito:  <?php echo $_SESSION["credito_after"] ?></h3></div>
          </div>
          <div class="form-row mx-5 text-center">

            <div class="col-12 col-sm-6 mr-auto mt-4">
              <form method="post" action="cart.php">
                <button type="submit" name= "indietro" class="form-button btn">Indietro</button>
              </form>
            </div>

            <div class="col-12 col-sm-6 ml-auto mt-4">
              <form method = "post" action="cart.php">
                <button type="input" onclick ="return IsEmpty();" name="ordina" class="form-button btn">Ordina!</button>
              </form>
            </div>
        </div>
      </div>
    </article>
  </div>
</body>
</html>
