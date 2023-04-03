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
            $stmt = $db->prepare("SELECT actors.first_name, actors.last_name, movies.name, movies.year FROM actors JOIN roles ON roles.actor_id=actors.id
            JOIN movies ON movies.id=roles.movie_id
            WHERE first_name LIKE :firstName AND last_name=:lastName
            ORDER BY first_name, movies.year");
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
            $stmt = $db->prepare("SELECT a2.first_name, a2.last_name, m.name, m.year
            FROM movies m
            JOIN roles r1 ON r1.movie_id = m.id
            JOIN roles r2 on r2.movie_id = m.id
            JOIN actors a1 on a1.id = r1.actor_id
            JOIN actors a2 on a2.id = r2.actor_id
            WHERE (a1.first_name LIKE :firstName1 and a1.last_name=:lastName1) AND
            (a2.first_name LIKE :firstName2 and a2.last_name=:lastName2)
            ORDER BY a2.first_name, m.year;");
            $data=array(":firstName1"=>$firstName1."%", ":lastName1"=>$lastName1,
            ":firstName2"=>$firstName2."%", ":lastName2"=>$lastName2);
            $stmt->execute($data);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($rows){
                return $rows;
            }
            else{
                return ["No commonality between ".$firstName1." ".$lastName1." and ".$firstName2." ".$lastName2];
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
