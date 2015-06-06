<?php
remove_action('wp_head', 'wp_generator');
add_theme_support( 'post-thumbnails' );
/* Support pour un header personalise */
$args_header = array(
	'width'         => 225,
	'height'        => 100,
	'default-image' => get_template_directory_uri() . '/images/logo-b.png',
);
/*Changement de l'affichage des widget */
if ( function_exists('register_sidebar') )
register_sidebar(array(
	'before_widget' => '<section id="widget" class="sidebar-block">',
	'after_widget' => '</div></section>',
	'before_title' => '<h2>',
	'after_title' => '</h2><div class="sidebar-block-content">',
	));
add_theme_support( 'custom-header', $args_header );

if ( function_exists('register_sidebar') )
    register_sidebar();

// test si un page est un enfant,petit-enfant etc... d'une autre
function is_child($pageID) { 
	global $post; 
	if( is_page() && (($post->post_parent==$pageID) || ($post->ancestors && in_array( $pageID, $post->ancestors) )  )) {
               return true;
	} else { 
               return false; 
	}
}

/**
 * Register the sidebar area for language
 *
 */
function langues_widgets_init() {
	register_sidebar( array(
		'name' => 'Langues sidebar',
		'before_widget' => '<section id="widget" class="sidebar-block">',
		'after_widget' => '</div></section>',
		'before_title' => '<h2>',
		'after_title' => '</h2><div class="sidebar-block-content">',
	) );
}
add_action( 'widgets_init', 'langues_widgets_init' );

/**
 * Register the sidebar area for info panel
 *
 */
function info_widgets_init() {
	register_sidebar( array(
		'name' => 'Info Panel',
		'before_widget' => '<section id="widget" class="info-panel"><div class="info-panel-head"></div>',
		'after_widget' => '</div></section>',
		'before_title' => '<h2>',
		'after_title' => '</h2><div class="info-panel-content">',
	) );
}
add_action( 'widgets_init', 'info_widgets_init' );

/**
 * Register the sidebar area for the poster
 *
 */
function poster_widgets_init() {
	register_sidebar( array(
		'name' => 'Poster sidebar',
		'before_widget' => '<section id="widget" class="sidebar-block">',
		'after_widget' => '</div></section>',
		'before_title' => '<h2>',
		'after_title' => '</h2><div class="sidebar-block-content">',
	) );
}
add_action( 'widgets_init', 'poster_widgets_init' );
