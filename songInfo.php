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

function populate() {
    global $dbConn;
    global $record;
    if (empty($_GET['songId'])){
        return;
    }
    $sql = "SELECT * FROM song NATURAL JOIN artist NATURAL JOIN album WHERE songId = " . $_GET['songId'];
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $record = $records[0];
/*if(isset($_SESSION['songVar']))
    {
     $_SESSION['songVar'] =0;
    }*/
    $_SESSION['songVar'] = $_GET['songId'];
   
    echo "<table>";
    getAlbumCover($record['artistName'], $record['albumName']);
    echo "<tr><td>" . $record['songName'] ."</td></tr>";
    echo "<tr><td>" . "Artist: " . $record['artistName'] ."</td></tr>";
    echo "<tr><td>" . "Album: " . $record['albumName'] ."</td></tr>";
    echo "<tr><td>" . "Year: " . $record['year'] ."</td></tr>";
    echo "<tr><td>" . "Length: " . $record['length'] ."</td></tr>";
    echo "<tr><td>" . "Price: " .$record['price'] ."</td></tr>";
    echo "</table>";
    
       

}

if(!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = array();
}
if(isset($_GET['addToCart']))
{
   // echo "Song ID " . $_SESSION['songVar'];
    array_push($_SESSION['cart'],$_SESSION['songVar']);
    echo "<br> Added to cart";
//    print_r( $_SESSION['cart']);
}
if(isset($_GET['clearCart']))
{
    unset($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> User Info </title>
      
    </head>
    <body>
        <h1>Song Info</h1>
        <?php
           populate();

        ?>
        <form>
        <input type="submit" name="addToCart" value="Add To Cart"/>
        <input type="submit" name="clearCart" value="Clear Cart"/>
        </form>

    </body>
</html>