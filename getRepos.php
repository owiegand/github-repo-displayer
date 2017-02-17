<?php
include('userAccountInfo.php'); //Include Vars Containg User Account Info

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

$result = json_decode($content,true); //Array Containing all public repos owned by the user.

$AllRepoInfo = array();

foreach($result as $SingleRepo){
	$RepoName = $SingleRepo['name'];
	$RepoDes = $SingleRepo['description'];
	$RepoURL = $SingleRepo['html_url'];
	$RepoLangauge = $SingleRepo['language'];
	$RepoAPIURL = $SingleRepo['url'];
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

	$ReadMeText = base64_decode($DataArray["content"]);
	
	//Extract The Data From Readme file between two tags.
	$startsAt = strpos($ReadMeText , "[**GITHUBPHPPARSER**]") + strlen("[**GITHUBPHPPARSER**]");
	$endsAt = strrpos($ReadMeText, "[**GITHUBPHPPARSER**]");
	$result = substr($ReadMeText, $startsAt, $endsAt-$startsAt);
	
	$RepoOptions = json_decode($result,true);
	
	
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
	$AllRepoInfo = $RepoInfo;
}




print_r($AllRepoInfo);


?>