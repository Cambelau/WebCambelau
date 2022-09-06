<!-- Commentary -->
<?php
function transfert(){
	$ret        = false;
	$img_blob   = '';
	$img_taille = 0;
	$img_type   = '';
	$img_nom    = '';
	$taille_max = 250000;
	$ret        = is_uploaded_file($_FILES['fic']['tmp_name']);

	if (!$ret) {
		echo "Problème de transfert";
		return false;
	} else {
            // Le fichier a bien été reçu
		$img_taille = $_FILES['fic']['size'];

		if ($img_taille > $taille_max) {
			echo "Trop gros !";
			return false;
		}

		$img_type = $_FILES['fic']['type'];
		$img_nom  = $_FILES['fic']['name'];
	}

	include "database.php";
	$img_blob = file_get_contents ($_FILES['fic']['tmp_name']);

	$id = $_SESSION['id'];

	// $sql = "INSERT INTO user (userImg) VALUES" . addslashes ($img_blob). " WHERE id = $id";

	$param_Img = addslashes ($img_blob);

	// $query = "INSERT INTO user_error() (id,userImg) VALUES ('$id','$param_Img')";
	// $conn->query($query);

	// $sql = "UPDATE user SET userImg = $param_Img WHERE id = $id";x
	$sql = "UPDATE `user` SET `userImg` = '$param_Img' WHERE `user`.`id` = $id";
	$conn->query($sql);

	$sql2 = "SELECT * FROM user WHERE id = $id ";
	$sth2 = $conn->query($sql2);
	$result=mysqli_fetch_array($sth2);
	$userImg=$result['userImg'];
	$_SESSION["userImg"] = $userImg;

	return true;
}

?>
