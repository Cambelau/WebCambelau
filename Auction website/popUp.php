<!-- POP UP if you try to buy something while not being connected or registered -->
<!-- USE <?//php include "popUp.php"; ?> Pour créer une pop up dans une page -->
<div class="popUp">
	<span class="helper"></span>
	<div>
		<div onclick="enableScrolling()" class="popUpBtn">&times;</div>

		<p style="color:black;" >Please login to continue<br><br>
			<a href="login.php">Login or create acount</a>
		</p>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

	function disableScrolling(){
		var x=window.scrollX;
		var y=window.scrollY;
		window.onscroll=function(){window.scrollTo(x, y);};
	}

	function enableScrolling(){
		window.onscroll=function(){};
	}

	//POP UP TO login
	function checkLogedIn() {


		var loged = false;
		var cart = false;

		if(document.activeElement.getAttribute('name') == "cart")
			loged=true;

		<?php
		if(isset($_SESSION["loggedin"]))
			echo "loged=true;";
		?>

		if(!loged){
			$('.popUp').show();
			disableScrolling();
		}
		return loged;
	}

	$(window).load(function () {
		$('.popUpBtn').click(function(){
			$('.popUp').hide();
		});
	});

</script>

<style type="text/css">

	.popUp{
		margin-left: -310px;
		background:rgba(0,0,0,.4);
		cursor:pointer;
		display:none;
		height:100%;
		position:fixed;
		text-align:center;
		top:0;
		width:100%;
		z-index:10000;
	}
	.popUp .helper{
		display:inline-block;
		height:100%;
		vertical-align:middle;
	}
	.popUp > div {
		background-color: #fff;
		box-shadow: 10px 10px 60px #555;
		display: inline-block;
		height: auto;
		max-width: 551px;
		min-height: 100px;
		vertical-align: middle;
		width: 60%;
		position: relative;
		border-radius: 8px;
		padding: 15px 5%;
	}
	.popUpBtn {
		background-color: #fff;
		border: 3px solid #999;
		border-radius: 50px;
		cursor: pointer;
		display: inline-block;
		font-weight: bold;
		position: absolute;
		top: -20px;
		right: -20px;
		font-size: 25px;
		line-height: 30px;
		width: 30px;
		height: 30px;
		text-align: center;
		background-color: #ccc;
	}
	.popUpBtn:hover {
		background-color: red;
	}
	.trigger_popup_fricc {
		cursor: pointer;
		font-size: 20px;
		margin: 20px;
		display: inline-block;
		font-weight: bold;
	}
</style>
