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
    if (!empty($_GET['sort'])) {
        $filter = $filter . " ORDER BY " . $_GET['sort'] . " " . $_GET['asc'];
    }
    
    $songs = getFilters($filter);
    
    echo "<table>";
    echo "<tr><th>Song Name</th><th>Artist Name</th><th>Album Name</th></tr>";
    foreach($songs as $song) {
        echo "<tr>";
        echo "<td>" .$song['songName'] . "</td><td>" . $song['artistName']  . "</td><td>" . $song['albumName'] . "</td>";
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
            
            Song: <input type="text" name="songName"/>
            Artist:    <select name="artistName">
                       <option value="">Select One</option>
                       <?php
                          $artists = getArtists();
                          foreach ($artists as $artist) {
                              echo "<option value = '" . $artist['artistName'] ."'>" . $artist['artistName']    ." </option>";
                          }
                        ?>
                     </select>
            Nationality: <select name="nationality">
                           <option value="">Select One</option>
                                <?php
                                  $nationalities = getNationality();
                                  foreach ($nationalities as $nationality) {
                                      echo "<option value = '" . $nationality['nationality'] ."'>" . $nationality['nationality']    ." </option>";
                                  }
                                ?>
                            </select>
            Sort By: <select name="sort">
                        <option value="">Select One</option>
                        <option value="songName">Song</option>
                        <option value="artistName">Artist</option>
                    </select>
                    <select name="asc">
                        <option value="ASC">Ascending</option>
                        <option value="DESC">Descending</option>
                    </select>
                     <input type="submit" value="Search" name="submitForm"/>
            
            
            
        </form>
        
        <?php
        if (isFormValid())
        {
            theSearch();
        }
        else {
            $songs = getSongs();
            echo "<table>";
            echo "<tr><th>Song Name</th><th>Artist Name</th><th>Album Name</th></tr>";
            foreach($songs as $song) {
                echo "<tr>";
                echo "<td>" .$song['songName'] . "</td><td>" . "<a href='artistInfo.php?artistName=".$song['artistName']."'target='artistInfoFrame'>" . $song['artistName'] . "</a> "  . "</td><td>" . $song['albumName'] . "</td>";
                echo "</tr>";
            }
            echo"</table>";
            
        }
        ?>

    </body>
</html>