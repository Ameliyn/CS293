<!DOCTYPE html>
<html>
    <?php include "common.php"?>
    <?php
    if(isset($_SESSION)){
        session_destroy();
        $_SESSION = array();    
    }
    
    session_start();
    getHead();
    echo '<body><div id="frame">';
    getHeader();

    echo '<div id="main">';
    echo "<h1> Enter a link to get started!</h1>";

    getButtons();
    echo '</div>';
    

    getFooter();
    echo '</div> <!-- end of #frame div --></body>';
    
    
    
    
    ?>
</html>
