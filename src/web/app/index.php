<?php
	require 'slim/Slim.php';
	require_once './idiorm/idiorm.php';	
	//initialize Slim application	
	$app = new Slim(array(
		'log.enable' => true,
		'log.path' => './logs',
		'log.level' => 4,
		//switch value to 'production' when deploying to production
		'mode' => 'development'
	));
		
	//Development Setup
	$app->configureMode('development','devel');		
	function devel(){
		global $app;
		$app->config(array(
			'debug' => true			
		));
		ORM::configure('mysql:host=localhost;dbname=ladytubes');
		ORM::configure('username','ladytubes');
		ORM::configure('password','GKfm6b7jnHFxC23P');
	}
	//Production Setup
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
		$records = ORM::for_table('subscribers')->find_many();
		$viewParams = array('records' => $records);
		$app->render('hello.php',$viewParams);
	}
	
	//Custom 404 page
	$app->notFound('custom_not_found_callback');
	function custom_not_found_callback() {
    	global $app;
    	$app->render('404.php');
	}
	
	$app->run();
?>