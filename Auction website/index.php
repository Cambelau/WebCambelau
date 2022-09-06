<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<!-- HOME PAGE -->
	<title>ALCA - Home Page</title>
	<meta charset="utf-8" />
	<link href="css/prime.css" rel="stylesheet" type="text/css" />
	<link href="css/style-index.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut(2000); })
	</script>

	<body>
		<div class="loader"><div class="message">
			<img src="img\petitlogo.png"></div></div>
			<nav>
				
				<p align="center"><img src="img/logozak.png" alt="Logo" width="100" height="100"></p>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li class="deroule"><a href="">Store</a>
						<ul class="sous">
							<li><a href="/store.php?cat=Watches">Watches</a></li>
							<li><a href="/store.php?cat=Accessories">Accessories</a></li>
						</ul>
					</li>
					<?php
					if(isset($_SESSION["loggedin"]))
						echo " <li><a href='sell.php'>Sell</a></li>";
					else
						echo " <li ><a href='#' id='sellHov'>Sell</a></li>";
					?>

					<li><a href="cart.php">Cart</a></li>
					<?php

					if(isset($_SESSION["admin"]) && $_SESSION["admin"] == true){
						echo "<li><a href='admin.php'>Admin</a></li>";
					}else{
						if(!isset($_SESSION["loggedin"])){
							echo "<li><a href='login.php'>Login</a></li>";
						}else{
							echo "<li><a href='account.php'>My account</a></li>";
						}
					}
					?>

				</ul>

				<div class="box-caroussel">
					<div class="Carousel">
						<img id="un" class="carouselpicture" src="img/pic1.png" alt="pic1">
						<img id="deux" class="carouselpicture" src="img/pic2.jpg" alt="pic2">
						<img id="trois" class="carouselpicture" src="img/pic3.png" alt="pic3">
						<img id="quatre" class="carouselpicture" src="img/pic4.gif" alt="pic1">
						<img id="cinq" class="carouselpicture" src="img/pic5.jpg" alt="pic2">
						<img id="six" class="carouselpicture" src="img/pic6.gif" alt="pic3">
						<img id="sept" class="carouselpicture" src="img/pic7.jpg" alt="pic3">

						<div class="dotbox">
							<div class="dot index0"></div>
							<div class="dot index1"></div>
							<div class="dot index2"></div>
							<div class="dot index3"></div>
							<div class="dot index4"></div>
							<div class="dot index5"></div>
							<div class="dot index6"></div>

						</div>
					</div>
				</div>
			</nav>

			<div class="container">
				<div class="aboutus">
					<center>
						<h2>ABOUT US</h2>
						<br>
						<p>At ALCA, you can guarantee you will find more watch brands than anywhere else.
							From the biggest designer brands, to the best of luxury and some hidden gems, along with outstanding service and next day delivery,
							ALCA is the hottest place to buy your next watch.
						</p>
					</center>
				</div>

				<div class="favproducts">
					<br>
					<hr>
					<br>
					<center>
						<h2>Best sellers</h2>

						<table id="table-product">
							<tr>
								<td><img src="img/watch1.jpg" alt="watch1" width="300" height="369">
									<h5>ROLEX</h5>
								</td>
								<td><img src="img/watch2.jpg" alt="watch1" width="300" height="369">
									<h5>ROLEX</h5>
								</td>
								<td><img src="img/watch3.jpg" alt="watch1" width="300" height="369">
									<h5>ROLEX</h5>
								</td>
								<td><img src="img/watch3.jpg" alt="watch1" width="300" height="369">
									<h5>ROLEX</h5>
								</td>
							</tr>
						</table>
					</center>

				</div>

				<div class="">
					<br>
					<center>

						<button id="seemore" type="button" name="more"><a href="/store.php?cat=Watches">See More</a></button>
					</center>
				</div>
				<div class="sponsor">
					<center>
						<img src="img/n1.png" alt="" style="margin-top:20px;">
					</center>
					<center>
						<img src="img/brands.png" alt="" style="margin-top:20px;">
					</center>
				</div>
			</div>
		</body>

		</html>

		<script>
			var images = document.getElementsByClassName("carouselpicture");
			index = 1;

			function reset() {
				loop();
			}

			function loop() {
				setTimeout(function() {
					move();
					loop();
				}, 5000);
			}

			function move() {
				console.log(index);
				$(".carouselpicture").fadeTo(500, 0)
				$(images[index]).fadeTo(500, 1)
				$(images[index]).animate({
					opacity: 1
				}, 1000);
				index++;

				updatedot();
				if (index > images.length - 1)
					index = 0;
				if (index < 0)
					index = images.length - 1;

			}

			function updatedot() {
				$(".dot").css("background-color", "black");
				$(".index" + "" + (index - 1)).css("background-color", "white");
			}

			$(window).on('load', function() {
				loop();
			});
		</script>
