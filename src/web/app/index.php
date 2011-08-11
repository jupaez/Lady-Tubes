<?php
	require 'slim/Slim.php';
	require_once 'idiorm/idiorm.php';
	require 'fb/facebook.php';
	$facebook = NULL;
	//initialize Slim application	
	$app = new Slim(array(
		'log.enable' => true,
		'log.path' => './logs',
		'log.level' => 4,
		//switch value to 'production' when deploying to production
		'mode' => 'development'
	));
		
	//Development Application Setup
	$app->configureMode('development','devel');		
	function devel(){
		global $app;
		global $facebook;
		$app->config(array(
			'debug' => true			
		));
		ORM::configure('mysql:host=localhost;dbname=ladytubes');
		ORM::configure('username','ladytubes');
		ORM::configure('password','GKfm6b7jnHFxC23P');
		$facebook = new Facebook(array(
      		'appId'  => '107487976017979',
      		'secret' => 'b1c62e9355fcc08322fa9a88ef72fe77',
    	));
	}
	//Production Application Setup
	$app->configureMode('production','prod');
	function prod(){
		global $app;
		$app->config(array(
			'debug' => false
		));
		ORM::configure('mysql:host=localhost;dbname=ladytubes');
		ORM::configure('username','ladytubes');
		ORM::configure('password','GKfm6b7jnHFxC23P');
	}

	
	//GET/POST route for hello method (POST method is required for facebook canvas)
	$app->post('/hello','hello');
	$app->get('/hello','hello');
	function hello(){
		global $app;
		global $facebook;
		$app->response()->header('Content-Type','application/json');
		//try to get some info from the facebook user
		$user = $facebook->getUser();
		if($user){
			try{
				$user_profile = $facebook->api('/me');
				?>
					<pre>
						<?php var_dump($user_profile); ?>
					</pre>
				<?php
			}catch(FacebookApiException $e){
				?>
				<pre>
					<?php var_dump($e); ?>
				</pre>
				<?php
			}			
		}
		//$app->render('hello.php');
	}
	
	//Custom 404 page
	$app->notFound('custom_not_found_callback');
	function custom_not_found_callback() {
    	global $app;
    	$app->render('404.php');
	}
	
	$app->run();
?>