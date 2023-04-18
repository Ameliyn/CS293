<!DOCTYPE html>
<html>
    <?php include "common.php"?>
    <?php
    getHead();
    echo '<body><div id="frame">';
    getHeader();

    echo '<div id="main">';
    
    getArtistData($firstname, $lastname);
    
    getButtons();
    echo '</div>';

    getFooter();
    echo '</div> <!-- end of #frame div --></body>';
    
    
    
    
    ?>
</html>
