<?php
require_once( 'includes/ini.php' );
$current_user = $instagram->getCurrentUser();
?>
<html>
<head>
	<title>instawatch</title>
	<style>
		body {
			padding:0;
			margin:0;
			background-color:#333;
		}
		.image {
			position:relative;
			float:left;
			width:640px;
			height:640px;
			cursor:pointer;
			background-size:640px 640px !important;
		}
		.caption {
			position:absolute;
			left:0;
			bottom:0;
			background:black;
			color:white;
			opacity:0.7;
			width:630px;
			padding:5px;
			font-family:'latoregular', "Helvetica Neue", sans-serif;
			font-size:12px;
		}
		#instawatch {
			margin:auto;
		}
		@media screen and (max-width: 2560px) {
			#instawatch {width:1920px;}
		}
		@media screen and (max-width: 1919px) {
			#instawatch {width:1280px;}
		}
		@media screen and (max-width: 1279px) {
			#instawatch {width:640px;}
		}
		@media only screen and (min-device-width : 320px) and (max-device-width : 568px) { 
			.caption {font-size:24px;}
		}
	</style>
	<meta name="viewport" content="width=device-width" />
</head>
<body>
<div id="instawatch"></div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
	var maxid;
	var fired;
	$(function() {
		show_feed();
	});
	function show_feed() {
		fired = 1;
		$.post("show-feed.php",{maxid:maxid},function(data){
			var $response = $(data);
			maxid = $response.filter('#maxid').val();
			$("#instawatch").append($response);
			fired = 0;
		});
	}
	var scrollTimer = null;
	$(window).scroll(function () {
	    if (scrollTimer) {
	        clearTimeout(scrollTimer);
	    }
	    scrollTimer = setTimeout(handleScroll, 50);
	});
	function handleScroll() {
	    scrollTimer = null;
	    var bottom = $(document).height()-2500;
	    var ScrollTop = $(window).scrollTop();
	    if ((ScrollTop > bottom) && (fired == 0)) {
			fired = 1;
			show_feed(maxid);
	    }
	}
	</script>
</body>
</html>