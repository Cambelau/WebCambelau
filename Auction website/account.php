<?php
// MY ACCOUNT PAGE
session_start();
echo '<script type="text/javascript"> loadUpdate=false;</script>';

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
	header("location: login.php");
	exit;
}
include "database.php";
if(isset($_POST['del']))
{
	$id_del=$_POST['del'];
	$conn->query("DELETE FROM best_bid WHERE id_product = $id_del");
	$conn->query("DELETE FROM products WHERE id = $id_del");

}

$id = $_SESSION['id'];

if (isset($_POST["updForm"])) {
	echo '<script type="text/javascript"> loadUpdate=true;</script>';

	$updErr="";

	$sql = "SELECT id FROM user WHERE username = ?";
	if($stmt = mysqli_prepare($conn, $sql)){
		mysqli_stmt_bind_param($stmt, "s", $param_updUsername);

		$param_updUsername = trim($_POST["updUsername"]);

		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) == 1 && $_POST["updUsername"]!=$_SESSION["username"]){
				$updErr = "This username is already taken.";
			} else{
				$updUsername = trim($_POST["updUsername"]);
				$updErr="";
			}
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}

	if(empty(trim($_POST["updPassword"]))){
	} elseif(strlen(trim($_POST["updPassword"])) < 6){
		$updErr = "Password must have atleast 6 characters.";
	} else{
		$updPassword = trim($_POST["updPassword"]);
		if(empty(trim($_POST["updPasswordC"]))){
			$updErr = "Please confirm password.";
		} else{
			$confirmPassword = trim($_POST["updPasswordC"]);
			if(empty($password_err) && ($updPassword != $confirmPassword)){
				$updErr = "Password did not match.";
			}
		}
	}

	if(empty($updErr)){


		$param_userName=htmlspecialchars($_POST["updUsername"]);
		$param_firstName=htmlspecialchars($_POST["updFirstname"]);
		$param_lastName=htmlspecialchars($_POST["updLastname"]);
		$param_mail=htmlspecialchars($_POST["updMail"]);
		$param_adress=htmlspecialchars($_POST["updAdress"]);
		if(!empty($updPassword)){
			$param_password=password_hash($updPassword, PASSWORD_DEFAULT);
			$sqlp = "UPDATE `user` SET `password` = '$param_password' WHERE `user`.`id` = $id";
			$conn->query($sqlp);
		}


		$sql = "UPDATE `user` SET `userName` = '$param_userName', `firstname` = '$param_firstName', `lastname` = '$param_lastName',  `mail` = '$param_mail', `adress` = '$param_adress' WHERE `user`.`id` = $id";

		$conn->query($sql);
		$_SESSION["username"]=htmlspecialchars($_POST["updUsername"]);
		$_SESSION["firstname"]=htmlspecialchars($_POST["updFirstname"]);
		$_SESSION["lastname"]=htmlspecialchars($_POST["updLastname"]);
		$_SESSION["mail"]=htmlspecialchars($_POST["updMail"]);
		$_SESSION["adresse"]=htmlspecialchars($_POST["updAdress"]);

		header("location: account.php");
		exit;

	}

}

$rslt1= $conn->query("SELECT * FROM products WHERE id_seller=$id");
$rslt2=$conn->query("SELECT p.id,p.Name,p.Pictures, o.price\n". "FROM products p \n". "INNER JOIN sold_products o \n". "ON p.id = o.id_product\n"."WHERE o.id_client=$id");
$rslt3=$conn->query("SELECT * FROM products WHERE id IN (SELECT id_product FROM all_bid WHERE id_client=$id)");

$firstname=$_SESSION["firstname"];
$username=$_SESSION["username"];
$lastname=$_SESSION["lastname"];
$adresse=$_SESSION["adresse"];
$userImg = $_SESSION["userImg"];
$mail = $_SESSION["mail"];
?>



