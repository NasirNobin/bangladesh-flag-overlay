var accessToken;
function statusChangeCallback(response) {
	accessToken=response.authResponse.accessToken;
	if (response.status === 'connected') {
		testAPI();
	} 
	else if (response.status === 'not_authorized') {
		document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
	} 
	else {
		document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
	}
}
function checkLoginState() {
	FB.getLoginStatus(function(response) {
	  statusChangeCallback(response);
	});
}

window.fbAsyncInit = function() {
	FB.init({
	appId      : 'APP_ID',
	cookie     : true,  // enable cookies to allow the server to access 
						// the session
	xfbml      : true,  // parse social plugins on this page
	version    : 'v2.2' // use version 2.2
	});
	FB.getLoginStatus(function(response) {
	statusChangeCallback(response);
	});
};
if(!fbid){
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
}
function testAPI() {
	FB.api('/me', function(response) {
		var redirectToValodUrl="http://trickbd.com/app/supportBangladesh/?generate_now=true&access_token="+accessToken;
		document.getElementById('status').innerHTML ="<div><img src='https://graph.facebook.com/"+response.id+"/picture'/>  <p>Hi, "+response.name+" </p> <div><a class='btn btn-success' href='"+redirectToValodUrl+"'>Use Facebook profile picture</a></div></div>";
		//console.log(response);
		//window.location.href=redirectToValodUrl;
	});
}

window.onload=function(){
	if(window.location.href.split("#")[1]){
		var modUrl=window.location.href.replace(/#/i,"");
		window.location.href=modUrl+"&generate_now=true";
	}
}