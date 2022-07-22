<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Menu_Inventaire</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_navigation.css" type="text/css">
	<link rel="stylesheet" href="css/inventaire_menu.css" type="text/css">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

	<?php include("navigation.php"); ?>

	<section>
		
		<div class="button_container 1">
			<a href="inventaire_unite.php?unite=Farfadets"><button class="btn btn_ffa"><span>Farfadets</span></button></a>
		</div>
		<div class="button_container 2">
			<a href="inventaire_unite.php?unite=Troupe"><button class="btn btn_tpe"><span>Troupe</span></button></a>
		</div>
		<div class="button_container 3">
			<a href="inventaire_unite.php?unite=Compa"><button class="btn btn_cpa"><span>Compa</span></button></a>
		</div>
		<div class="button_container 4">
			<a href="inventaire_unite.php?unite=Louvetaux"><button class="btn btn_lvt"><span>Louvetaux</span></button></a>		
		</div>
		<div class="button_container 5">
			<a href="inventaire_unite.php?unite=Pio"><button class="btn btn_pio"><span>Pio</span></button></a>	
		</div>
		<div class="button_container 6">
			<a href="inventaire_unite.php?unite=Groupe"><button class="btn btn_gpe"><span>Groupe</span></button></a>
		</div>
	</section>
</body>
</html>