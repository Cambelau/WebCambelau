<?php if(!isset($_SESSION)) session_start(); ?>
<!-- Seller profile page, here you have information on the seller and this also where you can start negociating with the seller on an item -->
<?php
include 'database.php';

if(!isset($_SESSION["loggedin"])){
  header("location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src="script-product.js">
</script>
<head>
  <meta charset="utf-8" http-equiv="refresh" content="15">
  <link href="css/prime.css" rel="stylesheet" type="text/css" />
  <link href="css/style-product.css" rel="stylesheet" type="text/css" />
  <title>ALCA - Seller profil</title>
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="container">

    <div class="profil">
      <?php
      $id_seller=$_GET['id_seller'];
      $sql2 = "SELECT * FROM user WHERE id = $id_seller ";
      $sth2 = $conn->query($sql2);
      $result=mysqli_fetch_array($sth2);
      $userImg=$result['userImg'];
      $selusername=$result["username"];

      if($userImg!=NULL)
        echo '<img src="data:image/jpg;base64,'.base64_encode( $userImg ).'" alt="User Image" width="100px" height="100px" align="left" style="border-radius: 10px" ><br>';
      else
        echo '<img src="img/userpicture.jpg" alt="User Imagepic" width="100px" height="100px" align="left" style="border-radius: 10px;"><br>';

      ?>
      <p class="uName">Seller : <?php echo $selusername; ?></p><br><br><br><br>
      <div class="Last-sell">
        <h2>Products for sale </h2>
        <table id="tableau" class="producttable">
         <?php
         $rslt1= $conn->query("SELECT * FROM products WHERE id_seller=$id_seller");
         while($product_offer = $rslt1->fetch_assoc())
         {
           $Pic=$product_offer["Pictures"];
           $id_product=$product_offer['id'];
           echo "<tr><td id='c$id_product'><img src=watchesimg/$Pic width='80' height='80'>";
           $name=$product_offer["Name"];
           $Price=$product_offer["Price"];
           echo "$name $Price$</td></tr>";
         }; ?>
       </table>
     </div>
   </div>


   <div class="chat">
    <div class="chatbis">
     <?php

     $id=$_SESSION['id'];
     $id_product=$_GET['id_product'];

     if(isset($_POST['mes']))
     {
      $chat_mes=$_POST['mes'];
      if(strpos($chat_mes,'!') !== false)
      {
        $nbr=$conn->query("SELECT message FROM `chat` WHERE `id_client` = $id AND id_seller=$id_seller AND id_product=$id_product ");
        if ($conn->affected_rows < 5)
        {
          $offer = ltrim($chat_mes, '!');
          $requete="INSERT INTO `chat` (`id`, `id_seller`, `id_client`,`message`,`offer`,`id_product`) VALUES (NULL,$id_seller,$id,'$chat_mes',$offer,$id_product);";
          $conn->query($requete);
        }else
        {
          $requete="INSERT INTO `chat` (`id`, `id_seller`, `id_client`, `message`) VALUES (NULL,$id_seller,$id,'You cant make more than 5 offer !');";
          $conn->query($requete);
        }
      }
      else
      {
        $requete = "INSERT INTO `chat` (`id`, `id_seller`, `id_client`, `message`) VALUES (NULL,$id_seller,$id,'$chat_mes');";
        $conn->query($requete);
      }
    }

    $rslt=$conn->query("SELECT message FROM `chat` WHERE `id_client` = $id AND id_seller=$id_seller ORDER BY id ASC");
    echo "<table>";
    while($message=$rslt->fetch_assoc())
    {
      echo "<tr><td>";
      echo "message : ".$message['message']."<br>";
      echo "</td></tr>";
    }
    echo "</table>";

    $rslt=$conn->query("SELECT * FROM `chat` WHERE `id_client` = $id AND id_seller=$id_seller AND id_product=$id_product ORDER BY offer DESC");
    $bestoffer=$rslt->fetch_assoc();

    if(isset($_POST['but']) && $bestoffer['statut']=='true')
    {
     $id_p = $bestoffer['id_product'];
     $id_c = $bestoffer['id_client'];
     $offer = $bestoffer['offer'];

     $requete= "INSERT INTO `sold_products` (`id`, `id_product`, `id_client`, `price`) VALUES (NULL,$id_p,$id_c,$offer)";
     echo $requete;
     $conn->query($requete);
     echo '
     <script type="text/javascript">',
     'buynotif(1,'.$offer.');',
     '</script>';

   }
   ?>


 </div>
 <form method="post">
  <input type="submit" name="but"
   <?php if(isset($bestoffer['offer'])) echo "value='Buy : " . $bestoffer['offer'] . "'";
          else echo "value='Make a offer by using ! (ex: !100)'";  ?>
   >
</form>
<form method="post">
  <input type="text" name="mes" value="" required>
  <input type="submit" name="" value="SEND MESSAGE">
</form>

</div>
</div>
</body>
<script type="text/javascript">
document.getElementById('c<?php echo $id_product?>').style.border="2px solid red";

var t = document.getElementById("tableau");
var trs = t.getElementsByTagName("tr");
var tds = null;

for (var i = 0; i < trs.length; i++) {
  tds = trs[i].getElementsByTagName("td");
  for (var n = 0; n < tds.length; n++) {
    tds[n].onclick = function() {
      var id = document.getElementById(this.id).getAttribute('id');
      var s2 = id.substring(1);
      window.open("product.php?id="+s2,"_self");
    }
  }
}



</script>
</html>

<style type="text/css">
  input {
    font-family: "Roboto", sans-serif;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    border: 1px solid black;
    font-size: 14px;
  }
  .container
  {
    display: flex;
    background: transparent;
  }
  .container .profil
  {
    margin: 20px;
    padding: 30px;
    height: 470px;
    flex:left;
    width: 50%;
    background-color: #87bba2;
    border-radius: 10px;
  }

  .container .chat
  {
    margin: 20px;
    padding: 30px;
    flex: left;
    height: 470px;
    width: 50%;
    background-color: #87bba2;
    border-radius: 10px;
  }

  .container .chatbis
  {
    padding: 10px;
    background-color: #fff07c;
    border-radius: 10px;
    overflow: auto;
    height: 250px;
    margin-bottom: 30px;
  }

  .uName{
    color: white;
    margin-left: 130px;
    font-weight : bold;
  }

  .Last-sell {
    background-color: #fff07c;
    width: 100%;
    height: 360px;
    flex: left;
    overflow: auto;
    border-radius: 10px;
  }

  .Last-product::-webkit-scrollbar, .Last-sell::-webkit-scrollbar, .Last-offer::-webkit-scrollbar {
    display: none;
  }

  h2{
    color: black;
    width: 546px;
    position: absolute;
    text-align: center;
    background-color: white;
    border: 2px solid black;
    font: bold 22px arial;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .producttable{
    margin-top: 30px;
    border-spacing: 15px;
    width: 100%;
  }

  td{
    padding: 3px;
    color: black;
    width: 100%;
  }

</style>
