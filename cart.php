<?php
require_once("bootstrap.php");

$templateParam["concerti"] = $dbh->getConcert();

session_start();
require_once("component.php");

if (!isset($_SESSION['utente'])){
    header("Location: Login.php");
    exit;
  }

if(isset($_POST["remove"])){
        $id = $_GET["id"];
        foreach($_SESSION["cart"] as $key => $values){
            if($values["id"] == $id){
                unset($_SESSION["cart"][$key]);
            }
        }
}

if(isset($_POST["ordina"])){
    $cont = 0;
    if($_SESSION["total"] <= $_SESSION["credito"] && $_SESSION["total"] != 0){
        $dbh->updateCredit($_SESSION["credito_after"], $_SESSION["utente"]);
        unset($_SESSION["credito"]);
        if (isset($_SESSION['cart'])){
            $product_id = array_column($_SESSION['cart'], 'id');
            foreach ($templateParam["concerti"] as $concerto){
                foreach ($product_id as $id){
                    if ($concerto['id'] == $id){
                        $dbh->insertTicket($_SESSION["utente"],$concerto['id'] );
                        $dbh->updateTicketNumber($_SESSION["ids".$cont], $_SESSION["quantity".$cont]);
                        $cont++;
                    }
                }
                
            }
        }

        $id = 1;
        foreach($_SESSION["cart"] as $key => $values){
            if($values > 0){
                unset($_SESSION["cart"][$key]);
                $id++;
            }
        }
    }else{
        unset($_SESSION["total"]);
        echo '<script>alert("Non hai abbastanza credito")</script>';
    }
 }

 if(isset($_POST["indietro"])){
     unset($_SESSION["credito_after"]);
     unset($_SESSION["credito"]);
 }

$user = $dbh->getCredit($_SESSION["utente"]);
foreach ($user as $utente){
    $_SESSION["credito"] = $utente["credito"];
}

$_SESSION["total"] = 0;

?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <script>
    var ids = [];
    var cont = 0;
    </script>

</head>
<body onload="setInit();">
<?php require_once ("header.php") ?>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <div style="margin-top: 100px"><h5>Il Mio Carrello</h5></div>
                <hr>
                <?php
                $tot = 0;
                    if (isset($_SESSION['cart'])){
                        $product_id = array_column($_SESSION['cart'], 'id');
                        ?>


                        <?php foreach ($templateParam["concerti"] as $concerto):
                            foreach ($product_id as $id):
                                if ($concerto['id'] == $id){
                                    $tot = $tot + $concerto["prezzo"];
                                    cartElem(UPLOAD_DIR.$concerto["immagine"], $concerto["titolo"],$concerto["prezzo"], $id);
                                    ?>
                                    </form>
                                    <script>
                                     ids[cont] = <?php echo $id?>;
                                     cont++;
                                    </script>
                                    <div class="text-center">
                                        <input class='btn bg-light border rounded-circle' id = "bt-<?php echo $id?>" type='button' onclick="dec(<?php echo $id?>, <?php echo $concerto['prezzo']?>);" value = "-" ></input>
                                        <input class='form-control w-25 d-inline' name ='quantity' type='text' id=<?php echo $id?> value="1" disabled>
                                        <input class='btn bg-light border rounded-circle' id = "bt+<?php echo $id?>" type='button' onclick="inc(<?php echo $id?>, <?php echo $concerto['n_biglietti']?>, <?php echo $concerto['prezzo']?>);" value = "+" ></i></input>
                                    </div>
                                </div>
                            </div>
                        </div>

                                <?php
                                }
                            endforeach;
                        endforeach;

                    }else{

                        echo "<div style='margin-top: 50px'><h5>Non hai articoli nel carrello !</h5></div>";
                    }

                ?>
            </div>
        </div>

        <table class="table table-dark table-bordered col-md-4 offset-md-1 border rounded h-25" style="margin-top: 189px">
            <tr>
                <th>Dettagli Transazione</th>
            </tr>
            <br>
            <tr>
                <th><?php
                        if(isset($_SESSION["cart"])){
                            $count = count($_SESSION["cart"]);
                            echo "Prezzo ($count oggetto/i)";
                        }else{
                            echo "Prezzo (0 oggetto)";
                        }
                    ?></th>
                <td class="text-center"><p id="tot"></p></td>
            </tr>
            <br>
            <tr>
                <th>Spedizione</th>
                <td class='text-success text-center'>GRATUITA</td>
            </tr>
            <br>
            <tr>
                <th>Totale</th>
                <td class="text-center"><p id="tot2"></p></td>
            </tr>
            <tr>
                <th></th>

                <td>
                    <form id="sendForm" method = "post"  action='checkout.php' class="text-center">
                        <button type='submit' onclick="send();" name="paga" class='btn pb-2 bg-light border rounded-circle'><i class='fa fa-shopping-cart'></i> PAGA</button>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
        var totale = <?php echo $tot?>;
        var url = "";
        function setInit(){
            document.getElementById("tot").innerHTML = "$" + totale;
            document.getElementById("tot2").innerHTML = "$" + totale;
        }
        function inc(id, max, prezzo){
            if(document.getElementById(id).value < max){
                document.getElementById(id).value++;
                totale = totale + prezzo;
                document.getElementById("tot").innerHTML = "$" + totale;
                document.getElementById("tot2").innerHTML = "$" + totale;
            }

        }
        function dec(id, prezzo){
            if(document.getElementById(id).value > 1){
                document.getElementById(id).value--;
                totale = totale - prezzo;
                document.getElementById("tot").innerHTML = "$" + totale;
                document.getElementById("tot2").innerHTML = "$" + totale;
            }
        }
        function send(){
            url = "checkout.php?total=" + totale;
            for(var i = 0; i < ids.length; i++){
                url = url + "&quantity" + i + "=" +  document.getElementById(ids[i]).value + "&id" + i + "=" + ids[i];
            }
            url = url + "&number=" + ids.length;
            document.getElementById("sendForm").action = url;
        }
    </script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
