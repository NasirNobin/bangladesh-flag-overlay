<?php
if(!defined('ABSPATH')){ header("Location: index.php"); exit(); }

$accessToken=@$_GET['access_token'];

$authUrl="http://www.facebook.com/dialog/oauth?type=user_agent&scope=public_profile&client_id=APP_ID&redirect_uri=http://trickbd.com/app/supportBangladesh/";

function processToken($accessToken){
	global $fb;
	global $longLivedAccessToken;

	/* including fbsdk  */

	include("fbsdk/autoload.php");

	$fb = new Facebook\Facebook([
		'app_id' => 'APP_ID',
		'app_secret' => 'APP_SECRET',
		'default_graph_version' => 'v2.2',
	]);

	try{
		$oAuth2Client = $fb->getOAuth2Client();
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		$fb->setDefaultAccessToken($longLivedAccessToken); 
		setcookie('trickbd_app_token',$longLivedAccessToken,time()+60*60*24*30*2);
	} 
	catch(Facebook\Exceptions\FacebookSDKException $e) {
		$txt="Invalid Access token";
	}
}

function processImage($fbid,$name){
	global $txt;
	global $script;
	global $longLivedAccessToken;
	global $user_name;
	global $user_id;
	$generate_now=isset($_GET['generate_now']) ? $_GET['generate_now'] : false ;

	if(!empty($fbid) && $fbid != 'undefined'){
		$script= send_to_header($fbid,$name,$longLivedAccessToken);
		$user_name=$name;
		$user_id=$fbid;

		$url='http://graph.facebook.com/'.$fbid.'/picture?height=10000';
		if($generate_now == true){
			if(edit($url,$fbid)){
				header("Location: view.php?id=".$fbid."&ref=new");
			}
			else{
				$txt="Failed to edit";
			}
		}
	}
	else{
		header("Location: index.php");
	}
}

if(!empty($accessToken)){
	processToken($accessToken);
	try{
		$response = $fb->get('/me');
		$user=$response->getDecodedBody();
		processImage($user['id'],$user['name']);
		//exit();
	} 
	catch(Facebook\Exceptions\FacebookResponseException $e) { } 
	catch(Facebook\Exceptions\FacebookSDKException $e) { }
}
elseif(!empty($_COOKIE['trickbd_app_token'])){
	processToken($_COOKIE['trickbd_app_token']);
	try{
		$response = $fb->get('/me');
		$user=$response->getDecodedBody();
		processImage($user['id'],$user['name']);
		//exit();
	} 
	catch(Facebook\Exceptions\FacebookResponseException $e) { } 
	catch(Facebook\Exceptions\FacebookSDKException $e) { }
}

?>