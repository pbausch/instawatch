<?php
//Set up some PHP stuff
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');

//require_once( 'includes/ini.php' );
require_once( 'includes/_autoloader.php' );
require_once( 'credentials/instagram.php' );
require_once( 'credentials/mysql.php' );
$auth = new Instagram\Auth( $auth_config );

//Get this db started
if (!$connection = @ mysqli_connect($mysql_server, $mysql_user, $mysql_pass))
   die("Can't connect to the database!");
if (!mysqli_select_db($connection, $mysql_db))
   die("Error " . mysqli_errno($connection) . " : " . mysqli_error($connection));

if (!isset($_GET['code'])) {
	$auth->authorize();
}
if (isset($_GET['code'])) {

	$token = $auth->getAccessToken( $_GET['code'] );
	$token_f = mysqli_real_escape_string($connection, $token);

	$insert = "INSERT INTO auth (token, service) VALUES ('$token_f',1) ON DUPLICATE KEY UPDATE token = VALUES(token)";
	if (!$add = @ mysqli_query ($connection, $insert)) {
   		logerror();
		die("Error " . mysqli_errno($connection) . " : " . mysqli_error($connection));
	}
	header( 'Location: index.php' ) ;
}
?>
