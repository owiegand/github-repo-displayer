<?php
include('userAccountInfo.php');



//$data_string = json_encode($data);
$url = 'https://api.github.com/users/'.$GitHubUserName.'/repos';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  

curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,1);
curl_setopt($ch, CURLOPT_USERPWD, $GitHubUserName.":".$GithubPassword);
curl_setopt( $ch, CURLOPT_USERAGENT, $GitHubUserName);

curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);  
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
$content = curl_exec($ch);
curl_close($ch);

$result = json_decode($content,true);

$RepoName = $result[0]['name'];
$RepoDes = $result[0]['description'];
$RepoURL = $result[0]['html_url'];
$RepoLangauge = $result[0]['language'];
$RepoAPIURL = $result[0]['url'];
$ReadMeURL = $RepoAPIURL.'/readme';

$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $ReadMeURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt( $ch, CURLOPT_USERAGENT, $GitHubUserName);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
$data = curl_exec($ch);
curl_close($ch);

$DataArray = json_decode($data,true);
$ReadMeText = trim(preg_split('/\[\*\*GITHUBPHPPARSER\*\*\]/', base64_decode($DataArray["content"]))[1]);
$ReadMeText = preg_replace('/-->/', '', $ReadMeText);
$RepoOptions = json_decode($ReadMeText,true);
var_dump($RepoOptions);


?>