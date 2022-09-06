<?php

session_start();
include 'database.php';

$target_dir = "watchesimg/";



$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

//check the size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

//check type
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
$uploadOk = 0;
}

$idp=$_POST['idpro'];
$sqlId=$conn->query("SELECT * FROM `products` WHERE id=$idp");
 if($sqlId->num_rows !== 0)
 {
   $uploadOk = 0;
 }

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  echo "Sorry, there was an error uploading your file.";
    header("location: sell.php?up=false");
    exit;
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

    $id=$_POST['idpro'];
    $name = $_POST['title'];
    $price = $_POST['Price'];
    $description = $_POST['description'];
    $id_seller=$_SESSION["id"];
    $catego = $_POST['Categorie'];

    $starttime=$_POST['starttime'];
    $endtime=$_POST['endtime'];
    $nametpm = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));

    $requete = "INSERT INTO `products` (`id`, `Name`, `Categorie`, `Price`, `Description`, `Pictures`, `id_seller`) VALUES ('$id','$name','$catego','$price','$description','$nametpm','$id_seller')";
    $conn->query($requete);

    $requete2="INSERT INTO `best_bid` (`id`, `id_product`, `id_client`, `offer`, `status`, `start_time`, `stop_time`) VALUES (NULL,'$id',NULL,'0','true','$starttime','$endtime')";
    $conn->query($requete2);

    header("location: sell.php?up=true");
    exit;
  } else {
    echo "Sorry, there was an error uploading your file.";
    header("location: sell.php?up=false");
    exit;
  }
}
?>