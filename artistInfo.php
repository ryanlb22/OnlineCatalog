<?php
$json = "";
$array = "";
function callAPI($artist) {
    global $array;
    
    $artist = urlencode($artist);
    $response = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist={$artist}&api_key=fadfa11f235800e289aeca6bdae5d54f&format=json";
    $json = file_get_contents($response);
    
    if(!$json) {
        return;  // Artist lookup failed.
    }
    
    $array = json_decode($json,true);
}
function getArtistPhoto() {
    global $array;
    echo "<img src='". $array['artist']['image'][3]['#text'] . "' />";
}

function getArtistInfo() {
    global $array;
    echo "<h2>Biography: </h2>";
    echo "<p>". $array['artist']['bio']['content'] . "</p>";
}

function getSimilarArtists() {
    global $array;
    //print_r($array['artist']['bio']['content']);
    $artists = $array['artist']['similar']['artist'];
    echo "<h3>Similar Artists: </h2>";
    echo "<table><tr>";
    foreach($artists as $artist) {
        
        echo "<td>" . "<img src='". $artist['image'][2]['#text'] . "' />" . "</td>";
    }
    echo "</tr><tr>";
    foreach($artists as $artist) {
        echo "<td>" . "<a href='artistInfo.php?artistName=". $artist['name']."'target='artistInfoFrame'>" . $artist['name'] . "</a> "  . "</td>";
    }
    echo "</tr></table>";
    
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title> Artist Info </title>
    </head>
    <body>

        <h2> Artist: <?=$_GET['artistName']?></h2>
        
        <?php
            $artist = $_GET['artistName'];
            callAPI($artist);
            getArtistPhoto();
            getArtistInfo();
            getSimilarArtists();
        ?>

    </body>
</html>