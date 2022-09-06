<?php
// ADMIN AUCTION PAGE, you can manage every transaction
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	header('HTTP/1.0 404 Not Found');
	exit;
}
?>
<?php include "database.php";

$result= $conn->query("SELECT * FROM user");
$rslt_pro1 = $conn->query("SELECT * FROM products LIMIT 3");
$rslt_pro2 = $conn->query("SELECT * FROM products LIMIT 3");
$rslt_pro3 = $conn->query("SELECT * FROM all_bid LIMIT 0");
$rslt_pro4 = $conn->query("SELECT * FROM best_bid LIMIT 0");

if(isset($_GET['bestid']))
{
 $bestid=$_GET['bestid'];
 $conn->query("UPDATE `best_bid` SET `id_client` = NULL,`offer` = NULL WHERE id_product = $bestid ; ");
 $conn->query("UPDATE `all_bid` SET `statut` = 'false' WHERE id_product = $bestid ;");


}

if(isset($_GET['id']))
{

$id_selecprotmp=$_GET['id'];

if(strpos($id_selecprotmp,'P') !== false)
{
  $id_selecpro = ltrim($id_selecprotmp, 'P');

  // all bid
	$rslt_pro3 = $conn->query("SELECT * FROM all_bid WHERE id_product='$id_selecpro'");
	// best bid
  $rslt_pro4 = $conn->query("SELECT * FROM best_bid WHERE id_product='$id_selecpro'");


}else{
	//sell product
	$rslt_pro1 = $conn->query("SELECT * FROM products WHERE id_seller='$id_selecprotmp'");
 //sold product
	$rslt_pro2 = $conn->query("SELECT * FROM products WHERE id IN (SELECT id_product FROM sold_products WHERE id_client='$id_selecprotmp') ");
}


}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="css/prime.css" rel="stylesheet" type="text/css" />
	<link href="css/admin.css" rel="stylesheet" type="text/css" />
	<link href="css/style-index.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>
  	<div class="adminContent">
			<section class="leftSide">
				<li><button type="submit" onclick="location.href = 'admin.php';" id="mpBtn">Manage Product</button></li>
				<li><button type="submit" onclick="location.href = 'admin-auction.php';"id="maBtn">Manage Auction</button></li>
				<li><button type="submit" onclick="location.href = 'admin-user.php';" id="muBtn">Manage User</button></li>
				<li>

		<form action="login.php" method="post">
			<button type="submit" class="sbt" value="Logout" name="logout">Logout</button>
		</form>
		</li>
		</section>

		<section class="rightSide">
			<div class="manageBar">

				  <div class="manageProductBtn" id="manageProductBtn">
					    <button type="submit" id="cancel">Cancel an offer</button>
				 </div>

			</div>

			<div class="manageProductPage" id="manageProductPage">

				<div class="left">

<table id="tableofproduct" border="border">
<tr>
<tr>
	<th colspan="2">
  <h3>Users</h3>
</th>

	<?php
	while($product = $result->fetch_assoc()){
	$id_p=$product['id'];
	$name=$product['username'];
	echo "<tr><td id='$id_p'>$id_p</td><td id='$id_p'>$name</td></tr>";}
	?>

</tr>

<tr>
<tr>
	<th colspan="2">
  <h3>Product for sale</h3>
</th>

	<?php
while($product=$rslt_pro1->fetch_assoc())
{
		$id_p=$product['id'];
		$title=$product['Name'];
		echo "<tr><td id='P$id_p'>$id_p</td><td id='P$id_p'>$title</td></tr>";
}
?>

</tr>

<tr>
<tr>
	<th colspan="2">
  <h3>Product purchased</h3>
</th>

<?php
while($product=$rslt_pro2->fetch_assoc())
{
		$id_p=$product['id'];
		$title=$product['Name'];
		echo "<tr><td id='P$id_p'>$id_p</td><td id='P$id_p'>$title</td></tr>";
}
?>

</tr>
</table>
</div>
<div class="right">
<table id="tableofproduct">
<tr>
<th colspan="3">
	<h3>ALL BID</h3>
</th>

<tr>
	<td>Client</td>
	<td>Bet</td>
	<td>statut</td>
</tr>
		<?php
		while($product = $rslt_pro3->fetch_assoc()){
		$id_c=$product['id_client'];
		$id_p=$product['id_product'];
		$offer=$product['price_offer'];
		$statut=$product['statut'];
		echo "<tr><td id='$id_p'>$id_c</td><td>$offer</td><td>$statut</td></tr>";}
		?>
</tr>

<tr>
<th colspan="3">
	<h3>BEST BID</h3>
</th>

<tr>
	<td>Client</td>
	<td>Best Offer</td>
	<td>Statut</td>
</tr>
		<?php
		while($product = $rslt_pro4->fetch_assoc()){
		$id_c=$product['id_client'];
		$id_p=$product['id_product'];
		$offer=$product['offer'];
		$statut=$product['status'];
		echo "<tr><td id='bestid' value='$id_p'>$id_c</td><td>$offer</td><td>$statut</td></tr>";}
		?>
</tr>

</table>
</div>
</section>
</div>
</body>
</html>

<script>

	$("#cancel").click(function(){
       id = document.getElementById('bestid').getAttribute('value');
       window.open("admin-auction.php?id="+'P'+id+'&bestid='+id,"_self");
	     alert('The best offer have been canceled');

	});

	var t = document.getElementById("tableofproduct");
	var trs = t.getElementsByTagName("tr");
	var tds = null;

	for (var i = 0; i < trs.length; i++) {
		tds = trs[i].getElementsByTagName("td");
		for (var n = 0; n < tds.length; n++) {
			tds[n].onclick = function() {
				var id = document.getElementById(this.id).getAttribute('id');
				window.open("admin-auction.php?id="+id,"_self");
			}
		}
	}

</script>
