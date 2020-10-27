

  <div id="Sidenav" class="sidenav text-nowrap">
    <a class="closeNavBtn" onclick="closeNav()">&times;</a>

    <div class="mx-auto w-25 align-content-center">
      <?php if(isset($_SESSION['utente'])){?><img class="m-2" src="img/header/coin.ico" alt="Saldo Attuale" width="30vw" height="30vw"><p><?php echo($_SESSION['credito']);} ?></p>
    </div>

    <a href="index.php">Pagina Iniziale</br></a>
    <a href="Account.php">Il mio Account</a>
    <a href="Ordini.php">Ordini Effettuati</br></a>

    <?php if ((isset($_SESSION['tipologia'])) && ($_SESSION['tipologia']!='0')) { ?>
        <a href="modificaEvento.php">Concerti</a>
    <?php } ?>

    <a <?php if(isset($_SESSION['utente'])){ ?> href="cart.php" <?php }else{ ?> href="login.php" <?php } ?> >Carrello</a>


    <?php if(isset($_SESSION['utente'])){ ?> <a href="logout.php">Logout</a> <?php }else{ ?>
    <a href="login.php">Login</a> <?php } ?>



  </div>
