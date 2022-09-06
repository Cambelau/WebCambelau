<?php
//This is the login page
session_start();
global $conn ;
$conn = new mysqli('mysql-zack242.alwaysdata.net','zack242','0661150322','zack242_projet');
				 //On vérifie la connexion
if($conn->connect_error){
	die('Erreur : ' .$conn->connect_error);
}
//js needed

//Disconnect you session
if(isset($_POST['logout'])){

	$username = $password = "";
	$username_err = $password_err = "";
	$newUsername = $newPassword = $newMail = $confirmPassword
	= $newUsername_err = $newPassword_err  = $confirm_password_err = "";
	$_SESSION = array();
	session_destroy();

	header("location: login.php");
	exit;
}

//redirect to your page account if already loged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: account.php");
	exit;
}

//form traitment if login form is submitted
if (isset($_POST["username"]) && isset($_POST["password"])){
	//access to ADMIN Page
	if($_POST["username"]=="ADMIN" && $_POST["username"]=="ADMIN"){
		$_SESSION["admin"] = true;
		header("location: admin.php");
		exit;
	}

	//Variables to login form
	$username = $password = "";
	$username_err = $password_err = "";

	//check if a username is wrote
	if(empty(trim($_POST["username"])))
		$username_err = "Please enter a username.";
	else{
		$username = htmlspecialchars(trim($_POST["username"]));
		$username_err="";
	}

	//check if a password is wrote
	if(empty(trim($_POST["password"])))
		$password_err = "Please enter a password.";
	else{
		$password = trim($_POST["password"]);
		$password_err="";
	}

	//check in database if user exist
	if(empty($username_err) && empty($password_err)){
		$sql = "SELECT id, username, password, mail, firstname,lastname,adress FROM user WHERE username = ?";

		if($stmt = mysqli_prepare($conn, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			$param_username = $username;
			if(mysqli_stmt_execute($stmt)){

				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1){

					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $mail, $firstname, $lastname, $adress);

					if(mysqli_stmt_fetch($stmt)){
						//if the password is good createa session for the user
						if(password_verify($password, $hashed_password)){

							$_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;
							$_SESSION["mail"] = $mail;
							$_SESSION["firstname"] = $firstname;
							$_SESSION["lastname"] = $lastname;
							$_SESSION["adresse"] = $adress ;

							//dl the img of the user from database
							$sql2 = "SELECT * FROM user WHERE id = $id ";
							$sth2 = $conn->query($sql2);
							$result=mysqli_fetch_array($sth2);
							$userImg=$result['userImg'];
							$_SESSION["userImg"] = $userImg;

							//redirect to account page
							header("location: account.php");
							exit;
						}else{
							$password_err = "The password you entered was not valid.";
						}
					}
				}else{
					$username_err = "No account found with that username.";
				}
			}else{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
	}
}

//traitment if create account form is submitted
if(isset($_POST["newUsername"]) && isset($_POST["newPassword"]) && isset($_POST["newMail"])){

	//variables to create form
	$newUsername = $newPassword = $newMail = $confirmPassword
	= $newUsername_err = $newPassword_err  = $confirm_password_err = "";

	//check if a password is wrote and good
	if(empty(trim($_POST["newPassword"])))
		$newPassword_err = "Please enter a good password.";
	else{
		$newPassword = htmlspecialchars(trim($_POST["newPassword"]));
		$newPassword_err="";
	}

	$newMail = trim($_POST["newMail"]);
	$newfirstname = trim($_POST["newfirstname"]);
	$newlastname = trim($_POST["newlastname"]);
	$newadress = trim($_POST["newadress"]);

	//check if the username is already token
	$sql = "SELECT id FROM user WHERE username = ?";
	if($stmt = mysqli_prepare($conn, $sql)){
		mysqli_stmt_bind_param($stmt, "s", $param_newUsername);

		$param_newUsername = trim($_POST["newUsername"]);
		if(mysqli_stmt_execute($stmt)){
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) == 1){
				$newUsername_err = "This username is already taken.";
			} else{
				$newUsername = trim($_POST["newUsername"]);
			}
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}

	//check if  password and checked password are the same and have at least 6 characters
	if(empty(trim($_POST["newPassword"]))){
		$newPassword_err = "Please enter a password.";
	} elseif(strlen(trim($_POST["newPassword"])) < 6){
		$newPassword_err = "Password must have atleast 6 characters.";
	} else{
		$newPassword = trim($_POST["newPassword"]);

		if(empty(trim($_POST["confirmPassword"]))){
			$confirm_password_err = "Please confirm password.";
		} else{
			$confirmPassword = trim($_POST["confirmPassword"]);
			if(empty($password_err) && ($newPassword != $confirmPassword)){
				$confirm_password_err = "Password did not match.";
			}
		}
	}

	//if already good create a account
	if(empty($newUsername_err) && empty($newPassword_err) && empty($confirm_password_err)){

		$sql = "INSERT INTO user (username,firstname,lastname, password, adress, mail) VALUES (?, ?, ?, ?, ?, ?)";

		if($stmt = mysqli_prepare($conn, $sql)){

			mysqli_stmt_bind_param($stmt, "ssssss", $param_newUsername, $param_first, $param_last, $param_newPassword, $param_adress, $param_mail);

			$param_newUsername = $newUsername;
			$param_newPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Creates a password hash
			$param_mail = $newMail;
			$param_first = $newfirstname;
			$param_last= $newlastname;
			$param_adress = $newadress;

			if(mysqli_stmt_execute($stmt)){
				//redirect to login page
				header("location: login.php");
				exit;
				$newMail= $newUsername= $newfirstname = $newlastname = $newadress = "";
			} else{
				echo "Something went wrong. Please try again later.";
			}

			mysqli_stmt_close($stmt);
		}
	}
}

