<!DOCTYPE html>
<html>
    <?php include "common.php"?>
    <?php
    getHead();
    echo '<body><div id="frame">';
    getHeader();

    echo '<div id="main">';
    
    if(isset($_GET["Link"])) {
        getPlaylistData($_GET["Link"]);
    }
    else {
        getTestPlaylistData();
    }

    getButtons();
    echo '</div>';

    getFooter();
    echo '</div> <!-- end of #frame div --></body>';
    
    
    
    function getTestPlaylistData(){
        $data = connectToDatabase();
        $access_token = $data->access_token;
        $token_type = $data->token_type;
        $expires_in = $data->expires_in;


        $linkToArtist = "https://api.spotify.com/v1/playlists/5BBewul3kwrAVabUKpxQfm?si=38d16d63c34f4cad";
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
        echo "Followers: ".$followers->total."</br>";
        
        $tracks = json_decode(json_encode($data->tracks));
        $items = json_decode(json_encode($tracks->items));
        foreach($items as $item){
            echo "Song Name: ".$item->track->name."</br>";
        }
    }

    function getPlaylistData($artist_link){
        $credentials = connectToDatabase();
        $access_token = $credentials->access_token;
        $token_type = $credentials->token_type;
        $expires_in = $credentials->expires_in;

        $string_pieces = explode("playlist", $artist_link);
        if(!isset($string_pieces[1])){
            echo "<h1> Invalid Playlist Link </h1>";
            return;
        }
        $linkToArtist = "https://api.spotify.com/v1/playlists".$string_pieces[1];
        $authorization = "Authorization: Bearer ".$access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkToArtist);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnData = curl_exec($ch);

        $data = json_decode($returnData);

        if(isset($data->error)){
            echo "Error ".$data->error->status.": ".$data->error->message;
            return;
        }
        echo "<h1><img src=".$data->images[0]->url." width=100px></h1>";
        echo "<a href=".$artist_link." target=_blank><h1>".$data->name."</h1></a>";
        
        $tracks = json_decode(json_encode($data->tracks));
        $items = json_decode(json_encode($tracks->items));

        echo "<table><tr>";
        echo "<th>#</th><th id=name>Song Name</th><th id=name>Artist Name</th><th>Danceability</th><th>Energy</th><th>Loudness</th><th>Acousticness</th>";
        echo "<th>Instrumentalness</th><th>Liveness</th><th>Valence</th><th>Tempo</th><th>Duration</th></tr>";
        $songNumber = 1;
        foreach($items as $item){
            echo "<tr><td>".$songNumber."</td>";
            echo "<td id=name><a href=".$item->track->external_urls->spotify." target=_blank>".$item->track->name."</a></td>";
            echo "<td id=name><a href=".$item->track->artists[0]->external_urls->spotify." target=_blank>".$item->track->artists[0]->name."</a></td>";
            $trackData = getTrackDetails($credentials, explode(":",$item->track->uri)[2]);
            echo "<td>".$trackData->danceability."</td>";
            echo "<td>".$trackData->energy."</td>";
            echo "<td>".$trackData->loudness."</td>";
            echo "<td>".$trackData->acousticness."</td>";
            echo "<td>".$trackData->instrumentalness."</td>";
            echo "<td>".$trackData->liveness."</td>";
            echo "<td>".$trackData->valence."</td>";
            echo "<td>".$trackData->tempo."</td>";
            echo "<td>".$trackData->duration_ms."</td>";
            echo "</tr>";
            $songNumber++;
        }
        echo "</table>";
    }
    ?>
</html>
