<?php if(!isset($_SESSION)) session_start(); ?>
<!-- The page of a product with all its data -->
<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src="script-product.js">
 </script>
<head>
  <meta charset="utf-8">
  <link href="css/prime.css" rel="stylesheet" type="text/css" />
  <link href="css/style-product.css" rel="stylesheet" type="text/css" />
  <title>ALCA - Product Page</title>
  <?php
  $id = $_GET['id'];
  $result= $conn->query("SELECT * FROM products WHERE id=$id");
  include "transaction.php";
  $rslt_bid=$conn->query("SELECT * FROM best_bid WHERE id_product=$id");
  $product = $result->fetch_assoc();
  $id_seller=$product['id_seller'];
  $rslt3=$conn->query("SELECT username FROM user WHERE id=$id_seller");

  $bid = $rslt_bid->fetch_assoc();
  $seller=$rslt3->fetch_assoc();


 $rslt3=$conn->query("SELECT * FROM `chat` WHERE id_product=$id");
 if($rslt3->num_rows === 0)
 {
   $bestofferstatut='yes';
 }
 else
 {
   $bestofferstatut='no';
 }
 $rslt4=$conn->query("SELECT * FROM `sold_products` WHERE id_product=$id");
 if($rslt4->num_rows === 0)
 {
   $soldstatut='no';
 }
 else
 {
   $soldstatut='yes';
 }?>
</head>
<body>
<?php include 'popUp.php' ?>
<?php include "navbar.php"; ?>


  <div class="container">
    <div class="otherimg">
      <table>
        <?php $pic=$product["Pictures"];
             for($i=0;$i<4;$i++)
              {
                echo "<tr><td><img  src='watchesimg/$pic' width='140' height='140'></td></tr>";
              }
        ?>
      </table>
    </div>

  <div class="left">
      <titleproduct><?php echo $product["Name"];?></titleproduct>
      <h3><a href="/sellersprofil.php?id_seller=<?php echo $id_seller ?>&id_product=<?php echo $id ?>" >Sell by <?php echo $seller['username'] ?></a></h3>
      <?php $pic=$product["Pictures"];
          echo " <img id='product-img' src='watchesimg/$pic' width='440' height='440'>"
      ?>
  </div>

  <div class="right" value="<?php echo $soldstatut ?>">
        <div id="actionuser">
        <center>
        <form class="" onsubmit="return checkLogedIn(this)">
          <h1>Price</h1><br>
          <div id="product-price">
            <?php echo $Price=$product["Price"];?> $<br>
          </div>
          <input id="buyn" class="but-product" type="submit" name="buy" value="Buy now"> <br>
          <input class="but-product" type="submit" name="cart" value="Add to cart"> <br>

          <div id="notpermited" value="<?php echo $bestofferstatut ?>">
          <h1>Or</h1> <br>
          <h1>Best bid <br> <?php echo $bid['offer']; ?>$</h1>
          <h3>END <br> <?php echo $bid['stop_time']; ?> </h3>
          <input class="but-product" type="submit" name="bet" value="Make Offer"> <br>
          <input id="offert-input" type="number" name="offer" value="" min="0"  >
          </div>

          <input type="hidden" name="id" value="<?php echo $id; ?>">
        </form>
      </div>
      <div id="soldout" display="hidden">
        <img id="imgsoldout" src="/img/sold.png" alt="sold out" height="500px" width="500px">
      </div>
        </center>
    </div>


  </div>
  <br>

  <h3>Product Description</h3>
  <div class="description">
    <?php $description=$product["Description"];
    echo $description;
    ?>
  </div>

</body>
</html>
<script type="text/javascript">

statut=$("#notpermited").attr("value");
statutsold=$(".right").attr("value");

if(statut=='no')
{
  $("#notpermited").hide();
}else
{
$("#notpermited").show();
}

if(statutsold=='no')
{
  $("#actionuser").show();
  $("#soldout").hide();
}else
{
  $("#actionuser").hide();
  $("#soldout").show();
}

</script>
