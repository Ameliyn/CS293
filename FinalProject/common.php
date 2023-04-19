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
        return $trackData;
    }

    function getArtistData($firstname, $lastname){

        $data = connectToDatabase();
        $access_token = $data->access_token;
        $token_type = $data->token_type;
        $expires_in = $data->expires_in;

        $artistID = getArtistId($firstname, $lastname, $data);

        $linkToArtist = "https://api.spotify.com/v1/artists/".$artistID;
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

    function getArtistId($firstname, $lastname, $data){
        $access_token = $data->access_token;
        $token_type = $data->token_type;
        $expires_in = $data->expires_in;
        $artist = "%20artist:".$firstname."+".$lastname;
        $linkToQuery = "https://api.spotify.com/v1/search?query=".$artist."type=artist";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkToQuery);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnData = curl_exec($ch);

        $data = json_decode($returnData);
        
        return $data->id;
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
            <form action="search_artist.php" method="get">
                <fieldset>
                    <legend>Search by Artist Link</legend>
                    <div>
                        <input name="Link" type="text" size="12" placeholder="https://..." autofocus="autofocus" /> 
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>
            
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
        /*
        echo '
            <!-- form to search for a specific artist -->
            <form action="search_artist.php" method="get">
                <fieldset>
                    <legend>Search Artist</legend>
                    <div>
                        <input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
                        <input name="lastname" type="text" size="12" placeholder="last name" /> 
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>

            <!-- form to search for a specific albumn-->
            <form action="search_albumn.php" method="get">
                <fieldset>
                    <legend>Tracks in an albumn</legend>
                    <div>
                        <input name="albumnname" type="text" size="12" placeholder="first name" />  
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>

            <!-- form to search for a specific playlist-->
            <form action="search_playlist.php" method="get">
                <fieldset>
                    <legend>Tracks in a playlist</legend>
                    <div>
                        <input name="playlistname" type="text" size="12" placeholder="first name" />  
                        <input type="submit" value="go" />
                    </div>
                </fieldset>
            </form>
            ';
            */
    }

?>