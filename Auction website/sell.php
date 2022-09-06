<?php if(!isset($_SESSION)) session_start(); ?>
<!-- SELL PAGE, you can add a item for sale in the website -->
<?php
 include 'database.php';?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src="script-product.js">
</script>
<head>
  <meta charset="utf-8">
  <link href="css/prime.css" rel="stylesheet" type="text/css" />
  <link href="css/style-product.css" rel="stylesheet" type="text/css" />
  <title>ALCA - Sell page</title>
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="sellcontainer">
    <div class="navmenusellers">
      <ul>
        <li><a href= "chatbox.php">Chat with client </a></li>
        <li><a href= "sell.php">Add Product </a></li>
      </ul>
    </div>
    <div class="upcontainer">
      <form method="post" action="sellUpload.php" enctype="multipart/form-data">
        <div>
          <label>Select the pictures to upload : </label><br><br>
          <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div>
          <br>Title : <br><input type="text" id="bidx" name="title" placeholder="title" required>
        </div>
        <div>
          <br>Id : <br><input type="number" id="bidx" name="idpro" required>
        </div>
        <div>
          <br>Write description : <br><textarea name="description" cols="50" required></textarea>
        </div>
        <?php
        if (isset($_GET["up"]) && $_GET["up"]==="true") {
            echo "<p>Your item has been uploaded</p>";
         }
        if (isset($_GET["up"]) && $_GET["up"]==="false") {
            echo "<p>Item failed to upload</p>";
         } 
         ?>
        <div>
          <input type="submit" name="" id="butn">
        </div>
      </div>
      <div class="conditionscontainer">
        <div>
          <label>Buy now price : </label><br>
          <input type="number" id="bidx" name="Price"  required>
        </div>
        <div>
          <label>Category : </label><br>
          <select class="" name="Categorie" id="bidx">
            <option value="Watches">Watches</option>
            <option value="Accessories">Accessories</option>
          </select>
        </div>
        <div>
          <label>Start date : </label><br>
          <input type="date" id="bidx" name="starttime" value="2021-04-04" min="2017-09-04" max="2022-09-31">
        </div>
        <div>
          <label>End date : </label><br>
          <input type="date" id="bidx" name="endtime" value="2021-04-04" min="2017-09-04" max="2022-09-31">
        </div>
      </form>
    </div>
  </div>

</body>
<style type="text/css">
  body{
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
  #butn{
    width: 100px;
    height: 40px;
    margin: 20px;
    border-color: #f0f7ee;
    background-color: transparent;
    border-radius: 10px;
    cursor: pointer;
    color: #f0f7ee;
    font: bold 15px arial;
  }
  #bidx{
    margin: 10px;
    height: 30px;
  }
  .sellcontainer{
    display: flex;
    margin-top: 150px;
    margin-left: 10%;
  }

  .sellcontainer .navmenusellers
  {
    background-color: #87bba2;
    margin: 10px;
    margin-right: 50px;
    padding: 30px;
    border-radius: 10px;
  }

  .upcontainer{
    background-color: #87bba2;
    margin: 10px;
    margin-right: 50px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    border-radius: 10px;
  }
  .conditionscontainer{
    background-color: #87bba2;
    margin: 10px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    border-radius: 10px;
  }

  .navmenusellers {
    list-style-type: none;
  }

  .navmenusellers ul {
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

</style>
</html>
