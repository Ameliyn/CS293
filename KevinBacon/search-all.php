<!DOCTYPE html>
<?php include "common.php";?>
<?php
    getHead();
    echo '<body>
    <div id="frame">';
    getHeader();
    echo '<div id="main">';
    
    echo "<h1>Results for $firstname $lastname</h1>";
    var_dump(GetActor($firstname, $lastname));
    getForms();
    getFooter();
    echo '</div> <!-- end of #main div --></div> <!-- end of #frame div --></body>';
    

    function DisplayAllMovies(){
        $db = ConnectToDatabase();
        try {
            $stmt = $db->prepare("select * from movies where");
            
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
    }
?>