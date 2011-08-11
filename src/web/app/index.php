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
		ORM::configure('mysql:host=localhost;dbname=MYDB');
		ORM::configure('username','MYUSER');
		ORM::configure('password','MYPASS');
		$facebook = new Facebook(array(
      		'appId'  => 'MY APP ID',
      		'secret' => 'MY SECRET ID',
    	));
	}

	
	//GET/POST route for hello method (POST method is required for facebook canvas)
	$app->post('/hello','hello');
	$app->get('/hello','hello');
	function hello(){
		global $app;
		global $facebook;
		$app->response()->header('Content-Type','text/plain');
		$app->render('hello.php');
	}
	
	//POST Route to add user to subscribers and flag them as subscribe via post updates
	$app->get('/fbSubscribe','fbSubscribe');
	function fbSubscribe(){
		global $app;
		global $facebook;
		$app->response()->header('Content-Type','application/json');		
		try{
			$facebookId = $facebook->getUser();
			if($facebookId){
				$user = $facebook->api('/me');
				$facebookId = $user['id'];
				$record = ORM::for_table('subscribers')->where('fbid',$facebookId)->find_one();
				if($record){
					//user has already authorized application at some point, need to verify if post to wall flag is enabled
					if(!$record->postWall){
						$record->postWall = 1;
						$record->save();
						echo json_encode(array('status' => 'OK','message' =>'User subscribed successfully'));
					}else{				
						//user has already subscribed for email updates
						echo json_encode(array('status' => 'ALREADY_SUBSCRIBED','message'=>'User has already subscribed to updates'));
					}
				}else{
					//user must be registered to receive updates
					$newRecord = ORM::for_table('subscribers')->create();
					$newRecord->fbid = $facebookId;
					$newRecord->postWall = 1;
					$newRecord->save();
					echo json_encode(array('status' => 'OK','message' =>'User subscribed successfully'));
				}
			}else{
				echo json_encode(array('status' => 'NO_FBID','message' => 'No FacebookId found, is user logged in?'));
			}
		}catch(FacebookApiException $e){
			$renderParams = array('fbException',$e);
			$app->render('facebookException',$renderParams);
		}
	}
	
	$app->get('/testORM','testORM');
	function testORM(){
		//First we validate if user has already been added to subscribers table
		$facebookId = '7278937811';
		echo "remove me";
	}
	
	//Custom 404 page
	$app->notFound('custom_not_found_callback');
	function custom_not_found_callback() {
    	global $app;
    	$app->render('404.php');
	}
	
	$app->run();
?>