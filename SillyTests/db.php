<?php
/*** connection credentials *******/
$servername = "www.watzekdi.net";
$username = "watzekdi_cs393";
$password = "KevinBac0n";
$database = "watzekdi_imdb_small";
$dbport = 3306;

/****** connect to database **************/

try {
$db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8;port=$dbport", $username, $password);
}
catch(PDOException $e) {
echo $e->getMessage();
}

try {
$stmt = $db->prepare("select * from movies limit 10");

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/** see the resulting array **/
var_dump($rows);

/** loop through the rows: **/
foreach ($rows as $row){
$id=$row["id"];
$name=$row["name"];
$year=$row["year"];
echo "id: $id, name: $name, year: $year";
}

}
catch (Exception $e) {

echo $e;
}
function ConnectToDatabase(){
    /*** connection credentials *******/
    $servername = "www.watzekdi.net";
    $username = "watzekdi_cs393";
    $password = "KevinBac0n";
    $database = "watzekdi_imdb_small";
    $dbport = 3306;

    /****** connect to database **************/

    try {
    $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8;port=$dbport", $username, $password);
    }
    catch(PDOException $e) {
    echo $e->getMessage();
    }
}

function testyTests($db){

    try {
        $db = ConnectToDatabase();
        $stmt = $db->prepare("SELECT * FROM movies JOIN roles ON movies.id=roles.movie_id JOIN actors ON actors.id=roles.actor_id");
        $stmt->execute($data);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    } catch (Exception $e) {
        return false;
    }

}

function rolesInPi(){
    $db = ConnectToDatabase();
    try{
        $stmt = $db->prepare('SELECT roles.role FROM roles JOIN movies ON movies.id=roles.movie_id WHERE movies.name LIKE "PI"');
        $stmt->execute($data);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    } catch (Exception $e) {
        return false;
    }
}

function actorNameIdinPI(){
    $db = ConnectToDatabase();
    try{
        $stmt = $db->prepare('SELECT actors.first_name, actors.last_name,roles.role FROM roles 
        JOIN movies ON movies.id=roles.movie_id 
        JOIN actors ON actors.id=roles.actor_id
        WHERE movies.name LIKE "PI"');
        $stmt->execute($data);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    } catch (Exception $e) {
        return false;
    }

}



if ($rows=getActorByName($db, "Kevin", "Bacon")){
var_dump($rows);
}
else{
echo "no results";
}
?>