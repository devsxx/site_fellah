<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       comenscene.com
 * @since      1.0.0
 *
 * @package    Fellah_Data_Importer
 * @subpackage Fellah_Data_Importer/admin/partials
 */
?>
<?php 


$allowed =  array('xml');



// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    
    $filename = $_FILES['fileToUpload']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!in_array($ext,$allowed) ) {
        echo "<h1>Ce n'est pas un fichier XML ( Rafraichir la page pour réessayer )</h1>";
        return;
    }
    if (isset($_FILES['fileToUpload']) && ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK)) {
       
        $xml = simplexml_load_file($_FILES['fileToUpload']['tmp_name']);  
        
        $terms = array();
        foreach ( $xml->xpath('/rss/channel/wp:term') as $term_arr ) {
			$t = $term_arr->children( 'wp', TRUE );

            if(((string) $t->term_taxonomy) != "blog_categories")
                continue;

            $my_cat = array(
                'cat_name' => (string) $t->term_name, 
                'category_description' => (string) $t->term_description, 
                'category_nicename' => (string) $t->term_slug, 
                'category_parent' => (string) $t->term_parent
            );

            // Create the category
            $my_cat_id = wp_insert_category($my_cat);
            
        }
        
        

        foreach ($xml->channel->item as $item) {

            $creator = $item->children('dc', TRUE);
            $children = $item->children('wp', TRUE);
            
           
            if(strip_tags($children->post_type) != "post" && strip_tags($children->post_type) != "blog_posts")
                continue;
              
            $content = $item->children('content', TRUE);
            $user = get_user_by('login',$creator);
            
            
            $userid = 28;
            if($user)
                $userid = $user->ID;
             

            if(empty($item->title))
                continue;

            $postType = null;
            if(strip_tags($children->post_type) == "post")
                $postType = 'advert';
            else{
                $postType = 'post';
            }
            
            $my_post = array(
                'post_type'     => $postType,
                'post_title'    => strip_tags($item->title),
                'post_content'  => $content,
                'post_status'   => $children->status,
                'post_author'   => $userid,
                'post_date'     => (string)$children->post_date,
            );
            
            // Insert the post into the database.
            $post_id = wp_insert_post( $my_post );

            
            // Get term and it's parent
            if(strip_tags($children->post_type) == "post"){
                $term = get_term_by('name', $item->category, 'advert_category');
                $arr = array();
                if($term){
                    array_push($arr, $term->term_id);
                    $termParent = get_term($term->parent, 'advert_category');
                    if($termParent)
                        @array_push($arr, $termParent->term_id);
                    
                    wp_set_object_terms( $post_id, $arr, 'advert_category' );
                }
            }else{
                foreach($item->category as $cate){
                    $cat = get_term_by('name', $cate, 'category');
                    if($cat)
                        wp_set_post_categories( $post_id, array( $cat->term_id ) );
                } 
            }

            if(strip_tags($children->post_type) == "blog_posts"){
                
                $nodes = $xml->xpath('//rss/channel/item/wp:post_parent[.='.$children->post_id.']/parent::*');
                
                if(!empty($nodes)){
                   crb_insert_attachment_from_url(strip_tags($nodes[0]->guid) ,$post_id, "blog_posts");
                    
                }
               
            }
            
            
            //Insert Post Meta
            foreach($children->postmeta as $postmeta){
                
                if($postmeta->meta_key == 'post_price')
                    update_post_meta( $post_id, 'adverts_price', (string)$postmeta->meta_value.PHP_EOL );

                if($postmeta->meta_key == 'post_phone')    
                    update_post_meta( $post_id, 'adverts_phone', (string)$postmeta->meta_value.PHP_EOL ); 

                if($postmeta->meta_key == 'post_location'){
                    $location = get_term_by('name', (string)$postmeta->meta_value.PHP_EOL, 'localisation');
                    if( $location)
                        wp_set_object_terms( $post_id, array( $location->term_id ), 'localisation' );
                }

                if($postmeta->meta_key == 'item-condition'){
                    $type_annonce = get_term_by('name', (string)$postmeta->meta_value.PHP_EOL, 'type_annonce');
                    if($type_annonce)
                        wp_set_object_terms( $post_id, array( $type_annonce->term_id ), 'type_annonce' );
                }

                //Insert Images
                if($postmeta->meta_key == '_thumbnail_id'){

                    $nodes = $xml->xpath('//rss/channel/item/wp:post_id[.='.(string)$postmeta->meta_value.PHP_EOL.']/parent::*');
                    crb_insert_attachment_from_url(strip_tags($nodes[0]->guid) ,$post_id);
                        
                }
                
            }
            if($user && strip_tags($children->post_type) == "post")
                update_post_meta( $post_id, 'adverts_email', $user->user_email ); 
        } 
        echo "<h2>L'import est fini</h2>";             
    }
}


?>
<h1>Importer les annonces</h1>
<form action="" method="post" enctype="multipart/form-data">
    Selectionner un fichier XML à importer :
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Importer" name="submit">
</form>


<?php 

function crb_insert_attachment_from_url($url, $post_id = null, $type = "") {

	if( !class_exists( 'WP_Http' ) )
		include_once( ABSPATH . WPINC . '/class-http.php' );

	$http = new WP_Http();
	$response = $http->request( $url );
	if( is_wp_error($response) || $response['response']['code'] != 200 ) {
		return false;
	}

	$upload = wp_upload_bits( basename($url), null, $response['body'] );
	if( !empty( $upload['error'] ) ) {
		return false;
	}

	$file_path = $upload['file'];
	$file_name = basename( $file_path );
	$file_type = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir = wp_upload_dir();

	$post_info = array(
		'guid'				=> $wp_upload_dir['url'] . '/' . $file_name, 
		'post_mime_type'	=> $file_type['type'],
		'post_title'		=> $attachment_title,
		'post_content'		=> '',
		'post_status'		=> 'inherit',
    );

	// Create the attachment
	$attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );

	// Include image.php
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

	// Assign metadata to attachment
    wp_update_attachment_metadata( $attach_id,  $attach_data );
    if($type == "blog_posts"){
        set_post_thumbnail($post_id, $attach_id);
    }
	return $attach_id;

}


?>