<?php
/*
	Template Name: Nouvelles
*/
?>
<?php
	get_header();
	get_sidebar();
	query_posts('orderby=date&order=desc&post_status=publish');
	get_template_part('loop');
	wp_reset_postdata();
	get_footer();
?>
