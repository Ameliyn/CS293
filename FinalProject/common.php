<!DOCTYPE html>

<?php
    $access_token = 0;
    $token_type = 0;
    $expires_in = 0;

    function connectToDatabase(){
        $clientID = "761f88dfea88482e867455d1be85bbe3";
        $clientSecret = "81a5bd9caae54dd28f5ccfe3cf5ea450";
        $clientCredentials = "client_credentials";
        $postFields = "grant_type=".$clientCredentials."&client_id=".$clientID."&client_secret=".$clientSecret;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        

        $returnData = curl_exec($ch);
        $data = json_decode($returnData);
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

    function getHead(){
        echo '<head>
		<title>Playlist Sorter</title>
		<meta charset="utf-8" />
		<link href="SpotifyIco.png" type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="final.css" type="text/css" rel="stylesheet" />
	    </head>';
    }
    function getHeader(){

        echo '<div id="banner">
        <a href="index.php"></a>
        Playlist Sorter!
        </div>';
    }

    function getMain(){
        echo '<div id="main">
        <h1>Not Yet Implemented</h1>
        </div> <!-- end of #main div -->';
    }
    function getFooter(){
        echo '<div id="footer">
        <img src="SpotifyIco.png" alt="banner logo"/> Powered by Spotify.
        </div>';
    }

?>