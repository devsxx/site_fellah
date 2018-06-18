<?php
/**
 * BuddyPress - Members Single Profile Edit
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_profile_edit_content' );

if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) : 
	
	$current_user = wp_get_current_user();
	
	?>

<div class="register_form register_page">
 
<div class="input_container">
	<i class="far fa-user"></i>
	<input type="text" placeholder="<?php _e("Prénom","fellah") ?>" name="prenom" id="prenom" value="<?php echo $current_user->user_firstname; ?>">                                
</div>

<div class="input_container">
	<i class="far fa-user"></i>
	<input type="text" placeholder="<?php _e("Nom","fellah") ?>" name="nom" id="nom" value="<?php echo $current_user->user_lastname; ?>">                                
</div> 

<div class="input_container">
	<i class="fas fa-phone"></i>
	<input type="text" placeholder="<?php _e("Phone","fellah") ?>" name="telephone" id="telephone" value="<?php echo @get_user_meta( $current_user->ID , 'telephone', true ); ?>">                                
</div>

<button name="update_compte" id="update_compte"><?php _e("Save Changes", "buddypress") ?></button>

<div class="advert_alert advert_danger"><?php  echo __("Update denied","fellah") ?></div>
<div class="advert_alert advert_success"><?php  echo __("Update successful","fellah") ?></div>

</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_profile_edit_content' );
