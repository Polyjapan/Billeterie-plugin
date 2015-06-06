<!-- page de résultat d'une recherche -->
<?php
get_header(); 
get_sidebar(); ?>
<div id="content" class="content" role="main">
	<?php if ( have_posts() ) : ?>
			<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="post">
						<h3 class="post-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="post-info">
					Posté le <?php echo qtrans_formatPostDateTime('%d.%m.%y'); ?> dans <?php the_category(', '); ?> par <?php the_author(); ?>.
				</p>
						<div class="post-content">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; ?>
				<?php shape_content_nav( 'nav-below' ); ?>
	<?php else : ?>
		<h2>Pas de résultat </h2>
	<?php endif; ?>
</div><!-- #content .content -->

<?php get_footer(); ?>
