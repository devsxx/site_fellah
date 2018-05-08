<?php 
$call_to_action = get_field('call_to_action', get_the_ID());

if($call_to_action){  
	$post = $call_to_action;
	setup_postdata($post); 				
   $background_call_to_action = get_field('image_du_bandeau'); 
   $rel=""; 
   $blank=""; 
   if (get_field('lien_externe')){
      $lien = get_field('lien_externe');
      $rel="rel='nofollow'";
      $blank="target='blank'";
   }else{
      $lien = get_field('lien_interne');
   }
?>
   
<div class="bandeau">
    <div class="info">
        <div class="titre"><?php the_title(); ?></div>
        <div class="description"><?php the_field('description'); ?></div>
        <a href="<?php echo $lien; ?>" <?php echo $rel . $blank ?>> <?php the_field('titre_bouton'); ?>  </a>
    </div>
</div>



	<?php 
	wp_reset_postdata(); 
}
?>