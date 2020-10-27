

<?php

include_once 'dbconnect.php';

$path = "https://api.telegram.org/bot1084851894:AAGAFI3xZFKk7u9tL-tpDIiMLkXeJLxTA9A";
$update = json_decode(file_get_contents("php://input"), TRUE);
$chatId = $update["message"]["chat"]["id"];
$nome =$update["message"]["chat"]["first_name"];
$message = $update["message"]["text"];

if (strpos($message, "/start") === 0) {
  file_get_contents($path."/sendmessage?chat_id=".$chatId."&parse_mode=HTML&text=Ciao <b>$nome</b>, Benvenuto nella tua newsletter personale di 99Tickets!");
  file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Con quale mail ti sei iscritto/a a 99Tickets?");
  file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Diccelo digitando /email seguito dalla tua Mail di registrazione!");
}




if (strpos($message, "/email") === 0) {
  $email = substr($message, 7);

  $query = "UPDATE utente SET `telegram` = $chatId WHERE `email`='$email'";
  $res = mysqli_query($conn, $query);
  $ar = mysqli_affected_rows($conn);
  if ($ar == -1) {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Errore!");

  }
  if ($ar == 1){
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Mail Aggiornata con successo!");
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Ora sei pronto a ricevere gli aggiornamenti riguardo i tuoi ordini ed eventi!");
  }
  if ($ar == 0){
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Nessuna Mail trovata!");
  }
}

if (strpos($message, "/balance") === 0) {
  $query = "SELECT `credito` FROM `utente` WHERE `telegram`=$chatId LIMIT 1";
  $res = mysqli_query($conn, $query);
  $rec = $res -> fetch_array(MYSQLI_ASSOC);
  file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Il tuo credito attuale è ".$rec['credito']);

}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <h1><?php  echo var_dump($res); ?></h1>
</body>
</html>
