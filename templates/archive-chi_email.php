<?php get_header(); ?>
<?php wp_head(); ?>
<?php if ( have_posts() ) : ?>
	<div class="container">
		<?php while ( have_posts() ) : the_post() ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		<?php endwhile ?>
	</div>
<?php else : ?>
	<?php _e( 'There is no email yet :(', 'chi-mail-machine' ); ?>
<?php endif ?>
<?php get_footer(); ?>
<?php wp_footer(); ?>
