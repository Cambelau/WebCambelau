<?php
session_start();
if(isset($_GET["unite"]) AND ($_GET['unite']=="Troupe" OR $_GET['unite']=="Farfadets" OR $_GET['unite']=="Louvetaux" OR $_GET['unite']=="Pio" OR $_GET['unite']=="Compa" OR $_GET['unite']=="Groupe"))
	$_SESSION['unite']=htmlspecialchars($_GET["unite"]);
else{
	$_SESSION['unite']="Troupe";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_SESSION['unite'];?></title>
	<style>
		<?php

		switch($_SESSION['unite'])
		{
			case "Troupe":
			echo "section{background-image: linear-gradient(to top, #1F85DE 0%, #0A4476 100%);}";
			break;
			case "Farfadets":
			echo "section{background-image: linear-gradient(to top, #6BE154 0%, #2EB214 100%);}";
			break;
			case "Louvetaux":
			echo "section{background-image: linear-gradient(to top, #E8C85A 0%, #DAAB0A 100%);}";
			break;
			case "Pio":	
			echo "section{background-image: linear-gradient(to top, #FA1515 0%, #AB2C2C 100%);}";
			break;
			case "Compa":
			echo "section{background-image: linear-gradient(to top, #43B323 0%, #316921 100%);}";
			break;
			case "Groupe":
			echo "section{background-image: linear-gradient(to top, #9236EC 0%, #6B23B3 100%);}";
			break;
			default :
			echo "section{background-image: linear-gradient(to top, black 0%, white 100%);}";
			break;
		} 
		?>
	</style>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_navigation.css" type="text/css">
	<link rel="stylesheet" href="css/inventaire_unite.css" type="text/css">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>			
</head>
<body>
	<?php include("navigation.php"); ?>
	<div id="zone_up">
		<div class="buttons">
			<button class="btn-hover">Ajouter</button>
		</div>

		<form action="upload_item.php?submit=true" method="post" enctype="multipart/form-data">

			<input type="text" name="item_name" required><br>
			<select name="item_etat" id="etat">
				<option value="Très mauvais">Très mauvais</option>
				<option value="Mauvais">Mauvais</option>
				<option value="Bon">Bon</option>
				<option value="Très bon">Très bon</option>
				<option value="Non défini" selected>Non défini</option>
			</select><br>

			<select name="item_unite" id="unite" >
				<?php echo "<option value=\"", $_SESSION['unite'],"\"selected >", $_SESSION['unite'],"</option>"; ?>
				<optgroup label="Autre">
					<option value="Farfadets">Farfadets</option>
					<option value="Louvetaux">Louvetaux</option>
					<option value="Troupe">Troupe</option>
					<option value="Pio">Pio</option>
					<option value="Compa">Compa</option>
					<option value="Groupe">Groupe</option>
				</select><br>
				Select image to upload:
				<input type="file" name="fileToUpload" id="fileToUpload"><br>
				<input type="submit" value="Déposer le nouvel item" name="submit">
			</form>


		</div>
		<section>
			<div id="box_page">
				<div id="box_content">
					<div id="box_item">	
						<table>
							<tr>
								<th>item_name</th>
								<th>item_etat</th>
								<th>item_photo</th>
								<th>item_qr</th>
							</tr>
							<?php 	
							try
							{
								$bdd = new PDO('mysql:host=localhost;dbname=inventaire_ndl;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
							}
							catch(Exception $e)
							{

								die('Erreur : '.$e->getMessage());
							}
							$reponse = $bdd->prepare('SELECT item_name, item_etat,item_photo, item_qr FROM inventaire_ndl WHERE item_unite = ?');
							$reponse->execute(array($_SESSION['unite']));

							while ($donnees = $reponse->fetch())
							{
								?>
								<tr>
									<td><?php echo $donnees['item_name'] ?></td>
									<td><?php echo $donnees['item_etat'] ?></td>
									<td><?php echo $donnees['item_photo'] ?></td>
									<td><?php echo $donnees['item_qr'] ?></td>
								</tr>
								<?php 
							}
							?>
						</table>

					</div>
				</div>
			</div>
		</section>
	<?php /* 
	<div id="box_add_item">
		<div id="add_content">
			
		</div>
	</div>
	*/?>
</body>
</html>