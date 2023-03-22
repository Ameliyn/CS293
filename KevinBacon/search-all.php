<!DOCTYPE html>
<?php include "common.php";?>
<?php
    getHead();
    echo '<body>
    <div id="frame">';
    getHeader();
    echo '<div id="main">';
    
    echo "<h1>Results for $firstname $lastname</h1>";
    $movies = GetMovieNameAndID($firstname, $lastname);
    if($movies){
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
    else{
        echo "<p>No data found for $firstname $lastname</p>";
    }
    getForms();
    getFooter();
    echo '</div> <!-- end of #main div --></div> <!-- end of #frame div --></body>';
?>