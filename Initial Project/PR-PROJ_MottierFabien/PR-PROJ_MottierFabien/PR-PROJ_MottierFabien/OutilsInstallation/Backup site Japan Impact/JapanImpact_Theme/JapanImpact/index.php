<?php
	get_header();
	get_sidebar();
	query_posts('orderby=date&order=desc&post_status=publish&showposts=5');
	get_template_part('loop');
	get_footer();
	wp_reset_postdata();
?>
