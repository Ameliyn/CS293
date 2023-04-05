<!DOCTYPE html>
<head><title>MidtermPractice</title></head>
<body>
<?php 

    function show_twos($input){
        $temp = "<strong>".$input."</strong> =";
        while(!($input%2)){
            $temp .= " 2 * ";
            $input /= 2;
        }
        $temp .= $input."<br/>";
        return $temp;
    }

    echo show_twos(68);
    echo show_twos(18);
    echo show_twos(68);
    echo show_twos(120);
    echo show_twos(128);

?>
</body>
</html>