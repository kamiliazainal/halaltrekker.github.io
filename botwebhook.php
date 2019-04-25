<?php

$accessToken="EAAGncpq9Q6EBABgjHmnbyT4oYtXRdGitpUfcyXmhLLkEj7i0o0cved6CfGMRH4CADZClYz8rGJAsBXI2SR7wHrIGe6o4w7oTO7ZAau3KHzl9OMMp6lNkZBZBVjKuTIGTWgzQX13yYdiZBf998gyGhpEt0E6EPVXpOpBdx8CGoKQZDZD";

if(isset($_REQUEST['hub_challenge'])){
    $c=$_REQUEST['hub_challenge'];
    $v=$_REQUEST['hub_verify_token'];
}

if($v=="my_verify_token"){
    echo $c;
}

$input = json_decode(file_get_contents('php://input'),true);

$userID = $input['entry'][0]['messaging'][0]['sender']['id'];


$messagingArray = $input['entry'][0]['messaging'][0];
if (isset($messagingArray['postback'])){
    if($messagingArray['postback']['payload']=='first hand shake'){
        sendTextMessage("Hello there");
        die();
    }
}


if (isset($messagingArray['message'])){
    $sentMessage = $messagingArray['message']['text'];
    if(isset($messagingArray['message']['is_echo'])){
        die();
    }

    elseif( $sentMessage == 'test'){
        response ='{
            "recipient":{
            "id":"'.$userID.'"
          },
          "message":{
            "attachment":{
              "type":"template",
              "payload":{
                "template_type":"button",
                "text":"What do you want to do next?",
                "buttons":[
                  {
                    "type":"web_url",
                    "url":"https://www.messenger.com",
                    "title":"Visit Messenger"
                  },
                  {
                    ...
                  },
                  {...}
                ]
              }
            }
          }}';
          sendrawResponse($response);
    }
}

echo $userID." and ".$message;




function sendTextMessage($message){

global $accessToken;
global $userID;
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";

$jsonData="{
    'recipient':{
        'id': $userID
    },
    'message':{
        'text':'$message'
    }
}";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//if (!empty($input['entry'][0]['messaging'][0]['messaging'])){
    curl_exec($ch);

    $errors = curl_error($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    var_dump($errors);
    var_dump($response);

    curl_close($ch);
//}
}


function sendrawResponse($rawResponse){
    global $accessToken;
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";


$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $rawResponse);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//if (!empty($input['entry'][0]['messaging'][0]['messaging'])){
    curl_exec($ch);

    $errors = curl_error($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    var_dump($errors);
    var_dump($response);

    curl_close($ch);
//}
}
?>
