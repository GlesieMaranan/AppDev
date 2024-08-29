<?php
if ( isset( $_GET["Id"] ) ) {
    $id =  $_GET["Id"] ;


$servername = "localhost";
$username = "root";
$password = "";
$database = "my_product";

$connection = new mysqli($servername, $username, $password, $database);

$sql = "DELETE FROM product WHERE Id=$id";
$connection->query($sql);

}

header("location: index.php");
exit;

 ?>