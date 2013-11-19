<?php
require_once( 'includes/ini.php' );
$user= $instagram->getCurrentUser();
$max_id = NULL;
if (isset($_POST['maxid'])) {
	$max_id = $_POST['maxid'];
}
if ($max_id) {
	$param = array('max_id' => $max_id);
	$feed = $user->getFeed($param);
}
else {
	$feed = $user->getFeed();
}
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
	print '<div style="background:url('.$src.');" onclick="window.open(\''.$link. '\',\'_blank\');" class="image"><div class="caption">'.htmlspecialchars($title).'</div></div>';
}	
 	print '<input type="hidden" id="maxid" value="' . $feed->getNext() . '">';
?>