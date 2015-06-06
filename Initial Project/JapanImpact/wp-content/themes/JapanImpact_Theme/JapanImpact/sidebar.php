<div class="sidebar">
	<?php if (is_home()) : /*si on est dans la page d'accueil */ ?>
		<?php if ( dynamic_sidebar('sidebar-5') ) : else : endif; ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
   			 <!-- Partie qui s'affichera uniquement si les Widgets ne sont pas disponibles -->
    		<!-- Mais qui affichera les Widgets si ils sont disponibles -->
  		<?php endif; ?>
	<?php elseif ($post->post_parent != 0) : /* si la page a un parent */ ?>
		<section id="list" class="sidebar-block">
			<h2>Navigation</h2>
			<?php
				$ancestors=get_post_ancestors($post->ID); // récupère la liste des ancêtres
				$root=count($ancestors)-1;
				$parent = $ancestors[$root]; // extrait l'ID du parent le plus élévé
			wp_list_pages(array('child_of' => $parent,'title_li' => '')); /* on affiche le menu de navigation avec le parent le plus élévé */ ?>
		</section>
	<?php elseif (count(get_pages('child_of='.$post->ID)) != 0) : /* si la page a des enfants ( statique ) */ ?>
		<section id="list" class="sidebar-block">
			<h2>Navigation</h2>
			<?php wp_list_pages(array('child_of' => $post->ID,'title_li' => '')); ?>
		</section>
	<?php else : /* dans les autres cas, on est dans une page dynamique */ ?>
		<!-- <section id="archive" class="sidebar-block" >
			<h2>Archives</h2>
			<section id="list">
				<?php wp_get_archives('type=monthly'); ?>
			</section>
		</section> -->
	<?php endif; ?>
	<?php if ( dynamic_sidebar('sidebar-3') ) : else : endif; ?>
  <!-- Formulaire de recherche -->
  <?php get_search_form(); ?>
  
</div>