mysqli_close($conn);

$_SESSION['cart']=array();
?>


<!DOCTYPE html>
<html>
<head>
	<title>ALCA - Login page</title>
	<meta charset="utf-8" />
	<link href="css/prime.css" rel="stylesheet" type="text/css" />
	<link href="css/style-index.css" rel="stylesheet" type="text/css" />
	<link href="css/login.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>
	<?php include "navbar.php"; ?>
	<div class="loginpage">
		<div class="form">
			<form class="register" action="login.php" method="post">
				<input type="text" placeholder="Username" name="newUsername"
				value="<?php if(isset($newUsername))echo $newUsername; ?>" required/>
				<p style="color:black;"><?php if(isset($newUsername_err))echo $newUsername_err; ?></p>
				<input type="text" placeholder="First name" name="newfirstname"
				value="<?php if(isset($newfirstname))echo $newfirstname; ?>" required/>
				<input type="text" placeholder="Last name" name="newlastname"
				value="<?php if(isset($newlastname))echo $newlastname; ?>" required/>
				<input type="text" placeholder="Adress" name="newadress"
				value="<?php if(isset($newadress))echo $newadress; ?>" required/>
				<input type="password" placeholder="Password" name="newPassword" required/>
				<p style="color:black;"><?php if(isset($newPassword_err))echo $newPassword_err; ?></p>
				<input type="password" placeholder="Confirm Password" name="confirmPassword" required/>
				<p style="color:black;"><?php if(isset($confirm_password_err))echo $confirm_password_err; ?></p>
				<input type="text" placeholder="Email" name="newMail"
				value="<?php if(isset($newMail))echo $newMail; ?>" required/>

				<input id="switch-1" type="checkbox" class="checkCgu" required/>
				<label for="switch-1"><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Terms of use</a></label>

				<button>CREATE</button>
				<p class="lmessage">Already registered? <a href="#">Sign In</a></p>
			</form>
			<form class="login" action="login.php" method="post">
				<input type="text" placeholder="username" name="username"
				value="<?php if(isset($username))echo $username; ?>" required/>
				<p style="color:black;"><?php if(isset($username_err))echo $username_err; ?></p>
				<input type="password" placeholder="password" name="password" required/>
				<p style="color:black;"><?php if(isset($password_err))echo $password_err; ?></p>
				<button>LOGIN</button>
				<p class="lmessage">Not registered? <a href="#">Create an account</a></p>
			</form>
		</div>
	</div>
</body>

</html>
<script type="text/javascript">
	$('.lmessage a').click(function(){
		$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
	});
	<?php if(isset($_POST["newUsername"]))
	echo '$("form").animate({height: "toggle", opacity: "toggle"}, "0");'
	?>
</script>
