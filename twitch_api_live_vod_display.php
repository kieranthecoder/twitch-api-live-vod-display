<?php
    function apiLiveVodDisplay(){
        //Twitch User ID
        //This can be retrieved in many ways, including chrome extensions.
        //Value here for reference 
        $userID = 000000000;

        //Settings
        //Twitch API Link for livestream
        $liveCheckUrl = 'https://api.twitch.tv/kraken/streams/USER_ID_HERE';
        //Twitch API Link for VODs
        $getVideosUrl = 'https://api.twitch.tv/kraken/channels/USER_ID_HERE/videos';
        //Twitch API Client ID
        $client_id = "CLIENT_ID_HERE";
        //Twitch API Token
        $token = "TOKEN_HERE";
        //Twitch API Application Header
        $applicationHeader = "application/vnd.twitchtv.v5+json";

        //Check if the stream is currently live or not
        function checkLive($liveCheckUrl, $applicationHeader, $client_id, $token, $getVideosUrl){
            //CURL Request to the Twitch API
            $ch = curl_init($liveCheckUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: ' . $applicationHeader,
                'Client-ID: ' . $client_id,
                'Authorisation: Bearer ' . $token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            //Check if request has succeeded - looking for HTTP Code 200
            if ($info['http_code'] == 200) {
                //Request successful

                //Decode result
                $result = json_decode($result);

                //Check if the stream is currently live
                if(is_null($result->stream)){
                    //Stream is not live, we need to get the most recent video to display so we call the "getVideos" function
                    getVideos($getVideosUrl, $applicationHeader, $client_id, $token);
                } else {
                    //Stream is live, we can display the live stream
                    get_template_part( 'template_parts/twitch_api_live', 'part' );
                }
            } else {
                //No response from API, we display a Twitch player that the user can interact with
                get_template_part( 'template_parts/twitch_api_live', 'part' );
            }
        }

        //Get the ID of the most recent VOD
        function getVideos($getVideosUrl, $applicationHeader, $client_id, $token){
            $ch = curl_init($getVideosUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: ' . $applicationHeader,
                'Client-ID: ' . $client_id,
                'Authorisation: Bearer ' . $token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            //Check if request has succeeded - looking for HTTP Code 200
            if ($info['http_code'] == 200) {
                //Request successful

                //Decode result
                $result = json_decode($result);

                //Get most recent video from the data
                $mostRecent = $result->videos[0];

                //Seperate the ID into it's own variable
                $mostRecentIdObj = $mostRecent->_id;

                //Return the string value
                strval($mostRecentIdObj); 

                //Run a check to make sure we only have a number and pass it into a variable
                $mostRecentId = preg_replace("/[^0-9\s]/", "", $mostRecentIdObj);

                //Set ID in a global variable so template part can access it
                set_query_var('mostRecentId', $mostRecentId);

                //Call template part
                get_template_part( 'template_parts/twitch_api_vod', 'part' );

                //Unset global variable so no other part has access
                set_query_var('mostRecentId', false);
            } else {
                //No response from API, we display a Twitch player that the user can interact with
                get_template_part( 'template_parts/twitch_api_live', 'part' );
            }
        }
        //Run the check to see if the stream is currently live or not
        checkLive($liveCheckUrl, $applicationHeader, $client_id, $token, $getVideosUrl);
    }
?>