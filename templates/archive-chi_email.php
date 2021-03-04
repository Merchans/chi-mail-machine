<?php get_header(); ?>
<?php wp_head(); ?>
<?php if ( have_posts() ) : ?>
	<div class="container">
		<div class="grid">
			<?php while ( have_posts() ) : the_post() ?>
				<?php
				$category    = get_the_category( get_the_ID() )[0]->term_id;
				$term_ID     = get_term_meta( $category, "category-backgound-id" )[0] ? get_term_meta( $category, "category-backgound-id" )[0] : "";
				$category_bg = wp_get_attachment_image_src( $term_ID, "small" )[0] ? wp_get_attachment_image_src( $term_ID, "small" )[0] : "";
				?>
				<section class="box-style-1 card module">

					<div class="wrapper"
						 style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.34), rgba(0, 0, 0, 0.34)),  url(<?php echo $category_bg; ?>) no-repeat center center; background-size: cover;">
						<div class="header">
							<div class="date">
								<span class="day"><?php the_date( 'd', ); ?></span>
								<span class="month"><?php echo get_the_date( 'M', ); ?></span>
								<span class="year"><?php echo get_the_date( 'Y', ); ?></span>
							</div>
							<ul class="menu-content">
								<li>
									<a class="fa fa-tag"></a> <?php the_category( ' ' ); ?>
								</li>
							</ul>
						</div>
						<div class="data">
							<div class="content">
								<span class="author">
									<?php _e( 'Author:', 'chi-mail-machine' ); ?>
									<?php the_author(); ?>
								</span>
								<h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
								<p class="text"><?php echo get_the_excerpt(); ?></p>
								<a href="<?php the_permalink(); ?>" class="button">
									<?php _e( 'Read more', 'chi-mail-machine' ); ?>
								</a>
							</div>
						</div>
					</div>
				</section>
			<?php endwhile ?>
		</div>
	</div>
<?php else : ?>
	<?php _e( 'There is no email yet :(', 'chi-mail-machine' ); ?>
<?php endif ?>
<?php get_footer(); ?>
<?php wp_footer(); ?>
