<DOCTYPE html>
<html>
	<head <?php language_attributes(); ?>>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type ="image/x-icon" />
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type ="image/x-icon"/>
    	<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); echo '?ver=' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" type="text/css" media="screen, projection" />
		<?php wp_head(); ?>
<!-- Yopla start -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '1518135558475578']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1518135558475578&amp;ev=PixelInitialized" /></noscript>
<!-- Yopla end -->

	</head>
	<body>
		<header class="site-header">
		<?php if ( dynamic_sidebar('sidebar-4') ) : else : endif; ?>
			<!-- image du header -->
			<?php if ( get_header_image() ) : ?>
				<div id="site-header">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
					</a>
				</div>
			<?php endif; ?>
			
		</header>
		<nav id="main-navigation">
			<ul>
				<li class="page_home">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						Accueil
					</a>
				</li>
			</ul>
			<!-- menu navigation principal -->
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'depth' => '1' ) ); /*utiliser depth pour choisir le niveau des pages */?>
		</nav>
		<div class="page-info">
			<?php if (is_home()) : /*si on est dans la page d'accueil */ ?>
				<h1>Accueil</h1>
			<?php elseif ($post->post_parent == 0) : ?>
				<h1><?php wp_title( ''); ?></h1>
			<?php endif; ?>
			<hr class="content-separator">
		</div>
		