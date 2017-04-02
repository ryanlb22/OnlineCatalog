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

function getNationality() {
    global $dbConn;
    
    $sql = "SELECT DISTINCT nationality FROM artist ORDER BY nationality";
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
    if (!empty($_GET['nationality'])) {
        $filter = $filter . " AND nationality = '" . $_GET['nationality'] . "'";
    }
    $filter = $filter . " ORDER BY " . 'songName' . " " . $_GET['asc'];
    
    $songs = getFilters($filter);
    
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
            Nationality: <select name="nationality">
                           <option value="">Select One</option>
                                <?php
                                  $nationalities = getNationality();
                                  foreach ($nationalities as $nationality) {
                                      echo "<option value = '" . $nationality['nationality'] ."'>" . $nationality['nationality']    ." </option>";
                                  }
                                ?>
                            </select><br />
            Sort By Name: 
                    <input type="radio" name="asc" value="ASC" checked/> Ascending
                    <input type="radio" name="asc" value="DESC"/> Descending<br />
                     <input type="submit" value="Search" name="submitForm"/>
        </form>
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
            <div id="songInfo">
                <iframe src="" width="400" height="250" name="songInfoFrame"></iframe>
            </div>
        </div>
        
    </body>
</html>