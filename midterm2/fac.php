<!DOCTYPE html>
<head><title>Midterm 2 PHP Question 2</title></head>
<body>
<?php 
    
    function show_fac($input){
        $temp = "The factors of <strong>".$input."</strong> are";
        $factor = 1;
        $primeFlag = true;
        while($factor <= $input){
            if($input % $factor == 0){
                $temp .= " ".$factor;
                if($factor != 1 && $factor != $input) $primeFlag = false;

                if($factor+1 > $input){
                    $temp .= ".";
                }
                else{
                    $temp .= ",";
                }
            }
            $factor++;
        }

        if($primeFlag){
            $temp .= " It is prime.<br/>";
        }
        else{
            $temp .= " It is NOT prime.<br/>";
        }
        return $temp;
    }

    echo "<p>".show_fac($_GET["number"])."</p>";

?>
</body>
</html>