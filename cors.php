<?php
header('Content-Type: application/json');
if (isset($_POST['replit_db_url']) && isset($_POST['method']) && isset($_POST['db_key'])) {
	$replit_db_url = $_POST['replit_db_url'];
	$method = $_POST['method'];
	$db_key = $_POST['db_key'];
	if (!empty($replit_db_url) && !empty($method) && !empty($db_key)) {
		switch ($method) {
			case 'get':
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $replit_db_url . '/' . $db_key);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				echo curl_exec($ch);
				curl_close($ch);
				break;
			case 'set':
				if (isset($_POST['db_value'])) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $replit_db_url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/x-www-form-urlencoded'
					));
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($db_key) .'=' . urlencode($_POST['db_value']));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					echo curl_exec($ch);
					curl_close($ch);
				} else {
					echo '{"code": 400, "message": "missing db_value"}';
					response_code(400);
				}
				break;
			case 'delete':
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $replit_db_url . '/' . $db_key);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				echo curl_exec($ch);
				curl_close($ch);
				break;
			case 'list':
				$ch = curl_init();
				$prefix = '';
				if (isset($_POST['db_value'])) {
					$prefix = $_POST['db_value'];
				}
				curl_setopt($ch, CURLOPT_URL, $replit_db_url . '?encode=true&prefix=' . urlencode($prefix));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				echo json_encode(explode("\n", curl_exec($ch)));
				curl_close($ch);
				break;
		}
	} else {
		echo '{"code": 400, "message": "missing replit_db_url, method or db_key"}';
		response_code(400);
	}
} else {
	echo '{"code": 400, "message": "missing replit_db_url, method or db_key"}';
	response_code(400);
}
?>
