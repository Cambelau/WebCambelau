<?php       //Conenction with the database
            //error_reporting(E_ALL ^ E_NOTICE);
            global $conn ;
            $servername = 'mysql-zack242.alwaysdata.net';
            $usernameZ = 'zack242';
            $passwordZ = '0661150322';
            $database='zack242_projet';
            //On établit la connexion
           $conn = new mysqli($servername,$usernameZ,$passwordZ,$database);
            //On vérifie la connexion
            if($conn->connect_error){
                die('Erreur : ' .$conn->connect_error);
            }
        ?>

<?php include "script-auction.php"?>
