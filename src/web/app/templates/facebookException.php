<?php
	$result = $fbException->getResult();
	echo json_encode(array(
		'status' => 'FB_EXCEPTION',
		'type' => $result['error']['type'],
		'message' => $result['error']['message']
	));
?>