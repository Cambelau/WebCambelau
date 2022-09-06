<!-- Script for the auction process -->
<?php

$dateoftoday=getdate();
$date=$dateoftoday['year']."-".$dateoftoday['mon']."-".$dateoftoday['mday'];
$req="SELECT * FROM `best_bid` WHERE `stop_time` < '$date' and `status` = 'true'";
$rslt=$conn->query($req);

while($product = $rslt->fetch_assoc())
{
$id_product=$product['id_product'];
$id_client=$product['id_client'];
$price=$product['offer'];
$requete= "INSERT INTO `sold_products` (`id`,`id_product`, `id_client`, `price`) VALUES (NULL, $id_product,$id_client,$price)";
$conn->query($requete);

}
$requete="UPDATE `best_bid` SET `status`='false' WHERE `stop_time` < '$date'";
$conn->query($requete);
?>
