<?php
include('userAccountInfo.php'); //Add Vars Containg User Account Info

//$data_string = json_encode($data);
$url = 'https://api.github.com/users/'.$GitHubUserName.'/repos'; //API URL to get a users repos. This currently only returns public repos.

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
//Finds The Start of the Github Parser Info
/*TODO: Make Sure When Stop at the Closing Tag
Use This Code Instead
$startsAt = strpos($out, "{FINDME}") + strlen("{FINDME}");
$endsAt = strpos($out, "{/FINDME}", $startsAt);
$result = substr($out, $startsAt, $endsAt - $startsAt);
*/
$ReadMeText = trim(preg_split('/\[\*\*GITHUBPHPPARSER\*\*\]/', base64_decode($DataArray["content"]))[1]);
$ReadMeText = preg_replace('/-->/', '', $ReadMeText);
$RepoOptions = json_decode($ReadMeText,true);


$RepoInfo = array();
//Options Coming From the Github API
$RepoInfo['name'] = $RepoName;
$RepoInfo['description'] = $RepoDes;
$RepoInfo['html_url'] = $RepoURL;
$RepoInfo['language'] = $RepoLangauge;

//Custom Options Coming From The Readme File
if($RepoOptions['AltShortDesc'] != NULL){
	$RepoInfo['AltShortDesc'] = $RepoOptions['AltShortDesc'];
}
if($RepoOptions['LongDesc'] != NULL){
	$RepoInfo['LongDesc'] = $RepoOptions['LongDesc'];
}
if($RepoOptions['ImgURL'] != NULL){
	$RepoInfo['ImgURL'] = $RepoOptions['ImgURL'];
}
if($RepoOptions['ThumbailImgURL'] != NULL){
	$RepoInfo['ThumbailImgURL'] = $RepoOptions['ThumbailImgURL'];
}
if($RepoOptions['Category'] != NULL){
	$RepoInfo['Category'] = $RepoOptions['Category'];
}

print_r($RepoInfo);


?>