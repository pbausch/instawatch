<?php
require_once( 'includes/ini.php' );

//$tag = $instagram->getTag( 'corvallis' );
//$feed = $tag->getMedia();

$current_user = $instagram->getCurrentUser();
$feed = $current_user->getFeed();
?>
<html>
<body style="padding:0;margin:0;">
<?php
foreach($feed as $item){ // Decodes json (javascript) into an array
    $title = '';
    if($item->caption){
        $title = $item->caption->text . " ";
    }
	$username = $item->user->username;
	$fullname = $item->user->full_name;
    $src = $item->images->standard_resolution->url; 
	$link = $item->link;
	$title .= "by " . $username;
	print '<div style="float:left;width:612px;height:612px;background:url('.$src.');cursor:pointer;position:relative;" onclick="window.open(\''.$link. '\',\'_blank\');"><div style="position:absolute;left:0;bottom:0;background:black;color:white;width:602px;padding:5px;font-family:Helvetica;font-size:12px;opacity:0.7;">'.htmlspecialchars($title).'</div></div>';
	
	
	//print '<a href="' . $link . '" title="' . htmlspecialchars($title) . '" target="_blank"><img src="' . htmlspecialchars($src) . '" width="612" height="612" /></a>';
}

?>
</body>
</html>