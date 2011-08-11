function checkAuthStatus(){
	return FB._userStatus;
}

//Allows a user to call the subscribe to updates via facebook
function fbSubscribe() {
	//validate user has connected to the app and has also authorized the publish_stream updates	
	//if user has not connected to the application, process facebook login and prompt for publish_stream permissions
	FB.login(function(response){
		console.log(response);
		if(response.authResponse){				
			$.get("/app/hello",function(data,textStatus){
				console.log(textStatus);
				console.log(data);
			});				
		}else{
			//user cancelled login or did not fully authorize app -> do nothing
		}
	},{scope : 'publish_stream'});	
}


function emailSubscribe(){
	
}

$(document).ready(function(){
	//Query on page load facebook status for user
	FB.getLoginStatus();
});
