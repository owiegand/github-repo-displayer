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
	$RepoInfo = array();

	$RepoInfo['name'] = $SingleRepo['name'];
	$RepoInfo['description'] = $SingleRepo['description'];
	$RepoInfo['html_url'] = $SingleRepo['html_url'];
	$RepoInfo['language'] = $SingleRepo['language'];
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

	//print_r($ReadMeText);

	//Extract The Data From Readme file between two tags. The user could have the data between multiple tags.
	preg_match_all("/<GITHUBPARSER>(.*?)<\/GITHUBPARSER>/s", $ReadMeText, $output_array);

	//If the user has multiple areas of options JSON decode each one.
	$RepoOptions = array();
	foreach($output_array[1] as $val){
		//Decode the JSON into an assoctative array.
  	$Options = json_decode($val,true);

		//Merge the array into one array containing all of the options.
		$RepoOptions = array_merge($RepoOptions, $Options);
  }

	//Options Coming From the Github API
	//Custom Options Coming From The Readme File
	foreach($RepoOptions as $key => $JSONElemet){
		$RepoInfo[$key] = $JSONElemet;
	}
	$AllRepoInfo[] = $RepoInfo;
	unset($RepoInfo);
}


?>
