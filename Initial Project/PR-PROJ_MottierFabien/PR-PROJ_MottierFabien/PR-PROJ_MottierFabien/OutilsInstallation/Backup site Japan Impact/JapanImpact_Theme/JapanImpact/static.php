<?php
/*
Template Name: Statique
*/
?>
<?php
	get_header();
	//get_sidebar();
?>
	<p>
		<?php if (have_posts()) : while (have_posts()) : the_post();?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>
	</p>
<?php
	get_footer();
?>
