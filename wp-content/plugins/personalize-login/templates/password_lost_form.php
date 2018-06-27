<div id="password-lost-form" class="widecolumn">
	<div class="container">
		<div class="row">
			<div class="offset-md-3 col-md-6">
				<?php if ( $attributes['show_title'] ) : ?>
					<h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>
				<?php endif; ?>

				<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
					<?php foreach ( $attributes['errors'] as $error ) : ?>
						<p>
							<?php echo $error; ?>
						</p>
					<?php endforeach; ?>
				<?php endif; ?>

				<p>
					<?php
					_e(
						"Enter your email address and we'll send you a link you can use to pick a new password.",
						'personalize_login'
					);
					?>
				</p>

				<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
					<div class="form-row">
						<label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
						<input type="text" name="user_login" id="user_login">
					</div>

					<div class="lostpassword-submit">
						<input type="submit" name="submit" class="lostpassword-button"
						value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>