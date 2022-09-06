<?php
//ADMIN PAGE, you can manage every product on the website
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	header('HTTP/1.0 404 Not Found');
	exit;
}
?>
<?php
include "database.php";
$id_form = $id_pro = $name_form = $price_form = $description_form =$picture_form
= $id_seller_form = $categorie_form='';

if(isset($_POST['id_form']))
{
	$id_form =$_POST['id_form'];
	$id_pro=$_GET['id'];
	$name_form=$_POST['name_form'];
	$price_form=$_POST['price_form'];
	$description_form=$_POST['description_form'];
	$picture_form=$_POST['picture_form'];
	$id_seller_form=$_POST['id_seller_form'];
	$categorie_form=$_POST['categorie_form'];

	$action=$_POST['action'];
	
	switch ($action) {
		case 'edit':
		$conn->query("UPDATE `products` SET id = '$id_form' WHERE id ='$id_pro'");
		$conn->query("UPDATE `products` SET Name = '$name_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `products` SET Price = '$price_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `products` SET Description = '$description_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `products` SET Categorie = '$categorie_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `products` SET Pictures = 	'$picture_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `products` SET id_seller = '$id_seller_form' WHERE id = '$id_form'");
		break;

		case 'add':
		$conn->query("INSERT INTO `products` (`id`, `Name`, `Categorie`, `Price`, `Description`, `Pictures`, `id_seller`) VALUES ($id_form,'$name_form','$categorie_form','$price_form','$description_form','$picture_form','$id_seller_form')");
		break;

		case 'del':
		$conn->query("DELETE FROM best_bid WHERE id_product = $id_pro");
		$conn->query("DELETE FROM products WHERE id = $id_pro");
		break;

		default:

	}

}
$requete="SELECT * FROM products";

if(isset($_POST['search']))
{
	$search_value=$_POST['search'];

	switch ($_POST['searchby']){

		case 'lprice':
		$requete="SELECT * FROM `products` WHERE `Price` < $search_value";
		break;
		case 'mprice':
		$requete="SELECT * FROM `products` WHERE `Price` > $search_value";
		break;
		case 'seller':
		$requete="SELECT * FROM products WHERE id_seller IN (SELECT id FROM user WHERE username LIKE '%$search_value%')";
		break;
		case 'name':
		$requete = "SELECT * FROM `products` WHERE `Name` LIKE '%$search_value%'";
		break;
	}

}

$result= $conn->query($requete);
$rslt= $conn->query("SELECT * FROM user");

if(isset($_GET['id']))
{
	$id_selecpro=$_GET['id'];
	$rslt_pro= $conn->query("SELECT * FROM products WHERE id='$id_selecpro'");
	$selectproduct=$rslt_pro->fetch_assoc();
}?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ALCA - Admin page</title>
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
					<button type="submit"  id="addproduct">Add Product</button>
					<button type="submit"  id="editproduct">Edit Product</button>
					<button type="submit" id="delproduct">Delete Product</button>
				</div>

			</div>

			<div class="manageProductPage" id="manageProductPage">
				<div class="left">
					<form method="post">

						<input type="text" name="search" value="" required size="50px" placeholder="Search"><br>
						<select class="" name="searchby">
							<option value="name">Name</option>
							<option value="mprice">more price</option>
							<option value="lprice">less price</option>
							<option value="seller">Sellers</option>
						</select>

						<input type="submit" name="" value="Search">
					</form>
					<form method="post">
						<br>
						<table id="tableofproduct" border="border">
							<tr>
								<th>ID</th>
								<th>Name</th>
							</td>
						</tr>
						<?php		while($product = $result->fetch_assoc()){
							$id_p=$product['id'];
							$title=$product['Name'];
							echo "<tr><td id='$id_p'>$id_p</td><td id='$id_p'>$title</td></tr>";}?>
						</table>
					</form>
				</div>

				<div class="right">
					<form id="updata" method="post">
						<?php
						if(isset($selectproduct)){
							$id_form =$selectproduct['id'];
							$name_form=$selectproduct['Name'];
							$price_form=$selectproduct['Price'];
							$description_form=$selectproduct['Description'];
							$picture_form=$selectproduct['Pictures'];
							$id_seller_form=$selectproduct['id_seller'];
							$categorie_form=$selectproduct['Categorie'];
						}
						while($product = $result->fetch_assoc()){
							$id_p=$product['id'];
							$title=$product['Name'];
							echo "<tr><td id='$id_p'>$id_p</td><td id='$id_p'>$title</td></tr>";}?>

							<table border="border" id="tablechange">
								<tr>
									<td>ID</td>
									<td><input class="inputfo" type="text" name="id_form" value="<?php echo $id_form?>" required></td>
								</tr>
								<tr>
									<td>Name</td>
									<td><input class="inputfo" type="text" name="name_form" value="<?php echo $name_form?>" required></td>
								</tr>
								<tr>
									<td>Price</td>
									<td><input  class="inputfo" type="text" name="price_form" value="<?php echo $price_form?>" required></td>
								</tr>
								<tr>
									<td>Description</td>
									<td><textarea class="inputfo" name="description_form" rows="8" cols="22"><?php echo $description_form?></textarea>
									</td>
								</tr>
								<tr>
									<td>Pricture</td>
									<td><input class="inputfo" type="text" name="picture_form" value="<?php echo $picture_form?>" required></td>
								</tr>
								<tr>
									<td>Categorie</td>
									<td>
										<select class="inputfo" name="categorie_form">
											<option value="Watches" <?php if($categorie_form=="Watches") echo "selected";?>>Watches</option>
											<option value="Accessories" <?php  if($categorie_form=="Accessories") echo "selected";?>>Accessories</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>ID SELLER</td>
									<td><input class="inputfo" type="text" name="id_seller_form" value="<?php echo $id_seller_form?>" required></td>
								</tr>
							</table>
							<input type="hidden" name='action' id="action" value="">
						</form>
						<button onclick="reset()">Reset</button>
					</div>
				</div>
			</section>
		</div>
	</body>

	</html>

	<script>

		$("#editproduct").click(function(){
			document.getElementById("action").value="edit";
			document.getElementById("updata").submit();
			alert('Product Updated');
		});

		$("#addproduct").click(function(){
			document.getElementById("action").value="add";
			document.getElementById("updata").submit();
			alert('New product online');
		});
		$("#delproduct").click(function(){
			document.getElementById("action").value="del";
			document.getElementById("updata").submit();
			alert('Product delete');
		});

		var t = document.getElementById("tableofproduct");
		var trs = t.getElementsByTagName("tr");
		var tds = null;

		for (var i = 0; i < trs.length; i++) {
			tds = trs[i].getElementsByTagName("td");
			for (var n = 0; n < tds.length; n++) {
				tds[n].onclick = function() {
					var id = document.getElementById(this.id).getAttribute('id');
					window.open("admin.php?id="+id,"_self");
				}
			}
		}

		function reset(){
			document.getElementsByClassName('inputfo')['0'].value ='';
			document.getElementsByClassName('inputfo')['1'].value ='';
			document.getElementsByClassName('inputfo')['2'].value ='';
			document.getElementsByClassName('inputfo')['3'].value ='';
			document.getElementsByClassName('inputfo')['4'].value ='';
			document.getElementsByClassName('inputfo')['5'].value ='';
			document.getElementsByClassName('inputfo')['6'].value ='';
		}
	</script>
