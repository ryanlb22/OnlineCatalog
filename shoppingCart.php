<?php
session_start();


$host = "localhost";
$dbname = "music";
$username = "root";
$password = "s3cr3t";
$record = "";
//Creating database connection
$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// Setting Errorhandling to Exception
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<html>
    <head>
        <title>Shopping Cart</title>

    </head>
    <body>
        <center><h1>Shopping Cart</h1></center>
    

    
    </body>
</html>