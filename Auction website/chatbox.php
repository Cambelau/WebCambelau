<?php
// This is the chatbox page where you can chat with someone who wants to make negociate a price
 session_start();
 include 'database.php';?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src="script-product.js">
</script>

<head>
  <meta charset="utf-8" http-equiv="refresh" content="15">
  <link href="css/prime.css" rel="stylesheet" type="text/css" />
  <link href="css/style-product.css" rel="stylesheet" type="text/css" />
  <title>ALCA</title>
</head>


<body>
<?php include "navbar.php"; ?>

<div class="sellcontainer">

    <div class="navmenusellers">
      <ul>
        <li><a href="chatbox.php">Chat with client </a></li>
        <li><a href="sell.php">Add Product </a></li>
      </ul>
    </div>

  <div class="upcontainer">
  <?php $id_seller = $_SESSION['id'];
   $rslt=$conn->query("SELECT  DISTINCT id_client FROM `chat` WHERE `id_seller` = $id_seller");
   echo "<center><h2>Chat box with client </h2></center>";
   echo "<table id='tablechat'border='5px solid white'>";
    while($message=$rslt->fetch_assoc())
    {
     $id_client=$message['id_client'];
     echo "<tr><td id='$id_client'>";
     echo "Client : ".$id_client;
     echo "</td></tr>";
    }
    echo "</table>";
  ?>
</div>

<div class="chat">
<div class="chatbis">
  <?php
   if(isset($_GET['id_client']))
   {
   $id_seller=$_GET['id_seller'];
   $id_client=$_GET['id_client'];

   if(isset($_POST['mes']))
   {
    $chat_mes=$_POST['mes'];

    if(strpos($chat_mes,'!') !== false)
    {
    $statut = ltrim($chat_mes, '!');
    if($statut=='a'){
    $requete="UPDATE `chat` SET `statut` = 'true' WHERE `id_client` =$id_client AND id_seller=$id_seller";
    $conn->query("INSERT INTO chat (`id`, `id_seller`, `id_client`, `message`) VALUES (NULL,$id_seller,$id_client,'The seller accepted your offer !')");
    }else
    $requete="UPDATE `chat` SET `statut` = 'false' WHERE `id_client` =$id_client AND id_seller=$id_seller";
    }else{
    $requete="INSERT INTO `chat` (`id`, `id_seller`, `id_client`, `message`) VALUES (NULL,$id_seller,$id_client,'$chat_mes');";
    }
    $conn->query($requete);
   }
   $rslt=$conn->query("SELECT message FROM `chat` WHERE `id_client`=$id_client AND id_seller=$id_seller  ORDER BY id ASC");

   echo "<table>";
   if(!empty($rslt->fetch_assoc())){
   while($message=$rslt->fetch_assoc())
   {
    echo "<tr><td>";
    echo $message['message']."<br>";
    echo "</td></tr>";
   }
   echo "</table>"; }


   $rslt=$conn->query("SELECT * FROM `chat` WHERE `id_client`=$id_client AND id_seller=$id_seller AND offer!=' ' ORDER BY id DESC");
   $bestoffer=$rslt->fetch_assoc();
}
   ?>

  </div>

  <form method="post">
    <?php if(isset($bestoffer['id_product']))echo "Id : ".$bestoffer['id_product']." Price : ".$bestoffer['offer'];?>
    <input type="text" name="mes" id="bidx" value="" placeholder="message...">
    <input type="submit" name="" id="butn" value="SEND MESSAGE">
  </form>
</div>

</div>
</body>


<style type="text/css">
  body {
    font: bold 20px arial;
  }

  textarea {
    height: 100px;
    box-sizing: border-box;
    resize: none;
    border: 2px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
  }

  #butn {
    padding: 10px;
    margin: 20px;
    border-color: #f0f7ee;
    background-color: transparent;
    border-radius: 10px;
    cursor: pointer;
    color: #f0f7ee;
    font: bold 15px arial;
  }

  #bidx {
    margin: 10px;
    height: 30px;
  }

  .sellcontainer {
    display: flex;
    margin-top: 150px;
    margin-left: 0%;
  }

  .sellcontainer .navmenusellers {
    width: 250px;
    background-color: #87bba2;
    margin: 10px;
    margin-right: 50px;
    padding: 30px;
    border-radius: 10px;
    height: 430px;
  }

  .sellcontainer .upcontainer {
    background-color: #87bba2;
    margin: 10px;
    margin-right: 50px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    height: 430px;
    width: 80%;
  }

  .conditionscontainer{
    background-color: #87bba2;
    margin: 10px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    border-radius: 10px;
  }

  .message
  {
   height: 200px;
  }
  td {
    height: 30px;
    font-size: 25px;
    color: black;
    font: bold 15px arial;
  }
  .navmenusellers {
    list-style-type: none;
  }

  .navmenusellers ul {
    width: 200px;
    list-style-type: none;
  }

  .navmenusellers li {
    margin-bottom: 20px;
  }

  .navmenusellers a {
    text-decoration: none;
    border-color: #f0f7ee;
    background-color: transparent;
    border: 3px solid #f0f7ee;
    border-radius: 10px;
    cursor: pointer;
    color: #f0f7ee;
    font: bold 15px arial;
    padding: 5px;
  }

  .chat
  {
    margin: 20px;
   padding: 30px;
   flex: left;
   height: 420px;
   width: 50%;
   background-color: #87bba2;
   border-radius: 10px;
  }

  .chatbis
  {
    padding: 10px;
    background-color: #fff07c;
    border-radius: 10px;
    overflow: auto;
    height: 250px;
    margin-bottom: 30px;
  }
</style>
<script type="text/javascript">
  var t = document.getElementById("tablechat");
  var trs = t.getElementsByTagName("tr");
  var tds = null;

  for (var i = 0; i < trs.length; i++) {
    tds = trs[i].getElementsByTagName("td");
    for (var n = 0; n < tds.length; n++) {
      tds[n].onclick = function() {
        var id = document.getElementById(this.id).getAttribute('id');
       window.open("chatbox.php?id_client=" + id + "&id_seller=<?php echo $_SESSION['id']?>", "_self");
      }
    }
  }
</script>
</html>
