<!DOCTYPE html>
<html>
    <?php include "common.php"?>
    <?php
    getHead();
    echo '<body><div id="frame">';
    getHeader();

    echo '<div id="main">';
    
    if(isset($_GET["Link"])) {
        if(isset($_GET["Sort"])){
            $playlist = sortPlaylistBy(getPlaylistData($_GET["Link"]), $_GET["Sort"]);
            displayPlaylistTable($playlist);
        }
        else{
            $playlist = getPlaylistData($_GET["Link"]);
            displayPlaylistTable($playlist);
        }
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
        session_start();
        if(isset($_SESSION[$artist_link])){
            return $_SESSION[$artist_link];
        }

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

        $playlistData = new stdClass();
        $playlistData->image = new stdClass();
        $playlistData->image->url = $data->images[0]->url;
        $playlistData->artistLink = $artist_link;
        $playlistData->name = $data->name;
        $playlistData->tracks = new stdClass();
        $playlistData->tracks = $data->tracks;

        for($i = 1; $i <= sizeof($playlistData->tracks->items); $i++){
            $item = $playlistData->tracks->items[$i-1];
            $item->songNumber=$i;
            $item->trackData = new stdClass();
            $item->trackData = getTrackDetails($credentials, explode(":",$item->track->uri)[2]);
        }
        $_SESSION[$artist_link] = $playlistData;
        return $playlistData;

    }

    function displayPlaylistTable($playlistData){
        
        echo "<h1><img src=".$playlistData->image->url." width=100px></h1>";
        echo "<a href=".$playlistData->artistLink." target=_blank><h1>".$playlistData->name."</h1></a>";
        
        $tracks = $playlistData->tracks;
        $items = $tracks->items;

        
        echo "<table>";
        echo getPlaylistHeaders();

        for($i = 1; $i <= sizeof($playlistData->tracks->items); $i++){
            $item = $playlistData->tracks->items[$i-1];
            echo "<tr><td>".$item->songNumber."</td>";
            echo "<td id=name><a href=".$item->track->external_urls->spotify." target=_blank>".$item->track->name."</a></td>";
            echo "<td id=name><a href=".$item->track->artists[0]->external_urls->spotify." target=_blank>".$item->track->artists[0]->name."</a></td>";
            $trackData = $item->trackData;
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
        }
        echo "</table>";
    }

    function getPlaylistHeaders(){
        $header =  '<tr>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=songNumber'.'">#</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=songName'.'">Song Name</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=artistName'.'">Artist Name</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=danceability'.'">Danceability</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=energy'.'">Energy</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=loudness'.'">Loudness</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=acousticness'.'">Acousticness</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=instrumentalness'.'">Instrumentalness</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=liveness'.'">Liveness</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=valence'.'">Valence</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=tempo'.'">Tempo</a></th>';
        $header .= '<th><a href="'.explode("&", $_SERVER["REQUEST_URI"])[0].'&Sort=duration_ms'.'">Duration(ms)</a></th>';
        $header .= '</tr>';

        return $header;
    }

    function sortPlaylistBy($playlistData, $sortBy){
        usort($playlistData->tracks->items, $sortBy."Test");
        return $playlistData;
    }
    function songNumberTest($a,$b){
        return $a->songNumber - $b->songNumber;
    }
    function songNameTest($a, $b){
        return strcmp($a->track->name, $b->track->name);
    }
    function artistNameTest($a, $b){
        return strcasecmp($a->track->artists[0]->name, $b->track->artists[0]->name);
    }

    function danceabilityTest($a, $b){
        if($b->trackData->danceability == $a->trackData->danceability) return 0;
        else if($b->trackData->danceability > $a->trackData->danceability) return 1;
        else return -1;
    }
    function energyTest($a, $b){
        if($b->trackData->energy == $a->trackData->energy) return 0;
        else if($b->trackData->energy > $a->trackData->energy) return 1;
        else return -1;
    }
    function loudnessTest($a, $b){
        if($b->trackData->loudness == $a->trackData->loudness) return 0;
        else if($b->trackData->loudness > $a->trackData->loudness) return 1;
        else return -1;
    }
    function acousticnessTest($a, $b){
        if($b->trackData->acousticness == $a->trackData->acousticness) return 0;
        else if($b->trackData->acousticness > $a->trackData->acousticness) return 1;
        else return -1;
    }
    function instrumentalnessTest($a, $b){
        if($b->trackData->instrumentalness == $a->trackData->instrumentalness) return 0;
        else if($b->trackData->instrumentalness > $a->trackData->instrumentalness) return 1;
        else return -1;
    }
    function livenessTest($a, $b){
        if($b->trackData->liveness == $a->trackData->liveness) return 0;
        else if($b->trackData->liveness > $a->trackData->liveness) return 1;
        else return -1;
    }
    function valenceTest($a, $b){
        if($b->trackData->valence == $a->trackData->valence) return 0;
        else if($b->trackData->valence > $a->trackData->valence) return 1;
        else return -1;
    }
    function tempoTest($a, $b){
        if($b->trackData->tempo == $a->trackData->tempo) return 0;
        else if($b->trackData->tempo > $a->trackData->tempo) return 1;
        else return -1;
    }
    function duration_msTest($a, $b){
        if($b->trackData->duration_ms == $a->trackData->duration_ms) return 0;
        else if($b->trackData->duration_ms > $a->trackData->duration_ms) return 1;
        else return -1;
    }
    
    ?>
</html>
