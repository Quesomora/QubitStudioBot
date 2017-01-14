<?php
    $configJSON = json_decode(file_get_contents('./config.json'),true);
    $token = $configJSON['appAccessToken'];
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$token;

    $input = json_decode(file_get_contents('php://input'), true);
    //print_r($_REQUEST['hub_challenge']);
    $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
    $message = $input['entry'][0]['messaging'][0]['message']['text'];


    if(!empty($message)) {
        $answer = " world :)";
        if($message != "hello") {
            $answer = "Try again";
        }
        $response = array(
            'recipient' => array('id' => $sender),
            'message' => array('text' => $answer)
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
    }
?>