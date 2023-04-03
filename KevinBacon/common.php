<!DOCTYPE html>

<?php
    $firstname = $_GET["firstname"];
    $lastname = $_GET["lastname"];

    function ConnectToDatabase(){
        $servername = "www.watzekdi.net";
        $username = "watzekdi_cs393";
        $password = "KevinBac0n";
        $database = "watzekdi_imdb";
        $dbport = 3306;
    
        try {
            $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8;port=$dbport", $username, $password);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $db;
    }

    function GetMovieNameAndID($firstName, $lastName){
        $db = ConnectToDatabase();
        try {
            $stmt = $db->prepare("SELECT movies.name, movies.year FROM actors JOIN roles ON roles.actor_id=actors.id 
            JOIN movies ON movies.id=roles.movie_id
            WHERE first_name LIKE :firstName AND last_name=:lastName");
            $data=array(":firstName"=>$firstName."%", ":lastName"=>$lastName);
            $stmt->execute($data);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($rows)
            {
                return $rows;
            }
            else{
                return false;
            }
            
            } catch (Exception $e) {
            return false;
            }
    }

    function GetMoviesWith($firstName1, $lastName1, $firstName2, $lastName2){
        $db = ConnectToDatabase();
        try {
            $stmt = $db->prepare("SELECT movies.name, movies.year FROM actors 
            JOIN roles ON roles.actor_id=actors.id 
            JOIN movies ON movies.id=roles.movie_id
            WHERE (first_name LIKE :firstName1 and last_name=:lastName1);");
            $data=array(":firstName1"=>$firstName1."%", ":lastName1"=>$lastName1);
            $stmt->execute($data);
            $rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($rows1)
            {
                $stmt = $db->prepare("SELECT movies.name, movies.year FROM actors 
                JOIN roles ON roles.actor_id=actors.id 
                JOIN movies ON movies.id=roles.movie_id
                WHERE (first_name LIKE :firstName2 and last_name=:lastName2);");
                $data=array(":firstName2"=>$firstName2."%", ":lastName2"=>$lastName2);
                $stmt->execute($data);
                $rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);   
                if($rows2){
                    $result = [];
                    foreach($rows1 as $row1){
                        if(in_array($row1, $rows2))
                        {
                            array_push($result, $row1);
                        }
                    }
                    return $result;
                }
                else{
                    return ["No database entry for ".$firstName2." ".$lastName2];
                }
            }
            else{
                return ["No database entry for ".$firstName1." ".$lastName1];
            }
            
            } catch (Exception $e) {
            return false;
            }
    }

    function getHead(){
        echo '<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />
		<link href="http://localhost:8080/Desktop/CS293/images/favicon.ico" type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" /></head>';
    }
    function getHeader(){
        echo '<div id="banner">
        <a href="mymdb.php"><img src="http://localhost:8080/Desktop/CS293/KevinBacon/images/mymdb.png" alt="banner logo" /></a>
        My Movie Database
        </div>';
    }

    function getFooter(){
        echo '<div id="w3c">
        <a href="https://webster.cs.washington.edu/validate-html.php"><img src="http://localhost:8080/Desktop/CS293/KevinBacon/images/w3c-html.png" alt="Valid HTML5" /></a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="Valid CSS!" />
        </a>
        </div>';
    }
    function getForms(){
            echo '
            <!-- form to search for every movie by a given actor -->
            <form action="search-all.php" method="get">
                <fieldset>
                    <legend>All movies</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
                        <input name="lastname" type="text" size="12" placeholder="last name" /> 
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>

            <!-- form to search for movies where a given actor was with Kevin Bacon -->
            <form action="search-kevin.php" method="get">
                <fieldset>
                    <legend>Movies with Kevin Bacon</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" /> 
                        <input name="lastname" type="text" size="12" placeholder="last name" /> 
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>
            ';

    }

?>

<html>
	

	
</html>
