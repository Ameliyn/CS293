<!DOCTYPE html>
<?php include "common.php";?>
<?php
    getHead();
    echo '<body>
    <div id="frame">';
    getHeader();
    echo '<div id="main">';
    
    
    $firstname1 = "Kevin";
    $lastname1 = "Bacon";
    $firstname2 = $firstname;
    $lastname2 = $lastname;
    $movies = GetMoviesWith($firstname1, $lastname1, $firstname2, $lastname2);
    if($movies){
        if(gettype($movies[0]) == "string"){
            echo "<h1>".$movies[0]."</h1>";
        }
        else{
            $firstname2 = $movies[0]["first_name"];
            $lastname2 = $movies[0]["last_name"];
            echo "<h1>Results for ".$firstname1." ".$lastname1." and ".$firstname2." ".$lastname2."</h1>";
            echo "<table>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Title</th>";
            echo "<th>Year</th>";
            echo "</tr>";
            $count = 1;
            foreach($movies as $movie){
                if($firstname2 !== $movie["first_name"]){
                    $firstname2 = $movies[0]["first_name"];
                    $lastname2 = $movies[0]["last_name"];
                    echo "</table>";
                    echo "<h1>Results for ".$firstname1." ".$lastname1." and ".$firstname2." ".$lastname2."</h1>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Title</th>";
                    echo "<th>Year</th>";
                    echo "</tr>";
                    $count = 1;
                }
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