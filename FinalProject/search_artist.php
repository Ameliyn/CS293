<!DOCTYPE html>
<html>
    <?php include "common.php"?>
    <?php
    getHead();
    echo '<body><div id="frame">';
    getHeader();

    echo '<div id="main">';
    if(isset($_GET["Link"]))
        getArtistData($_GET["Link"]);
    else{
        echo "<h1>No Link Provided.</h1>";
    }
    
    getButtons();
    echo '</div>';

    getFooter();
    echo '</div> <!-- end of #frame div --></body>';
    
    
    function getArtistData($Link){

        $credentials = connectToDatabase();
        $access_token = $credentials->access_token;
        $token_type = $credentials->token_type;
        $expires_in = $credentials->expires_in;
        $authorization = "Authorization: Bearer ".$access_token;

        $string_pieces = explode("artist", $Link);
        if(!isset($string_pieces[1])){
            echo "<h1> Invalid Artist Link </h1>";
            return;
        }
        $linkToArtist = "https://api.spotify.com/v1/artists".$string_pieces[1];
        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkToArtist);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnData = curl_exec($ch);

        $data = json_decode($returnData);
        #var_dump($data);
        $followers = json_decode(json_encode($data->followers));
        echo "<img src=".$data->images[0]->url." width=10%>";
        echo "<a href=".$Link." target=_blank><h1>".$data->name."</h1></a>";
        echo "Followers: ".$followers->total;
        return $data;

    }

    function getTestArtistData(){
        $data = connectToDatabase();
        $access_token = $data->access_token;
        $token_type = $data->token_type;
        $expires_in = $data->expires_in;


        $linkToArtist = "https://api.spotify.com/v1/artists/39EIRTZx1JjfeDLVdbj2ap?si=f137b8d066dc4443";
        $authorization = "Authorization: Bearer ".$access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkToArtist);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnData = curl_exec($ch);

        $data = json_decode($returnData);
        #var_dump($data);
        $followers = json_decode(json_encode($data->followers));
        echo "<h1>".$data->name."</h1>";
        echo "Followers: ".$followers->total;
        return $data;
    }
    
    ?>
</html>
