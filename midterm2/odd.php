<!DOCTYPE html>
<head><title>Midterm 2 PHP Question 1</title></head>
<body>
<?php 
    if(is_null($_GET["number"])){
        echo "<p>Error: No Number Provided</p>";
    }
    elseif($_GET["number"]%2==0){
        echo "<p>even</p>";
    }
    else{
        echo "<p>odd</p>";
    }
?>
</body>
</html>