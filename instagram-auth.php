<?php
require_once( 'includes/ini.php' );
require_once( 'credentials/instagram.php' );

$auth = new Instagram\Auth( $auth_config );

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
}
?>