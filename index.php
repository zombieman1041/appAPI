<?php
	set_time_limit(0);
	ini_set('default_socket_timeout', 300);
	session_start();

	define('clientID','a9686c4e1a64437b80bf99fe0b3612ac');
	define('clientSecret','dde4e91a901043069d06a8b859ee2037');
	define('redirectURI','http://localhost/appAPI/index.php');
	define('ImageDirectory','pics/');

	if (isset($_GET['code'])){
		$code = ($_GET['code']);
		$url = 'https://api.instagram.com/oauth/access_token';
		$access_token_settings = array('client_id' => clientID,
			'client_secret' => clientSecret,
			'grant_type' => 'authorization_code',
			'redirect_uri' => redirectURI,
			'code' => $code
			);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
		$result = curl_exec($curl);
		curl_close($curl);

		$results = json_decode($result, true);
		echo $results['user']['username'];
	}
	else{
?>

<!DOCTYPE html>
<html>
	<head>
		<title>AppAPI</title>
	</head>
	<body>

		<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">Login</a>
	</body>
</html>
<?php
	}
?>

