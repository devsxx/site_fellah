<?php

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


function getPostViews($postID){
   $count_key = 'post_views_count';
   $count = get_post_meta($postID, $count_key, true);
   if($count==''){
       return "1";
   }
   return $count;
}


function set_get_PostViews($postID) {
	if(!empty($_POST['ID_count'])){
		$postID = ($_POST['ID_count']);
	}
   setPostViews($postID);
   $counter_views = getPostViews($postID);
   $return .= '<div id="set_views_count" data-id="'. $postID .'">';
   
   if ( $counter_views < 2) { 
       $return .= sprintf( __('<div class="annonce-row"><span class="name">Vue </span><span>%1$s</span></div>', "fellah"),  $counter_views  ); 
   }else { 
       $return .= sprintf( __('<div class="annonce-row"><span class="name">Vues </span><span>%1$s</span></div>', "fellah"),  $counter_views  ); 
   }

	$return .= '</div>';
	echo $return;

	if(!empty($_POST['ID_count'])){
		die();
	}
}
 
add_action( 'wp_ajax_my_set_get_PostViews', 'set_get_PostViews' );
add_action( 'wp_ajax_nopriv_my_set_get_PostViews', 'set_get_PostViews' );
 