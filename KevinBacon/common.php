<!DOCTYPE html>

<?php
    $firstname = $_GET["firstname"];
    $lastname = $_GET["lastname"];

    function ConnectToDatabase(){
        $servername = "www.watzekdi.net";
        $username = "watzekdi_cs393";
        $password = "KevinBac0n";
        $database = "watzekdi_imdb_small";
        $dbport = 3306;
    
        try {
            $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8;port=$dbport", $username, $password);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $db;
    }

    function GetActor($firstName, $lastName){
        $db = ConnectToDatabase();
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

    function GetMoviesByActorId($actorID){
        $db = ConnectToDatabase();
        try {
            $stmt = $db->prepare("SELECT * FROM movies WHERE :actorID");
            $data=array(":firstName"=>$firstName, ":lastName"=>$lastName);
            $stmt->execute($data);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
            
            } catch (Exception $e) {
            return false;
            }
    }

    function getHead(){
        echo '<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />
		<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" /></head>';
    }
    function getHeader(){
        echo '<div id="banner">
        <a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
        My Movie Database
        </div>';
    }

    function getFooter(){
        echo '<div id="w3c">
        <a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
        <a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
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
