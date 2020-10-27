<?php
  ob_start();
  session_start();
  unset($_SESSION['utente']);
  unset($_SESSION['tipologia']);
  unset($_SESSION['credito']);
  unset($_SESSION['nome']);
  session_destroy();
  header("Location: index.php");
?>
