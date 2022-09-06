<!-- Shortcut to include the navigation bar in every pages -->
<p align="center"><img src="img/logozak.png" alt="Logo" width="100" height="100"></p>

<nav>
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
</nav>
