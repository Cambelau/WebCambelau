<?php
//The checkout page where you can pay buy entering your card informations etc...
session_start();
include 'database.php';?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src="script-product.js">
</script>
<head>
  <meta charset="utf-8">
  <link href="css/prime.css" rel="stylesheet" type="text/css" />
  <title>ALCA</title>
</head>

<body>
<?php include "navbar.php"; ?>
  <div class="container">
    <div class="left">
      <center>
        <table>
          <tr>
            <td> <h1>Your total : <?php  echo $_GET['total']."$"; ?> </h1></td>
          </tr>
        </table>
      </center>
    </div>
    <div class="right">
      <form class="" action="index.html" method="post">
        <center>
          <table>
            <tr><td>Paypal</td><td><input type="radio" name="o" value=""> <br></td><tr>
              <tr><td>SEPA</td><td><input type="radio" name="o" value=""> <br></td><tr>
                <tr><td>Cart</td><td> <input type="radio" name="o" value=""> <br></td><tr>
                  <tr><td>Number </td><td> <input type="text" name="" value=""> <br></td><tr>
                    <tr><td>CVV </td><td> <input type="number" size="3" value=""> <br></td><tr>
                      <tr><td>Date </td><td> <input type="date" value=""><br></td><tr>
                        <tr><td colspan="2"><img src="/img/paysecure.png" alt="paysecure" width="400px" height="150px;"></td></tr>
                      </form>
                    </table>
                  </center>
                </div>
              </div>

              <?php
              $id_client=$_SESSION["id"];

              for($i = 0 ; $i < count($_SESSION['cart']) ; $i++){

                $tmp=$_SESSION['cart'][$i];
                $rslt=$conn->query("SELECT Price FROM `products` WHERE `id` = $tmp");
                $price=$rslt->fetch_assoc();
                $pri=$price['Price'];

                $requete= "INSERT INTO `sold_products` (`id`, `id_product`, `id_client`, `price`) VALUES (NULL,$tmp,$id_client,$pri)";
                $conn->query($requete);


              }
              $_SESSION['cart']=array();
              ?>
            </body>
            <style>
              .container
              {
                height: 500px;
                margin-top: 100px;
                display: flex;
                border: 2px solid black;
                background-color: white;
              }
              .container .left
              {
                flex: left;
                width: 50%;

              }
              .container .right
              {
                flex: left;
                width: 50%;
              }

              table
              {
               margin-top: 20px;
               color: black;
               border: 25px dotted  black;
               padding: 20px;
               background-color: #fff07c;
               height: 400px;
               width: 400px;
             }

           </style>
           </html>
