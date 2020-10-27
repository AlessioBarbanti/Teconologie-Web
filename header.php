<script src="index.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=B612:wght@700&display=swap" rel="stylesheet">
<script src="index.js"></script>



<header class="container-fluid position-sticky" style="z-index: 993; ">
  <!--Solo su mobile-->
  <div class= "navbar d-flex d-sm-none " style="">
    <div class="nav-item" style="font-size:5vw;"> <img class="float-left" src="img/header/hamb.png" alt="Left Menu" width="30vw" onclick="openNav()"></img></div>
    <div class="nav-item" style="font-size:5vw;"> <a href="index.php"><img src="img/header/logo.png" alt="99Tickets" width="50vw"></a></div>
    <div class="nav-item"> <a href="account.php"><img class="float-right" src="img/header/account_logo.png" alt="Account" width="30vw" onClick= "sendTelegramMessage();"></a></div>
  </div>

  <!--Solo su fisso-->

  <nav class="navbar navbar-expand-sm">
    <a class=" d-none d-sm-flex mx-2" href="index.php"><img class="" style="margin: 2%;" src="img/header/logo.png" alt="99Tickets" width="50vw"></a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mx-2">
        <li class="nav-item">
          <a class="nav-link" href="Account.php">Account</a>
        </li>
        <li class="nav-item">

          <a class="nav-link" <?php if(isset($_SESSION['utente'])){?> href="Ordini.php" <?php }else{ ?> href="Login.php" <?php } ?>>Ordini</a>
        </li>

        <?php if ((isset($_SESSION['tipologia'])) && ($_SESSION['tipologia']!='0')) { ?>
          <li class="nav-item">
            <a class="nav-link" href="modificaEvento.php">Concerti</a>
          </li>
          <?php } ?>
          <?php if ((isset($_SESSION['tipologia'])) && ($_SESSION['tipologia']=='2')) { ?>
            <li class="nav-item">
              <a class="nav-link" href="admin.php">RankUp!</a>
            </li>
            <?php } ?>
      </ul>
      <ul class="navbar-nav w-100 navbar-expand-sm">

      </ul>
      <ul class="navbar-nav mx-2 d-flex align-items-center">
        <li class="nav-item">
          <a class="nav-link" <?php if(isset($_SESSION['utente'])){ ?> href="cart.php" <?php }else{ ?> href="login.php" <?php } ?> >Carrello</a>
        </li>
        <div class="nav-item align-content-center">
          <li class="mx-4 d-flex align-text-center">
            <?php if(isset($_SESSION['utente'])){?><img class="m-2" src="img/header/coin.ico" alt="Saldo Attuale" width="25vw" height="25vw"><p class="my-2"><?php echo($_SESSION['credito']);} ?></p>
          </li>
        </div>

        <li class="nav-item mx-auto">
          <?php if(isset($_SESSION['utente'])){?><a class="nav-link" href="logout.php">Logout</a> <?php }else{ ?>
          <a class="nav-link" href="login.php">Login</a> <?php } ?>
        </li>
      </ul>
    </div>
  </nav>


  <?php require_once ("Sidenav.php"); ?>
  <?php require_once ("dbconnect.php"); ?>


  <?php if ($_SESSION['utente'] ){
    $idUtente = $_SESSION['utente'];
    $resTele = mysqli_query($conn, "SELECT telegram FROM utente WHERE ID='$idUtente'");
    $rowTele=mysqli_fetch_array($resTele);
    $chatIDutente = $rowTele['telegram'];
    if($chatIDutente == ""){
      require_once ("popOverTelegram.php");
    }
  }?>
</header>
