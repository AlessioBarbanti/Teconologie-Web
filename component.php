
<?php

function concert1($titolo, $img, $id){
    $element="
    <a href='#modal".$id."' data-toggle='modal'><img class='img-fluid' alt='$titolo' src='$img' alt='$titolo' longdesc='$titolo'></a>";
    echo $element;
}

function concert2($titolo, $img, $id){
    $element="
    <a href='#modal$id' data-toggle='modal'> <img class='img-fluid' alt='$titolo' src='$img' alt='$titolo' longdesc='$titolo'></a>";
    echo $element;
}

function concert3($titolo, $img, $id){
    $element="
    <a href='#modal$id' data-toggle='modal'> <img class='img-fluid' alt='$titolo' src='$img alt='$titolo' longdesc='$titolo''></a>";
    echo $element;
}

function modalAvailable($titolo,$luogo, $data, $ora, $price, $img, $descrizione, $id){
    $element="
    <div class='modal fade' id='modal$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
  <div class='modal-dialog modal-lg' role='document'>
    <div class='modal-content' style='border-style: solid; border-color: #1db954;  background-color: #121212;' >
      <div class='modal-body'>
        <div id='ConcertShowDiv'class=' mx-auto my-3 d-block align-items-center rounded'>
          <div class='' style='background-color: inherit;'>


            <div class='m-5'>
              <form action='' method='post'>
              <div class='col-12 container-fluid text-center'>
                <button type='button' class='close float-right' data-dismiss='modal' aria-label='Close'>
                  <span style='color: #818181'>&times;</span>
                </button>
                <img class='img-fluid my-5'  alt='$titolo' src='$img' alt='$titolo' longdesc='$titolo'>

              </div>
              <div class='row justify-content-between'>
                <div class='col-sm-12 col-xl-6'>
                  <h1>$titolo</h1>
                </div>
                <div class='col-sm-12 col-xl-3'>
                  <p>Data: $data alle $ora</p>
                </div>
                <div class='col-sm-12 col-xl-3'>
                  <p>Luogo: $luogo</p>
                </div>
              </div>
              <h2>Descrizione:</h2>
              <p>$descrizione</p>
              <button type='button' data-dismiss='modal' name='chiudi' class='form-button btn float-left my-5'>Chiudi</button>
              <button type='submit' name='add' class='form-button btn float-right my-5'>Ordina ora!</button>
              <input type='hidden' name = 'id' value='$id'>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>";
    echo $element;
}

function modalSoldOut($titolo,$luogo, $data, $ora, $price, $img, $descrizione, $id){
  $element="
  <div class='modal fade' id='modal$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
<div class='modal-dialog modal-lg' role='document'>
  <div class='modal-content' style='border-style: solid; border-color: #1db954;  background-color: #121212;' >
    <div class='modal-body'>
      <div id='ConcertShowDiv'class=' mx-auto my-3 d-block align-items-center rounded'>
        <div class='' style='background-color: inherit;'>


          <div class='m-5'>
            <form action='' method='post'>
            <div class='col-12 container-fluid text-center'>
              <button type='button' class='close float-right' data-dismiss='modal' aria-label='Close'>
                <span style='color: #818181'>&times;</span>
              </button>
              <img class='img-fluid my-5'  alt='$titolo' src='$img' alt='$titolo' longdesc='$titolo'>

            </div>
            <div class='row justify-content-between'>
              <div class='col-sm-12 col-xl-6'>
                <h1>$titolo</h1>
              </div>
              <div class='col-sm-12 col-xl-3'>
                <p>Data: $data alle $ora</p>
              </div>
              <div class='col-sm-12 col-xl-3'>
                <p>Luogo: $luogo</p>
              </div>
            </div>
            <h2>Descrizione:</h2>
            <p>$descrizione</p>
            <button type='button' data-dismiss='modal' name='chiudi' class='form-button btn float-left my-5'>Chiudi</button>
            <button type='submit' name='add' class='d-none form-button btn float-right my-5' disabled>Ordina ora!</button>
            <input type='hidden' name = 'id' value='$id'>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>";
  echo $element;
}

function component($name,$luogo, $data, $ora, $sale, $price, $img, $id){
    $element="
    <div class='col-md-4 col-sm-6 my-3 my-md-0'>
            <form action='index.php'method='post'>
                <div class='cart shadow'>
                    <div>
                        <img src='$img' alt='' class='img-fluid card-img-top' alt= '$title' longdesc='$title'>
                    </div>
                    <div class='card-body bg-dark'>
                        <h5 class='card-title'>$name</h5>
                        <p class='cart-text'>
                           'A $luogo in data $data alle $ora'
                        </p>
                        <h5>
                            <small><s>$sale $</s></small>
                            <span class='price'>$price $</span>
                        </h5>

                        <button type='submit' class='btn btn-warning my-3' name='add'>Aggiungi al carrello <i class='fas fa-shopping-cart'></i></button>
                        <input type='hidden' name = 'id' value='$id'>
                    </div>
                </div>
            </form>
        </div>
    ";
echo $element;
}


function cartElem($img, $name, $price, $id){
    $element="

        <form class=' m-3 container-fluid cart-items rounded' action='cart.php?action=remove&id=$id' method='post' style='border-color: #1db954; border-style: solid; border-color: #1db954;'>
        <div class='my-5 '>
            <div class='row'>
                <div class='col-sm-4' style='height: 300px; width: 300px'>
                    <img src='$img' alt='' class='img-fluid' alt= '$name' longdesc='$name'>
                </div>
                <div class='col-sm-4 text-center'>
                    <h5 class='pt-2 text-center'>$name</h5>
                    <h5 class='pt-2 text-center'>$price $</h5>
                    <button type='submit' class='btn btn-danger' name='remove'>Rimuovi</button>
                </div>
                <div class='col-sm-4 py-5'>

    ";
echo $element;
}

function historyElem($img, $name, $price, $eventDate,$eventHour, $buyDate){
  $element="
  <div class=' my-3 mx-auto d-flex align-items-center rounded w-75 container-fluid' style='border-style: solid; border-color: #1db954;'>
      <div class='row d-fle align-item-center'>
        <div class='col-sm-12 col-xl-6'>
            <img class='img-fluid my-5 w-75'  alt='$name' src='$img'>
        </div>
        <div class='col-sm-12 col-xl-6 my-5'>
          <div class='col'>
            <h1>$name</h1>
          </div>
          <div class='col'>
            Prezzo: $price
          </div>
          <div class='col'>
            <h2>Data Evento: $eventDate alle $eventHour</h2>
          </div>
          <div class='col'>
            <h2>Data Acquisto: $buyDate</h2>
          </div>
        </div>
      </div>
    </div>
  ";
echo $element;
}

function allElem($title, $img, $id){
  $element="
        <tr>
            <td class='align-middle'>
              <p style='font-size: 3vw;'>$title</p>
              <a href='#modal".$id."' data-toggle='modal'><img class='img-fluid' src='$img' alt='$title' longdesc='$titolo'style=''></a>
            </td>
        </tr>
  ";
echo $element;
}
?>
