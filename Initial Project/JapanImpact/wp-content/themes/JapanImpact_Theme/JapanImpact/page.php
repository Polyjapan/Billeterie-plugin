<!-- page pour une page -->
<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="content">
	<?php if (have_posts()) : ?>
		 <?php while (have_posts()) : the_post(); ?>
			<div class="post">
				<div class="post-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
