<?php
	function BaTi_Admin_HomePage()
	{
		// Récupératin du chemin du pdf
		$CheminDuPlugin = plugins_url('BasicTicketting/Manuel.pdf');

		echo '
			<div class="BaTi_Admin_div">
				<h1>Présentation</h1>
				<p>Ceci est un login qui permet de gérer simplement une petite billeterie en ligne. Il permet créer des événements, de leur attribuer des types de billet. Il gère un système de logique simple. L\'utilisateur peut ainsi s\'incrire choisir les billets qu\'il souhaite acheter et voir la liste de ses achats. Le plugin crée les billets au format PDF avec un code barre et l\'envoie par mail à l\'utilisateur.</p>
			</div>
			<br />
			<div class="BaTi_Admin_div">
				<h1>Utilisation</h1>
				<p>Il faut commencer par définir le nombre d\'événements dans la partie de gestion de la base de données. Il faut ensuite ajouter le shortcode [BaTi_Event*] (* étant le numéro d\événement) dans la page où vous voulez intégrer le formulaire de billeterie de l\'événement. Un sous-menu est automatiquement créé pour gérer les événements.</p>
			</div>
			<br />
			<a href="'.$CheminDuPlugin.'">Manuel</a>
		';
	} // END BaTi_Admin_HomePage()
?>