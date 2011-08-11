<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>K Swiss Lady Tubes</title>
	<link rel="stylesheet" href="css/reset.css" type="text/css"/>
	<link rel="stylesheet" href="css/helpers.css" type="text/css"/>	
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/swfobject.js"></script>
	<script type="text/javascript" src="js/kswiss.js"></script>
	<script type="text/javascript">
		var flashvars = {},params = {wmode:"transparent"},attributes = {};
		swfobject.embedSWF("swf/kswiss.swf", "flashPlaceholder", "550", "400", "9.0.0", "swf/expressInstall.swf",flashvars,params,attributes);
	</script>
</head>
<body>
	<!-- load facebook JS api -->
	<?php include('js/fbInit.php'); ?>
	<h1>Index page for canvas app</h1>
	<div>
		<script>
			$(function(){
				//link click events to mock buttons
				$('.fbSubscribe').click(function(e){
					e.preventDefault();
					return fbSubscribe;
				});
				$('.emailSubscribe').click(function(e){
					e.preventDefault();
					alert(emailSubscribe());
				});
				$('.twitterSubscribe').click(function(e){
					e.preventDefault();
					alert(twitterSubscribe());
				});
			});
		</script>
		<div id="flashPlaceholder"></div>
		
		<ul>
			<li><a href="#" class="fbSubscribe">Subscribe to updates via facebook</a></li>
			<li><a href="#" class="emailSubscribe">Subscribe to updates via email</a></li>
			<li><a href="#" class="twitterSubscribe">Subscribe to updates via twitter</a></li>
		</div>
	</div>	
</body>
</html>