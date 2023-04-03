<!DOCTYPE html>
<?php include "common.php";?>
<?php
    getHead();
    echo '<body>
    <div id="frame">';
    getHeader();
    echo '<div id="main">';
    

    $movies = GetMovieNameAndID($firstname, $lastname);
    if($movies){
        $firstname = $movies[0]["first_name"];
        $lastname = $movies[0]["last_name"];
        echo '<h1>Results for '.$firstname.' '.$lastname.'</h1>';
        echo "<table>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Title</th>";
        echo "<th>Year</th>";
        echo "</tr>";
        $count = 1;
        foreach($movies as $movie){
            if($firstname != $movie["first_name"]){
                $firstname = $movie["first_name"];
                $lastname = $movie["last_name"];
                echo "</table>";
                echo '<h1>Results for '.$firstname.' '.$lastname.'</h1>';
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
    else{
        echo "<h1>No data found for $firstname $lastname</h1>";
    }
    getForms();
    getFooter();
    echo '</div> <!-- end of #main div --></div> <!-- end of #frame div --></body>';
?>