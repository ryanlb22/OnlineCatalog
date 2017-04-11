<?php

$host = "localhost";
$dbname = "music";
$username = "web_user";
$password = "s3cr3t";

//Creating database connection
$dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// Setting Errorhandling to Exception
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

//include "../../database.php";
//$dbConn = getDatabaseConnection("tech_checkout");

function getSongs() {
    global $dbConn;

    $sql = "SELECT * FROM song NATURAL JOIN artist NATURAL JOIN album ORDER BY songName";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $records;
    
}

function getArtists() {
    global $dbConn;
    
    $sql = "SELECT DISTINCT artistName FROM artist ORDER BY artistName";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
    
}

function getAlbum() {
    global $dbConn;
    
    $sql = "SELECT DISTINCT albumName FROM album ORDER BY albumName";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
}

function getFilters($filter) {
    global $dbConn;
    $sql = "SELECT * FROM song NATURAL JOIN artist NATURAL JOIN album" . $filter;
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
    
}


function theSearch() {
    $filter = " WHERE 1";
    if (!empty($_GET['songName'])) {
        $filter = $filter . " AND songName like '%" . $_GET['songName'] ."%'";
    }
    if (!empty($_GET['artistName'])) {
        $filter = $filter . " AND artistName = '" . $_GET['artistName'] . "'";
    }
    if (!empty($_GET['albumName'])) {
        $filter = $filter . " AND albumName = '" . $_GET['albumName'] . "'";
    }
    $filter = $filter . " ORDER BY " . 'songName' . " " . $_GET['asc'];
    
    $songs = getFilters($filter);
    echo "<div style ='float:left'>";
    echo "<table>";
    echo "<tr><th>Song Name</th><th>Artist Name</th><th>Album Name</th><th>Price</th></tr>";
    foreach($songs as $song) {
        $url = $song['songId'];
        echo "<tr>";
        echo "<td>" . "<a href='songInfo.php?songId=" . $url . "' target='songInfoFrame'>" . $song['songName'] . "</a></td>";
        echo "<td>" . "<a href='artistInfo.php?artistName=".$song['artistName']."'target='artistInfoFrame'>" . $song['artistName'] . "</a> "  . "</td>";
        echo "<td>" . $song['albumName'] . "</td>";
        echo "<td>" . $song['price'] . "</td>";
        echo "</tr>";
    }
    echo"</table>";
    echo "</div>";
    
}


function isFormValid() {
    if ( isset($_GET['submitForm']))
    {
        return true;
    }
    return false;
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Music Library </title>
        <style>
            @import url("css/styles.css");
        </style>
    </head>
    <body>
        <h1>Music Library</h1>
        
        <form method="GET" action"SQL.php">
            
            Song: <input type="text" name="songName"/><br />
            Artist:    <select name="artistName">
                       <option value="">Select One</option>
                       <?php
                          $artists = getArtists();
                          foreach ($artists as $artist) {
                              echo "<option value = '" . $artist['artistName'] ."'>" . $artist['artistName']    ." </option>";
                          }
                        ?>
                     </select><br />
            Album: <select name="albumName">
                           <option value="">Select One</option>
                                <?php
                                  $albums = getAlbum();
                                  foreach ($albums as $album) {
                                      echo "<option value = '" . $album['albumName'] ."'>" . $album['albumName']    ." </option>";
                                  }
                                ?>
                            </select><br />
            Sort By Song: 
                    <input type="radio" name="asc" value="ASC" checked/> Ascending
                    <input type="radio" name="asc" value="DESC"/> Descending<br />
                     <input type="submit" value="Search" name="submitForm"/>
                     
                     <input type ="button" value="Shopping Cart" name="shoppingCart" onclick="location.href='shoppingCart.php'"/>
               
        </form><br />
        <div id="songsAndInfo">
            <div id='songList'>
                <?php
                if (isFormValid())
                {
                    theSearch();
                }
                else {
                    theSearch();
                }
                ?>
            </div>
            <div id="songInfo" style = "float:center">
                <iframe src="" width="400" height="400" name="songInfoFrame"></iframe>
            </div>
        </div>
        
    </body>
</html>