<!DOCTYPE html>
<html>
<head>
	<title>ALCA - My account Page</title>
	<meta charset="utf-8" />
	<link href="css/prime.css" rel="stylesheet" type="text/css" />
	<link href="css/style-index.css" rel="stylesheet" type="text/css" />
	<link href="css/style-account.css" rel="stylesheet" type="text/css" />
	<link href="css/login.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
	<?php include "navbar.php"; ?>
	<div class="accountpage-container">
		<div class="myprofilContainer">
			<div  id="showProfil">
				<?php if($userImg!=NULL)
				echo '<img src="data:image/jpg;base64,'.base64_encode( $userImg ).'" alt="User Image" width="100px" height="100px" align="left" style="border-radius: 10px" ><br>';
				else
					echo '<img src="img/userpicture.jpg" alt="User Imagepic" width="100px" height="100px" align="left" style="border-radius: 10px;"><br>';
				?>
				<p class="uName"><?php echo $username; ?></p><br><br><br><br>
				<table id="userpres" border = "border">
					<tr><td> First Name :</td> <td><?php echo $firstname; ?></td></tr>
					<tr><td> Last Name :</td> <td><?php echo $lastname; ?></td></tr>
					<tr><td> Email :</td> <td><?php echo $mail; ?></td></tr>
					<tr><td> Adresse :</td> <td><?php echo $adresse; ?> </td></tr>
				</table>
				<input type="button" onclick="myFunction()" class="sbt" name="upd" value="Update Data">
				<form action="login.php" method="post">
					<input type="submit" class="sbt" value="Logout" name="logout" />
				</form>
			</div>

			<div id="editProfil">

				<?php if($userImg!=NULL)
				echo '<img src="data:image/jpg;base64,'.base64_encode( $userImg ).'" alt="User Image" width="60px" height="60px" align="left" style="border-radius: 10px" >';
				else
					echo '<img src="img/userpicture.jpg" alt="User Imagepic" width="60px" height="60px" align="left" style="border-radius: 10px;">';
				?>
				<?php
				include ("uploadImage.php");
				if ( isset($_FILES['fic']) )
				{
					transfert();
				}
				?>
				<form enctype="multipart/form-data" action="#" method="post">
					Upload a new picture profil
					<input type="hidden" name="MAX_FILE_SIZE" value="250000" />
					<input type="file" name="fic" size=50 />
					<input type="submit" value="Submit" />
				</form>
				<form class="" action="account.php" method="post">
					<table id="userpres" border = "border">
						<tr><td>Name :</td> <td><input type="text" name="updUsername" value="<?php echo $username; ?>"></td></tr>
						<tr><td> First Name :</td> <td><input type="text" name="updFirstname" value="<?php echo $firstname; ?>"></td></tr>
						<tr><td> Last Name :</td> <td><input type="text" name="updLastname" value="<?php echo $lastname; ?>"> </td></tr>
						<tr><td> Email :</td> <td><input type="mail" name="updMail" value="<?php echo $mail; ?>"> </td></tr>
						<tr><td> Adresse :</td> <td><input type="text" name="updAdress" value="<?php echo $adresse; ?>"> </td></tr>
						<tr><td> Password :</td> <td><input type="password" name="updPassword" value=""> </td></tr>
						<tr><td> New-Password :</td> <td><input type="password" name="updPasswordC" value=""> </td></tr>
					</table>
					<p><?php if(isset($updErr))echo $updErr ?></p>
					<input type="hidden" name="updForm">
					<input type="submit" onclick="myFunction()" class="sbt" name="upd" value="Update Data">
				</form>
				<form action="login.php" method="post">
					<input type="submit" class="sbt" value="Logout" name="logout" />
				</form>
			</div>
		</div>

		<div class="Last-sell">
			<h2>Your object in the market</h2>
			<form method="post">
				<table id='productmarket' class="producttable">
					<?php
					while($product_offer = $rslt1->fetch_assoc())
					{
						$Pic=$product_offer["Pictures"];
						$id_pro=$product_offer["id"];
						echo "<tr><td><img src=watchesimg/$Pic width='80' height='80'>";
						$name=$product_offer["Name"];
						$Price=$product_offer["Price"];
						echo "$name</td><td>$Price$</td><td>";
						echo "<button type=submit value='$id_pro' name=del>Delete</button></center></td></tr>";

					}; ?>
				</form>
			</table>
		</div>
		<div class="Last-product">
			<h2>Recent purchace</h2>

			<table id='product_buy' class="producttable">
				<?php
				while($product_offer = $rslt2->fetch_assoc())
				{
					$tmpid=$product_offer['id'];
					$Pic=$product_offer["Pictures"];
					echo "<tr><td id='$tmpid'><img src=watchesimg/$Pic width='80' height='80'>";
					$name=$product_offer["Name"];
					$Price=$product_offer["price"];
					echo "$name</td><td>$Price$</td></tr>";
				}; ?>
			</table>
		</div>

		<div class="Last-offer">
			<h2>Current offert</h2>
			<table id='prodresume' class="producttable" >
				<?php
				while($product_offer = $rslt3->fetch_assoc())
				{
					$tmpvar=$product_offer['id'];
					$rslt4= $conn->query("SELECT * FROM all_bid WHERE id_client='$id' AND id_product='$tmpvar' ORDER BY price_offer DESC");
					while($bid_data=$rslt4->fetch_assoc())
					{
						$Pic=$product_offer["Pictures"];
						$statut = $bid_data['statut'];
						echo "<tr><td id='$tmpvar'><img src=watchesimg/$Pic width='80' height='80'>";
						$name=$product_offer["Name"];
						$Price=$bid_data['price_offer'];
						echo "$name</td><td class='$statut'>$Price$</td></tr>";
					}
				}; ?>
			</table>
		</div>
	</div>

</body>
</html>

<script type="text/javascript">

	if(loadUpdate){
		document.getElementById("showProfil").style.display = "none";
		document.getElementById("editProfil").style.display = "block";
	}

	function myFunction() {
		var x = document.getElementById("editProfil");
		var y = document.getElementById("showProfil");
		if (y.style.display != "none") {
			x.style.display = "block";
			y.style.display = "none";
		} else {
			x.style.display = "none";
			y.style.display = "block";
		}
	}


	var t = document.getElementById("prodresume");
	var trs = t.getElementsByTagName("tr");
	var tds = null;

	for (var i = 0; i < trs.length; i++) {
		tds = trs[i].getElementsByTagName("td");
		for (var n = 0; n < tds.length; n++) {
			tds[n].onclick = function() {
				var id = document.getElementById(this.id).getAttribute('id');
				window.open("product.php?id="+id,"_self");
			}
		}
	}

	var t = document.getElementById("product_buy");
	var trs = t.getElementsByTagName("tr");
	var tds = null;

	for (var i = 0; i < trs.length; i++) {
		tds = trs[i].getElementsByTagName("td");
		for (var n = 0; n < tds.length; n++) {
			tds[n].onclick = function() {
				var id = document.getElementById(this.id).getAttribute('id');
				window.open("product.php?id="+id,"_self");
			}
		}
	}
</script>
