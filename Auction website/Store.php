<?php if(!isset($_SESSION)) session_start(); ?>
<?php
include "database.php";
global $cat ;
$cat = $_GET['cat'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>ALCA - Store</title>
  <link href="css/prime.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <?php include "navbar.php"; ?>
  <div class="box">
    <div class="table-product">
      <table id="table-store">
        <div class="sortby">
          <form class="" method="get">

            <span>search :</span><input type="text" name="search" value="">
            <span>min :</span>
            <select class="" name="pricerange_min">
              <option value="0" selected="selected">0$</option>
              <option value="100">100$</option>
              <option value="200">200$</option>
              <option value="400">400$</option>
              <option value="800">800$</option>
              <option value="1600">1600$</option>
              <option value="2000">+2000$</option>

            </select>
            <span>max :</span>
            <select class="" name="pricerange_max">
              <option value="100">100$</option>
              <option value="200">200$</option>
              <option value="400">400$</option>
              <option value="800">800$</option>
              <option value="1600">1600$</option>
              <option value="2000" selected="selected">+2000$</option>
            </select>

            <span>sort by</span>
            <select class="" name="sort" onchange="this.form.submit();">
              <option value="Mostpopulaire" selected="selected">Most Pouplar</option>
              <option value="Highprice">Highest Price</option>
              <option value="Lowerprice">Lower Price</option>
            </select>
            <input type="submit" name="" value="Filtre">
            <input type="hidden" name="cat" value="<?php echo $cat ?>">
          </form>
        </div>

        <?php
        $range='';
        $sort="Mostpopulaire";

        if(isset($_GET['sort'])){
          $sort = $_GET['sort'];
        }

        if(isset($_GET['pricerange_min']) && isset($_GET['pricerange_max'])){
          $princerange_min = $_GET['pricerange_min'];
          $princerange_max = $_GET['pricerange_max'];
          $range = " AND Price BETWEEN $princerange_min AND $princerange_max";
        }

//SELECT * FROM `products` WHERE Categorie='Watches' AND Price BETWEEN 100 AND 300 ORDER BY price DESC

        switch ($sort){

          case 'Mostpopulaire':
          $requete="SELECT * FROM products WHERE Categorie='$cat'".$range;
          break;
          case 'Highprice':
          $requete="SELECT * FROM `products`WHERE Categorie='$cat'".$range." ORDER BY price DESC " ;
          break;
          case 'Lowerprice':
          $requete="SELECT * FROM `products` WHERE Categorie='$cat'".$range."  ORDER BY price ASC " ;
          break;

          default:
          $requete="SELECT * FROM products WHERE Categorie=$cat";
          break;
        }
        if(isset($_GET['search'])){
          $tmpval = $_GET['search'];


          if(strlen($tmpval)!=0){
            $search = $_GET['search'];
            $requete="SELECT * FROM `products` WHERE `Name` LIKE '%$search%'";
          }
        }
        $result= $conn->query($requete);

        $i=0;

        while($product = $result->fetch_assoc())
        {
          $i++;
          $id=$product["id"];
          $Name=$product["Name"];
          $Pic=$product["Pictures"];
          $Price=$product["Price"];

          if($i==5)
            {echo "<tr>";}

          echo "<td id=$id><img src=watchesimg/$Pic width='330' height='330'><br><br>$Price$<br>$Name</td>";

          if($i==4)
            {echo "<tr>";
          $i=0;}
        };
        ?>
      </table>
    </div>
  </div><br>
</body>

<style type="text/css">
  .box {
    margin-top: 50px;
    margin-left: -100px;
    width: 1580px;
    background-color: transparent;
    border-radius: 10px;
  }

  .box .nav-product {
    flex: left;
    width: 0%;
  }

  .box .table-product {
    flex: left;
  }
  #table-store {
    background-color: transparent;
    border-spacing: 15px;
    align-items: center;
    border-radius: 10px;
  }

  td {
    width: 200px;
    border-radius: 2%;
    padding: 20px;
    text-align: center;
    color: black;
    background-color: white;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid #ffffff;
  }

  /*td:hover{
    background-color: #f0f7ee;
    }*/
    td:hover{
      border: 3px solid #fff07c;
    }

    .sortby{
      padding-top: 10px;
      width: 1550px;
      height: 20px;
      background-color: transparent;
      text-align: right;
    }
  </style>
  </html>

  <script type="text/javascript">
    var t = document.getElementById("table-store");
    var trs = t.getElementsByTagName("tr");
    var tds = null;

    for (var i = 0; i < trs.length; i++) {
      tds = trs[i].getElementsByTagName("td");
      for (var n = 0; n < tds.length; n++) {
        tds[n].onclick = function() {
          var id = document.getElementById(this.id).getAttribute('id');
          window.open("product.php?id="+id,"_self");
        }
      }
    }
  </script>
