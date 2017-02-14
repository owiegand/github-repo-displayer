<?php

$data = array("bio" => "This is my bio" );



function curl($url, $data) {
	include('userAccountInfo.php');
	 $data_string = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,1);
    //curl_setopt($ch, CURLOPT_USERPWD, $GitHubUserName.":".$GithubPassword);
	 curl_setopt($ch, CURLOPT_USERPWD, $GitHubUserName.":".$GithubPassword);
	curl_setopt( $ch, CURLOPT_USERAGENT, $GitHubUserName);
	var_dump( $GitHubUserName);

    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);  
	 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
    $content = curl_exec($ch);
    curl_close($ch);
	var_dump($content);
    return( $content);
}

$result = json_decode(curl('https://api.github.com/users/owiegand/repos', $data),true);

var_dump($result);

?>