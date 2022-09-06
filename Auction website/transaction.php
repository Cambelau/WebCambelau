<!-- Transactions, bets and auctions process -->
<?php

if(isset($_GET['bet']) && isset($_SESSION["loggedin"])){
betsystem($conn);
}

if(isset($_GET['buy']) && isset($_SESSION["loggedin"])){
$idtmp=$_GET['id'];
$rest= $conn->query("SELECT Price FROM products WHERE id=$idtmp");
$producttmp=$rest->fetch_assoc();
buynow($conn,$producttmp['Price']);
}

if(isset($_GET['cart'])){
addcart($conn);
}

function buynow($conn,$price)
{
  $id_product=$_GET['id'];
  $id_client=$_SESSION["id"];


  $requete= "INSERT INTO `sold_products` (`id`, `id_product`, `id_client`, `price`) VALUES (NULL, $id_product,$id_client,$price)";
  $conn->query($requete);
  echo '
      <script type="text/javascript">',
     'buynotif(1,'.$price.');',
     '</script>';


}
function addcart($conn)
{
   $id_product=$_GET['id'];
   array_push($_SESSION['cart'],$id_product);
   echo '<script type="text/javascript">',
      'buynotif(2);',
      '</script>';
}


function betsystem($conn)
{
  $offer=$_GET['offer'];
  $id_product=$_GET['id'];
  $id_client=$_SESSION["id"];

  $result= $conn->query("SELECT * FROM best_bid WHERE id_product=$id_product");
  $product = $result->fetch_assoc();
  $best_bid=$product['offer'];

  if($best_bid<$offer)
  {

    $newsql="UPDATE all_bid SET statut = 'false' WHERE id_product = $id_product";
    $conn->query($newsql);

    $requete= "INSERT INTO `all_bid` (`id`, `id_product`, `id_client`,`price_offer`,`statut`) VALUES (NULL,$id_product,$id_client,$offer,'true');";
    $conn->query($requete);

    $newsql="UPDATE best_bid SET offer = $offer WHERE id_product = $id_product";
    $newsql2="UPDATE best_bid SET id_client = $id_client WHERE id_product = $id_product";
    $conn->query($newsql);
    $conn->query($newsql2);
    echo '<script type="text/javascript">',
       'auctionnotif(1);',
       '</script>';

  }else
  {
   //$requete= "INSERT INTO `all_bid` (`id`, `id_product`, `id_client`,`price_offer`,`statut`) VALUES (NULL,$id_product,$id_client,$offer,'false')";
   //$conn->query($requete);
   echo '<script type="text/javascript">',
      'auctionnotif(2);',
      '</script>';
  }
}

?>
