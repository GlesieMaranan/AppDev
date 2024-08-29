<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_product";
$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

//optional set of attributes to set
$options = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    );
//connection string (ito na yung tatawagin natin kapag mageexecute na ng query)
$con = new PDO($dsn, $username, $password, $options);
?>