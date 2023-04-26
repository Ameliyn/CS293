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

    function getTrackDetails($credentials, $trackID){
        $access_token = $credentials->access_token;
        $token_type = $credentials->token_type;
        $expires_in = $credentials->expires_in;
        $authorization = "Authorization: Bearer ".$access_token;

        
        $linkToTrack = "https://api.spotify.com/v1/audio-features/".$trackID;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkToTrack);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnData = curl_exec($ch);

        $trackData = json_decode($returnData);
        if(isset($trackData->error)){
            $trackData = new stdClass();
            $trackData->danceability = 0;
            $trackData->energy = 0;
            $trackData->loudness = 0;
            $trackData->acousticness = 0;
            $trackData->instrumentalness = 0;
            $trackData->liveness = 0;
            $trackData->valence = 0;
            $trackData->tempo = 0;
            $trackData->duration_ms = 0;
        }
        return $trackData;
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

    function getButtons(){

        echo '
            <!-- form to search for a specific artist -->
            <form action="search_playlist.php" method="get">
                <fieldset>
                    <legend>Search by Playlist Link</legend>
                    <div>
                        <input name="Link" type="text" size="12" placeholder="https://..." autofocus="autofocus" /> 
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>';
            /*<!-- form to search for a specific artist -->
            <form action="search_artist.php" method="get">
                <fieldset>
                    <legend>Search by Artist Link</legend>
                    <div>
                        <input name="Link" type="text" size="12" placeholder="https://..." autofocus="autofocus" /> 
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>*/
    }

?>