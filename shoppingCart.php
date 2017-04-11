<?php
session_start();
$host = "localhost";
$dbname = "music";
$username = "web_user";
$password = "s3cr3t";
//Creating database connection

$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// Setting Errorhandling to Exception
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function getAlbumCover($artist, $album) {
    if ($album == "illumative") // album was named wrong
        $album = "illuminate";
    elseif ($album == ":") // album only comes up under shape of you name
        $album = "shape of you";
    $artist = urlencode($artist);
    $album = urlencode($album);
    $response = "http://ws.audioscrobbler.com/2.0/?method=album.getinfo&artist={$artist}&album={$album}&api_key=fadfa11f235800e289aeca6bdae5d54f&format=json";
    $json = file_get_contents($response);
    if(!$json) {
        return;  // Artist lookup failed.
    }
    $array = json_decode($json,true);
    echo "<tr><td rowspan='7'><img src='". $array['album']['image'][2]['#text'] . "' /></td></tr>";
}
function displayCart(){
    $_SESSION['cart'];
    global $dbConn;
    global $record;
    if(!isset($_SESSION['cart']))
    {
        echo "<h1> Nothing in the cart </h1>";
        return;
    }
    $sql = array();
    foreach ($_SESSION['cart'] as &$newID){
    $sql = "SELECT * FROM song NATURAL JOIN artist NATURAL JOIN album WHERE songId = " . $newID;


    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $record = $records[0];
    echo "<center> <table>";
    getAlbumCover($record['artistName'], $record['albumName']);
    echo "<tr><td>" . $record['songName'] ."</td></tr>";
    echo "<tr><td>" . "Artist: " . $record['artistName'] ."</td></tr>";
    echo "<tr><td>" . "Album: " . $record['albumName'] ."</td></tr>";
    echo "<tr><td>" . "Year: " . $record['year'] ."</td></tr>";
    echo "<tr><td>" . "Length: " . $record['length'] ."</td></tr>";
    echo "<tr><td>" . "Price: " .$record['price'] ."</td></tr>";
    echo "</table>";
    $totalPrice += $record['price'];
    }
    echo "<h3> Total Price: " .$totalPrice . "</h3></center>";
}
if(isset($_GET['purchase']))
{
    unset($_SESSION['cart']);
}
?>
<html>
    <head>
        <title>Shopping Cart</title>
        <style>
  body{
                width:800px;
                margin:0 auto;
                border:5px ridge blue;
                text-align:center;
        }
        </style>
    </head>
    <body>
        <center><h1>Shopping Cart</h1></center> 
    <?php

    displayCart();
    
    ?>
    <form>
    <input type="submit" name="purchase" value="Purchase Songs"/>
    <input type ="button" value="Add More" name="addMore" onclick="location.href='index.php'"/>
    </form>
    </body>
</html>