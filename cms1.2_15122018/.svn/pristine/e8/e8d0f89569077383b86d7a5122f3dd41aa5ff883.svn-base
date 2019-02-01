<?php
    $client_id = "231090503373-7ftq27h2cfslnr8189iadb9e7f0dp7rn.apps.googleusercontent.com"; //your client id
    $client_secret = "NzPrRCJSyz7sD9dtdhawia13"; //your client secret
    //$redirect_uri = "http://localhost/blacktheme_3_12/admin-mycloud_now/Analytics_old.php";
    
    //$redirect_uri = "http://127.0.0.1:3000/auth/google_oauth2/callback";
    $scope = "https://www.googleapis.com/auth/plus.login"; //google scope to access
    $state = "profile"; //optional
    $access_type = "offline"; //optional - allows for retrieval of refresh_token for offline access

    if(isset($_POST['results'])){
        $_SESSION['accessToken'] = get_oauth2_token($_POST['results']);
    }

    //returns session token for calls to API using oauth 2.0
        function get_oauth2_token($code) {
        global $client_id;
        global $client_secret;
        global $redirect_uri;
        $oauth2token_url = "https://accounts.google.com/o/oauth2/token";
        $clienttoken_post = array(
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => $redirect_uri,
        "grant_type" => "authorization_code"
        );

        $curl = curl_init($oauth2token_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);
        error_log($json_response);
        curl_close($curl);   
        $authObj = json_decode($json_response);

        if (isset($authObj->refresh_token)){
            //refresh token only granted on first authorization for offline access
            //save to db for future use (db saving not included in example)
            global $refreshToken;
            $refreshToken = $authObj->refresh_token;
        }

        $accessToken = $authObj->access_token;
        return $accessToken;
    }
?>
