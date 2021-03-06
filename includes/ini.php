<?php
require_once( 'credentials/mysql.php' );
require_once( 'includes/_autoloader.php' );

//Start session if necessary
if (session_id() == "") {
    session_start();
}

//Set up some PHP stuff
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');

//MySQL error-logging function
function logerror() {
   error_log("MySQL Error: " . mysqli_errno() . " : " . mysqli_error());
}

//Get this db started
if (!$connection = @ mysqli_connect($mysql_server, $mysql_user, $mysql_pass))
   die("Can't connect to the database!");
if (!mysqli_select_db($connection, $mysql_db))
   die("Error " . mysqli_errno($connection) . " : " . mysqli_error($connection));

//Fire up Instagram
$query = "SELECT token FROM auth WHERE service = 1";
if (!$result = @ mysqli_query ($connection, $query))
   	logerror();
if (mysqli_num_rows($result) == 0) {
	die("No Instagram auth token! Please go through the auth process.");
} 
else {
	while ($token = mysqli_fetch_array($result)) {
		$instagram_access_token = $token['token'];
	}
}
$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $instagram_access_token );
?>