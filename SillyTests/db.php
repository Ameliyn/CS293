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

function getActorByName($db, $firstName, $lastName){

try {
$stmt = $db->prepare("SELECT * FROM actors WHERE first_name=:firstName and last_name=:lastName");
$data=array(":firstName"=>$firstName, ":lastName"=>$lastName);
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