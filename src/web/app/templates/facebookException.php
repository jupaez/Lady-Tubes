<?php
	echo json_encode(array(
		'status' => 'FB_EXCEPTION',
		'type' => $fbException->result[0]['error']['type'],
		'message' => $fbException->result[0]['error']['message']
	));
?>