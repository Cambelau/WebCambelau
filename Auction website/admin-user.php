<?php
// ADMIN USER PAGE, you can manage every data from every users
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
	header('HTTP/1.0 404 Not Found');
	exit;
}
?>
<?php
include "database.php";

$id_form = $fname_form = $lname_form = $username_form = $mail_form = $adress_form = "";
if(isset($_POST['id_form']))
{
	$id_form =$_POST['id_form'];
	$fname_form=$_POST['fname_form'];
	$lname_form=$_POST['lname_form'];
	$username_form=$_POST['username_form'];
	$mail_form=$_POST['mail_form'];
	$adress_form=$_POST['adress_form'];

	$action=$_POST['action'];
	switch ($action) {
		case 'edit':
		$conn->query("UPDATE `user` SET firstname = '$fname_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `user` SET lastname = '$lname_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `user` SET username = '$username_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `user` SET mail = '$mail_form' WHERE id = '$id_form'");
		$conn->query("UPDATE `user` SET adress = '$adress_form' WHERE id = '$id_form'");
		break;

		case 'del':
		$id_c=$_GET['id'];
		$conn->query("DELETE FROM user WHERE id = '$id_c'");
		break;

		default:

	}

}
$requete="SELECT * FROM user";

if(isset($_POST['search']))
{
	$search_value=$_POST['search'];

	switch ($_POST['searchby']){
		case 'fname':
		$requete="SELECT * FROM `user` WHERE firstname LIKE '%$search_value%'";

		break;
		case 'lname':
		$requete="SELECT * FROM `user` WHERE lastname LIKE '%$search_value%'";
		break;

		case 'usern':
		$requete="SELECT * FROM `user` WHERE username LIKE '%$search_value%'";
		break;
		case 'id_s':
		$requete="SELECT * FROM `user` WHERE id = '$search_value'";;
		break;
	}

}

$result= $conn->query($requete);


if(isset($_GET['id']))
{
	$id_selecpro=$_GET['id'];
	$rslt_pro= $conn->query("SELECT * FROM user WHERE id='$id_selecpro'");
	$selectproduct=$rslt_pro->fetch_assoc();
}?>


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
					<button type="submit" id="editproduct">Edit User</button>
					<button type="submit" id="delproduct">Delete User</button>
				</div>

			</div>

			<div class="manageProductPage" id="manageProductPage">
				<div class="left">
					<form method="post">

						<input type="text" name="search" value="" required size="50px" placeholder="Search"><br>
						<select class="" name="searchby">
							<option value="fname">First name</option>
							<option value="lname">Last name</option>
							<option value="usern">username</option>
							<option value="id_s">id</option>
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
						<?php	while($product = $result->fetch_assoc()){
							$id_p=$product['id'];
							$name=$product['username'];
							echo "<tr><td id='$id_p'>$id_p</td><td id='$id_p'>$name</td></tr>";}?>
						</table>
					</form>
				</div>

				<div class="right">
					<form id="updata" method="post">
						<?php
						if(isset($selectproduct)){
							$id_form =$selectproduct['id'];
							$fname_form=$selectproduct['firstname'];
							$lname_form=$selectproduct['lastname'];
							$username_form=$selectproduct['username'];
							$mail_form=$selectproduct['mail'];
							$adress_form=$selectproduct['adress'];
						}

/*	 while($product = $result->fetch_assoc()){
								   $id_p=$product['id'];
								   $name=$product['username'];
								   echo "<tr><td id='$id_p'>$id_p</td><td id='$id_p'>$name</td></tr>";}
*/
								   ?>
								   <table border="border" id="tablechange">
								   	<tr>
								   		<td>ID</td>
								   		<td><input class="inputfo" type="text" name="id_form" value="<?php echo $id_form?>" required></td>
								   	</tr>
								   	<tr>
								   		<td>First Name</td>
								   		<td><input class="inputfo" type="text" name="fname_form" value="<?php echo $fname_form?>" required></td>
								   	</tr>
								   	<tr>
								   		<td>Last Name</td>
								   		<td><input  class="inputfo" type="text" name="lname_form" value="<?php echo $lname_form?>" required></td>
								   	</tr>
								   	<tr>
								   		<td>Username</td>
								   		<td><input class="inputfo" type="text" name="username_form" value="<?php echo $username_form?>" required></td>
								   	</tr>
								   	<tr>
								   		<td>Mail</td>
								   		<td><input class="inputfo" type="text" name="mail_form" value="<?php echo $mail_form?>" required></td>
								   	</tr>
								   	<tr>
								   		<td>Address</td>
								   		<td><input class="inputfo" type="text" name="adress_form" value="<?php echo $adress_form?>" required></td>
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
					alert('Data uptaded');
				});


				$("#delproduct").click(function(){
					document.getElementById("action").value="del";
					document.getElementById("updata").submit();
					alert('User deleted');
				});

				var t = document.getElementById("tableofproduct");
				var trs = t.getElementsByTagName("tr");
				var tds = null;

				for (var i = 0; i < trs.length; i++) {
					tds = trs[i].getElementsByTagName("td");
					for (var n = 0; n < tds.length; n++) {
						tds[n].onclick = function() {
							var id = document.getElementById(this.id).getAttribute('id');
							window.open("admin-user.php?id="+id,"_self");
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
