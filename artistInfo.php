<?php
function getArtistPhoto($artist) {
                $artist = urlencode($artist);
                $response    = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist={$artist}&api_key=fadfa11f235800e289aeca6bdae5d54f&format=json";
                $json    = file_get_contents($response);
                
                if(!$json) {
                        return;  // Artist lookup failed.
                }

                $array = json_decode($json,true);
                //print_r($array['artist']['image'][3]['#text']);
                return "<img src='". $array['artist']['image'][3]['#text'] . "' />";
}

function getArtistInfo($artist) {
    $artist = urlencode($artist);
                $response    = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist={$artist}&api_key=fadfa11f235800e289aeca6bdae5d54f&format=json";
                $json    = file_get_contents($response);
                
                if(!$json) {
                        return;  // Artist lookup failed.
                }

                $array = json_decode($json,true);
                //print_r($array['artist']['bio']['content']);
                return "<p>". $array['artist']['bio']['content'] . "</p>";
}



?>
<!DOCTYPE html>
<html>
    <head>
        <title> User Info </title>
    </head>
    <body>

        <h2> Artist: <?=$_GET['artistName']?></h2>\
        
        <?php
            $artist = $_GET['artistName'];
            echo getArtistPhoto($artist);
            echo getArtistInfo($artist);
        ?>

    </body>
</html>