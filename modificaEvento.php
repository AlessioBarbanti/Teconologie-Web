<?php
ob_start();
session_start();
require_once 'dbconnect.php';

$path = "https://api.telegram.org/bot1084851894:AAGAFI3xZFKk7u9tL-tpDIiMLkXeJLxTA9A";

if ((!isset($_SESSION['utente'])) || ($_SESSION['tipologia']=='0')) {
  header("Location: index.php");
  exit;
}

$idUtente = $_SESSION['utente'];
$resSelect = mysqli_query($conn, "SELECT id, titolo FROM concerto WHERE IDorganizzatore='$idUtente'");

if(isset($_POST['btn']) ) {

  $uploaddir = 'upload/';

      //Recupero il percorso temporaneo del file
      $userfile_tmp = $_FILES['immagine']['tmp_name'];

      //recupero il nome originale del file caricato
      $userfile_name = $_FILES['immagine']['name'];

      if (!file_exists($userfile_name)) {
        move_uploaded_file($userfile_tmp, $uploaddir . $userfile_name);
      }
      //copio il file dalla sua posizione temporanea alla mia cartella upload



  $titolo = htmlspecialchars(strip_tags(trim($_POST['titolo'])));
  $luogo = htmlspecialchars(strip_tags(trim($_POST['luogo'])));
  $descrizione = htmlspecialchars(strip_tags(trim($_POST['descrizione'])));
  $data = $_POST['data'];
  $ora = $_POST['ora'];
  $n_biglietti = $_POST['n_biglietti'];
  $prezzo = $_POST['prezzo'];
  $immagine = $_FILES['immagine']["name"];

  if($_POST['select']=="nuovo"){
    if(($titolo=="") || ($data==0000-00-00) || ($luogo=="") || ($n_biglietti<=0) || ($prezzo<=0) || ($descrizione=="") || ($immagine=="")){
      $errMSG = "Tutti i campi devono essere riempiti con valori positivi";
    }else{
      $queryInsert = "INSERT INTO concerto (titolo, luogo, data, ora, prezzo, n_biglietti, descrizione, immagine, IDorganizzatore)
      VALUES('$titolo', '$luogo', '$data', '$ora', '$prezzo', '$n_biglietti', '$descrizione', '$immagine', '$idUtente')";
      $resInsert = mysqli_query($conn, $queryInsert);

      if ($resInsert) {
        $successMSG = "Concerto generato con successo";
      } else {
        $errMSG = "Qualcosa è andato storto, riprovare più tardi... ";
      }
      unset($resInsert);
    }

  }else{
    $IDconcerto = $_POST['select'];

    $resVuoto = mysqli_query($conn, "SELECT titolo, data, ora, luogo, n_biglietti, prezzo, descrizione, immagine FROM concerto WHERE id='$IDconcerto'");
    $rowVuoto=mysqli_fetch_array($resVuoto);

    if($titolo==""){
      $titolo=$rowVuoto['titolo'];
    }if($data==0000-00-00){
      $data=$rowVuoto['data'];
    }if($ora==0){
      $ora=$rowVuoto['ora'];
    }if($luogo==""){
      $luogo=$rowVuoto['luogo'];
    }if($n_biglietti==0){
      $n_biglietti=$rowVuoto['n_biglietti'];
    }if($prezzo==0){
      $prezzo=$rowVuoto['prezzo'];
    }if($descrizione==""){
      $descrizione=$rowVuoto['descrizione'];
    }if($immagine==""){
      $immagine=$rowVuoto['immagine'];
    }



    $queryUpdate = "UPDATE concerto SET titolo='$titolo', data='$data', ora='$ora', luogo='$luogo', n_biglietti='$n_biglietti',
    prezzo='$prezzo', descrizione='$descrizione', immagine='$immagine' WHERE id='$IDconcerto'";
    $resUpdate = mysqli_query($conn, $queryUpdate);

    if ($resUpdate) {
      $successMSG = "Concerto modificato con successo";

      $resNotif = mysqli_query($conn, "SELECT telegram FROM utente WHERE ID IN
      (SELECT id_utente FROM biglietto WHERE id_concerto = '$IDconcerto')");

      $message = "Il concerto per il quale hai acquistato il biglietto è stato modificato";

      while($rowNotif=mysqli_fetch_array($resNotif)){
        $chatID = $rowNotif['telegram'];
        file_get_contents($path."/sendmessage?chat_id=" . $chatID . "&text=". $message);
      }

    } else {
      $errMSG = "Qualcosa è andato storto, riprovare più tardi... ";
    }
    unset($resUpdate);
  }
} ?>

<html lang="it" dir="ltr" style="height: 100%;">
<head>
  <meta charset="utf-8">
  <title>99Tickets - Modifica Evento</title>

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
<body class="nice-bg" style="">
<?php require_once ("header.php") ?>

  <div class=" mx-auto my-auto d-flex align-items-center rounded w-50 my-auto" style="min-width:300px; border-style: solid; border-color: #1db954; background-color: #121212">
    <article class="card-body mx-auto" style="margin-top: 80px">
      <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="form-group">
          <label for="select" hidden>Seleziona l'azione</label>
          <select name="select" id="select" required>
            <option value="nuovo">Nuovo Concerto</option>
            <?php if ($resSelect->num_rows > 0) { ?>
              <optgroup label="Modifica i tuoi Eventi">
                <?php while($rowSelect = mysqli_fetch_array($resSelect)) {?>
                  <option value="<?php echo $rowSelect["id"]; ?>"><?php echo $rowSelect["titolo"]; ?></option>
                <?php  }
              } $conn->close(); ?>
            </select>
          </div>


          <div class="form-group">
            <label for="titolo">Titolo:</label>
            <input  class="form-control" id="titolo" type="text" name="titolo">
          </div>
          <div class="form-group">
            <label for="fileName">Carica Immagine:</label>
            <input  class="form-control" type="file" name="immagine" id="fileName" accept=".jpg,.jpeg,.png" onchange="validateFileType()"/>
          </div>
          <div class="form-group">
            <label for="dt">Data concerto:</label>
            <input class="form-control" id="dt" type="date" name="data">
          </div>
          <div class="form-group">
            <label for="ora">Ora concerto:</label>
            <input  class="form-control" type="time" id="ora" name="ora">
          </div>
          <div class="form-group">
            <label for="luogo">Luogo:</label>
            <input  class="form-control" id="luogo" type="text" name="luogo">
          </div>
          <div class="form-group">
            <label for="n_biglietti">Biglietti disponibili:</label>
            <input  class="form-control" type="number" id="n_biglietti" name="n_biglietti">
          </div>
          <div class="form-group">
            <label for="prezzo">Prezzo del biglietto:</label>
            <input class="form-control" type="number" id="prezzo" name="prezzo">
          </div>
          <div class="form-group">
              <label for="descrizione">Descrizione concerto:</label>
              <input class="form-control" id="descrizione" type="text" name="descrizione">
          </div>

          <button class="form-button btn float-left float-sm-right" name="btn" type="submit">Conferma</button>
        </form>
        <div class="text-danger"><?php echo "<span style=\"color:red\"> $errMSG </span>" ?></div>
        <div class="text-danger"><?php echo "<span style=\"color:green\"> $successMSG </span>" ?></div>
        <script type="text/javascript">
        function validateFileType(){
          var fileName = document.getElementById("fileName").value;
          var idxDot = fileName.lastIndexOf(".") + 1;
          var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
          if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
          }else{
            alert("Only jpg/jpeg and png files are allowed!");
          }
        }
        </script>
      </article>
    </div>
  </body>
  </html>
