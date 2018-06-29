<?php
/**
 * Template name: User Messages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera
 */

if ( !is_user_logged_in() ) { 
	$login = '/';
	wp_redirect( $login ); exit;
}

global $current_user, 
$user_id, 
$wpdb;

$messagesTable = $wpdb->prefix . 'messages';
$pagepermalink = get_permalink($post->ID);

wp_get_current_user(); 
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$msgId    = $_GET['id'];
	$querystr = "SELECT $messagesTable.* FROM $messagesTable WHERE $messagesTable.message_id = $msgId";
	$record   = $wpdb->get_row($querystr, OBJECT);
	$messagePageId       = $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s LIMIT 1" , 'template-user-messages.php') );
	$sidebarMessagesLink = get_permalink($messagePageId);

	if ($record->to_id != $user_id) {
		$messagePageId       = $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s LIMIT 1" , 'template-user-messages.php') );
		$messagePageId       = '/';
		$sidebarMessagesLink = get_permalink($messagePageId);
		wp_redirect( $sidebarMessagesLink ); exit;
	}
}

if (isset($_POST['submitted']) && $record) {
	//Check to make sure that the subject field is not empty
	if(trim($_POST['subject']) === '') {
		$subjectError = __('Subject field is rquired.', 'fellah' );
		$hasError = true;
	} else {
		$subject = trim($_POST['subject']);
	}

	//Check to make sure comments were entered	
	if(trim($_POST['comments']) === '') {
		$commentError = __('Message field is rquired.', 'fellah' );
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		/********** New Message Code Start **********/
		$messageData['from_id']    = $user_id;
		$messageData['to_id']      = $record->from_id;
		$messageData['subject']    = $subject;
		$messageData['message']    = $comments;
		$messageData['created_at'] = $messageData['updated_at'] = date('Y-m-d H:i:s');
		$wpdb->insert( "{$wpdb->prefix}messages", $messageData, array('%d', '%d', '%s', '%s', '%s', '%s'));
		$messageId = $wpdb->insert_id;
		/********** New Message Code End **********/

		/********** Notification Email to User Start **********/
		newMessageNotificationToUser($messageData['to_id'], $current_user->display_name); // notify user about new reply
		/********** Notification Email to User End **********/

		$emailSent = true;
	}
}

get_header(); 
?>

<!-- page Heading --> 
<section id="messages" class="messages">
	<div class="container">

		<div class="row" >
			<div class="offset-md-2 col-md-8">
				<center><h3><?php echo $post->post_title; ?></h3></center>

				<?php if (isset($emailSent) && $emailSent == true) { ?>
					<div data-alert class="advert_alert advert_success" style="display: block; color: #d9534f;">
						<?php esc_html_e( 'Your Message have been sent!', 'fellah' ); ?>  
					</div>
				<?php } ?>

				<section class="messages_container">


					<div class="authorHead">
						<h4><?php echo $user_identity; ?></h4>
					</div><!-- End authorHead -->


					<div class="authorBio"> 
						<?php if (isset($_GET['id']) && $_GET['id'] > 0) { ?>
							<?php
							$recordId = $_GET['id'];
							$querystr = "SELECT $messagesTable.* FROM $messagesTable WHERE $messagesTable.message_id = $recordId";
							$record   = $wpdb->get_row($querystr, OBJECT);
							?>
							<?php if ($record) { ?>
								<div><strong><?php esc_html_e( 'Subject', 'fellah' ); ?>:</strong> <?php echo $record->subject; ?></div>
								<div><strong><?php esc_html_e( 'Message', 'fellah' ); ?>:</strong> <?php echo nl2br($record->message); ?></div>
								<br>
								<center><h3 style="color:#007e1d;"><?php _e('Répondre', 'fellah'); ?></center>
								<br>
								<div>
									<form name="contactForm" action="" id="contact-form" method="post" class="contactform" >
										<div class="row">						
											<?php if($hasError == true && $emailSent != true) {?>
												<div class="col-md-12">
													<span style="color: #d9534f;">
														<?php
														if(!empty($subjectError)){
															echo $subjectError."<br />";
														}
														if(!empty($commentError)){
															echo $commentError."<br />";
														}
														?>
													</span>
												</div>
											<?php }?> 
											<div class="col-md-12">
												<div class="inner-addon left-addon"> 
													<input type="text" placeholder="<?php esc_html_e( 'Subject', 'fellah' ); ?>" name="subject" id="subject" class="" value="<?php echo isset($subject) && $emailSent != true ? $subject : ''; ?>" />
												</div>
											</div><!--End Subjext-->
											<div class="col-md-12">
												<div class="inner-addon left-addon">
													<textarea placeholder="<?php esc_html_e( 'Write your message here...', 'fellah' ); ?>" name="comments" id="commentsText" cols="8" rows="5" ><?php echo isset($comments) && $emailSent != true ? $comments : ''; ?></textarea>
												</div>
											</div><!--End Your Message-->
											<div class="col-md-12">
												<div class="inner-addon left-addon">
													<input class="button round btnfull" name="submitted" type="submit" value="<?php esc_html_e( 'Send Message', 'fellah' ); ?>" class="input-submit"/>
												</div>
											</div>
										</div>
									</form>
								</div>
							<?php } ?>
						<?php } else { ?>
							<?php
							$querystr = "
							SELECT $messagesTable.* 
							FROM $messagesTable
							WHERE $messagesTable.to_id = $user_id
							ORDER BY $messagesTable.created_at DESC
							";

							$messages = $wpdb->get_results($querystr, OBJECT);
							?>
							<?php foreach ($messages as $message) : $current++; $current2++;?>
								<div class="usermessages" >
									<div class="message_description">
										<div class="sujet">
											<a target="_blank" class="my-message-title" href="<?php echo $pagepermalink ; ?>?id=<?php echo $message->message_id; ?>">
												<?php $theTitle = $message->subject; $theTitle = (strlen($theTitle) > 22) ? substr($theTitle,0,22).'...' : $theTitle; echo $theTitle; ?>
											</a>
										</div>
										<ul class="inline-list">
											<li>
												<?php $sender = get_userdata( $message->from_id ); ?>
												<span>
													<i class="fa fa-user"></i><?php echo $sender->display_name; ?>
												</span>
											</li>
											<li>
												<a href="<?php echo $pagepermalink ; ?>?id=<?php echo $message->message_id; ?>">
													<i class="fa fa-reply"></i><?php esc_html_e("View / Reply", 'fellah') ?>
												</a>
											</li>
											<li><span><?php echo date('d/m/Y', strtotime($message->created_at)); ?></span></li>
										</ul>
									</div><!-- End message-description -->
								</div><!-- End usermessages -->
							<?php  endforeach;	?>
						<?php } ?>
					</div><!-- End authorBio -->

				</section><!-- End messageSubmit boxPmessage-->
			</div><!-- End large-8 -->

			<!-- End Sidebar -->
		</div><!-- End ROW -->

	</div>
</section><!-- End advertisement -->
<?php get_footer(); ?>