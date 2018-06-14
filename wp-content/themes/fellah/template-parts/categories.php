<section class="mt-4"> 
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<div class="section_title">
					<div class="div"><?php _e('Catégories','fellah') ?></div>
					<a href="<?php the_permalink( 56 ) ?>" class="toutes_cats">
						<?php _e('Parcourir toutes les catégories', 'fellah'); ?>
						<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/arrow-right.png" alt="">
					</a>
				</div>
				<div class="section_sousTitle">
					<?php _e('Choisissez la catégorie correspondant à vos besoins.','fellah') ?>
				</div>
			</div>
		</div>

		<div class="catgories">
			<div class="row">
				<?php $advert_categories = get_terms("advert_category", array("orderby" => "date", "parent" => 0, 'hide_empty' => false,)); ?>
				
					<?php foreach($advert_categories as $key => $advert_category) :
						$image = get_field('image', $advert_category);
						$color = get_field('bg_color', $advert_category);
					?>
					<div class="col-md-6 col-lg-3">
						<a href="<?php echo get_term_link($advert_category); ?>">
						<div class="categorie">
							<img class="img_zoom" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
							<div class="cat_titre">
								<?php echo $advert_category->name; ?>
							</div>
							<div class="hover" style="background-color: <?php echo $color ?>;"></div>
						</div>
						</a>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
</section>
