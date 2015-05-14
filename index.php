<?php
	set_time_limit(0);
	ini_set('default_socket_timeout', 300);
	session_start();

	define('clientID','a9686c4e1a64437b80bf99fe0b3612ac');
	define('clientSecret','dde4e91a901043069d06a8b859ee2037');
	define('redirectURI','http://localhost/appAPI/index.php');
	define('ImageDirectory','pics/');


function connectToInstagram($url){
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url, 
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,  
		));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}


function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q='.$userName.'&client_id=' .clientID;
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);

	//before function printImages
	//echo $results['data'][0]['id'];
	return $results['data'][0]['id'];
	//require_once(__DIR__ . "/../view/navigation.php");
}
//print out images onto screen

function printImages($userID){
	//url of information we are requesting
	$url = 'https://api.instagram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=5';
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//parsing through each picture
	foreach ($results['data'] as $items) {
		$image_url = $items['images']['low_resolution']['url'];
		echo '<img src=" ' . $image_url . ' "/><br/>';
		savePicture($image_url);
		
	}
	require_once(__DIR__ . "/../view/navigation.php");
}

	function savePicture($image_url){
		echo $image_url . '<br>';
		$filename = basename($image_url);
		echo $filename . '<br>';

		$destination = ImageDirectory . $filename;
		file_put_contents($destination, file_get_contents($image_url));
	}

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

		$userName = $results['user']['username'];

		//echo '<pre>';
		//print_r($userName);


		$userID = getUserID($userName);
		printImages($userID);
	}
	else{
?>

<!DOCTYPE html>
<html>
	<head>
		<title>AppAPI</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<!-- google fonts -->
		<link href='http://fonts.googleapis.com/css?family=Shojumaru' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<!-- mediaquery -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body class="background2">
	<div class="container">
		<div class="center">
			<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">Login</a>
		</div>
	</div>
		
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>
<?php
	}
?>

