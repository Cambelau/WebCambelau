<?php
//CART PAGE, you can check what is in your cart, decide if you want to buy all or if you want to delete stop items
session_start();

include "database.php";

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

if(isset($_POST['del']))
{

	$key = array_search($_POST['del'],$_SESSION['cart']);
	for($i = 0 ; $i < count($_SESSION['cart']) ; $i++){
		$tmp=$_SESSION['cart'][$i];
	}
	if ($key !== false) {
		unset($_SESSION['cart'][$key]);
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}

}

$tmp=$_SESSION['cart'];

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
	$requete="SELECT * FROM products WHERE id = $tmp[0]";

	for($i = 0 ; $i < count($_SESSION['cart']) ; $i++){
		$tmp=$_SESSION['cart'][$i];
		$requete=$requete." OR id = $tmp";
	}

	$rslt1= $conn->query($requete);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ALCA - Cart</title>
	<meta charset="utf-8" />
	<link href="css/prime.css" rel="stylesheet" type="text/css" />
	<link href="css/style-index.css" rel="stylesheet" type="text/css" />
	<link href="css/login.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
	<?php include "navbar.php"; ?>
	<?php include 'popUp.php' ?>
	<div class="accountpage-container">
		<div class="cart">
			<form method="post">
				<table id='prodresume'>
					<?php
					$total=0;
					echo "<th colspan=2><h2>Your Cart</h2></th>";
					if(isset($_SESSION['cart'][0])){
						while($product_offer = $rslt1->fetch_assoc())
						{
							$Pic=$product_offer["Pictures"];
							echo "<tr><td><img src=watchesimg/$Pic width='80' height='80'>";
							$name=$product_offer["Name"];
							$Price=$product_offer["Price"];
							$total=$total+$Price;
							$id_product=$product_offer['id'];
							echo "$name </td><td><center>$$Price</center><center>";
							echo "<button type=submit value='$id_product' name=del id=butn2>Delete</button></center></td></tr>";
						}}; ?>
					</table>
				</form>

			</div>
			<h3>
				<?php echo "Total: $$total";?>
			</h3>
		</div>
		<form class="" action="Checkout.php" method="GET" onsubmit="return checkLogedIn(this)">
			<?php
			if($total==0)
				echo '<center><button type="submit" id="butn" disabled="disabled">Empty Cart</button></center>';
			else
				echo '<center><button type="submit" id="butn">Buy Now</button></center>';
			 ?>
			<input type="hidden" name="total" value="<?php echo $total;?>">
		</form>


	</body>
	<style type="text/css">
		#butn{
			width: 200px;
			height: 80px;
			margin: 20px;
			border-color: #fff07c;
			background-color: transparent;
			border-radius: 10px;
			cursor: pointer;
			color: #fff07c;
			font: bold 15px arial;
		}
		#butn2{
			width: 100px;
			height: 50px;
			padding: 10px;
			border-color: red;
			background-color: transparent;
			border-radius: 10px;
			cursor: pointer;
			color: red;
			font: bold 15px arial;
		}
		h2{
			color: black;
			padding: 5px;
			text-align: center;
			background-color: white;
			font: bold 22px arial;
			border-radius: 10px;
		}
		h3{
			color: black;
			padding: 5px;
			text-align: center;
			font: bold 22px arial;
			border-radius: 10px;
		}
		.accountpage-container {
			padding: 50px;
			margin-left: 100px;
			width: 1000px;
			height: 430px;
			background-color:transparent;
			display: flex;
			flex-direction: column;
			margin-top: 150px;
			border-radius: 10px;
		}

		td{
			padding: 3px;
		}

		#prodresume{
			width: 100%;
			border-spacing: 15px;
		}

		.cart::-webkit-scrollbar{
			display: none;
		}

		.accountpage-container .cart {
			margin: 10px;
			/*background-color: #fff07c;*/
			background: rgb(244,217,14);
background: linear-gradient(180deg, rgba(244,217,14,1) 0%, rgba(205,192,88,1) 100%);
			width: 100%;
			overflow: auto;
			border-radius: 10px;
		}
	</style>

	</html>
