<section id="search" class="sidebar-block" >
	<h2> <label for="search-query">Recherche</label> </h2>
	<div class="sidebar-block-content">
		<form method="get" id="search-form" action="<?php bloginfo('url'); ?>/">
		  <input type="text" value="<?php the_search_query(); ?>" name="s" id="search-query"> </input>
		  <button type="submit" id="search-submit"> 
		  	<img src="<?php echo get_bloginfo('template_directory'); ?>/images/search.gif" alt="Search" width="19" height="19">
		  </button>
		</form>
	</div>
</section>
