function checkAuthStatus(){
	return FB._userStatus;
}

//Allows a user to call the subscribe to updates via facebook
function fbSubscribe() {
	//validate user has connected to the app and has also authorized the publish_stream updates.
	FB.login(function(response){
		if(response.authResponse){
			$.ajax({
				type: 'GET',
				url: '/app/fbSubscribe',
				async: true,
				success: function(data,textStatus,jqXHR){
					return data;
				}
			});
		}
	},{scope : 'publish_stream'});	
}


function emailSubscribe(){
	return 'emailSubscribeCallback';
}

function twitterSubscribe(){
	return 'twitterSubscribeCallback';
}

$(document).ready(function(){
	//Query on page load facebook status for user
	FB.getLoginStatus();
});
