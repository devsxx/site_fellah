
<section class="home_actualites">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section_title">
					<?php _e('Actualités', 'fellah'); ?>
					<div class="toutes_cats"></div>
				</div>
				<div class="section_sousTitle"></div>
			</div>
		</div>
		<div class="row"> 
			<?php 
				global $post; 
				$myposts = get_posts(  array('posts_per_page' => 2 ) );
				foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
					<div class="col-md-6 col-lg-4"> 
						<div class="actu">
							<a href="<?php the_permalink( ) ?>">
								<div class="bloc">
									<?php if(get_the_post_thumbnail( )): ?>
										<?php the_post_thumbnail( ); ?>
									<?php else: ?>	
										<img src="<?php bloginfo( 'template_url' ) ?>/img/img-actu.jpg" alt="">
									<?php endif; ?>	
									<div class="info"> 
										<div class="titre">
											<?php the_title( ); ?>
										</div>
										<div class="date">
											<i class="far fa-calendar-plus"></i>
											<?php echo get_the_date('j.m.Y'); ?>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div> 
				<?php endforeach; 
				wp_reset_postdata();?>

			<div class="col-md-6 col-lg-4">
				<div class="facebook_box">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.12&appId=1630338777079719&autoLogAppEvents=1';
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

					<div  class="fb-page" data-href="https://www.facebook.com/FellahAnnonces/" 
							data-width="350" data-height="190" data-small-header="true" 
							data-adapt-container-width="true" data-hide-cover="false"
							data-show-facepile="true">
							<blockquote cite="https://www.facebook.com/FellahAnnonces/" class="fb-xfbml-parse-ignore">
									<a href="https://www.facebook.com/FellahAnnonces/">Fellah.ma</a>
							</blockquote>
					</div>
					<br>
				</div>
			</div>
		</div> 
</section>
	  