<!DOCTYPE html>
<?php include "common.php";?>
<?php
    getHead();
    echo '<body>
    <div id="frame">';
    getHeader();
    echo '<div id="main">';
    
    
    
    $movies = GetMoviesWith("Kevin", "Bacon", $firstname, $lastname);
    if($movies){
        if(gettype($movies[0]) == "string"){
            echo "<h1>".$movies[0]."</h1>";
        }
        else{
            echo "<h1>Results for Kevin Bacon and $firstname $lastname</h1>";
            echo "<table>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Title</th>";
            echo "<th>Year</th>";
            $count = 1;
            foreach($movies as $movie){
                echo "<tr>";
                echo "<td>".$count."</td>";
                echo "<td>".$movie["name"]."</td>";
                echo "<td>".$movie["year"]."</td>";
                echo "</tr>";
                $count++;
            }
            echo "</table>"; 
        }
           
    }
    else{
        echo "<h1>No movies found with Kevin Bacon and $firstname $lastname</h1>";
    }
    getForms();
    getFooter();
    echo '</div> <!-- end of #main div --></div> <!-- end of #frame div --></body>';
?>