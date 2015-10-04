<?php

/**
Main function for the shortcode */
function BaTi_getBasicTicketting($atts, $content = null ) 
{
	//default value for attribute if not given
    $a = shortcode_atts( array(
        'event' => 'error',
        // ...etc
    ), $atts );
	
	if($a['event'] == 'error')
	{
		echo 'you shall burn in hell you stupid';
	}
	else
	{
		//echo 'yay you called the ticketing plugin for the '.$a['event'];
		BaTi_getLogin();
	}
}

/** function who display the login form */
function BaTi_getLogin()
{
?>
	<div class="BaTi_login">
      <h1>Connexion à la billetterie</h1>
      <form method="post" action="index.html">
        <p><input type="text" name="login" value="" placeholder="Email"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <p class="submit"><input type="submit" name="commit" value="Connexion"></p>
      </form>
    </div>

    <div class="login-help">
      <p>Oubliez votre mot de passe ? <a href="index.html">Cliquez ici pour le réinitialiser</a>.</p>
    </div>
	<div class="new_account">
		<p>Vous n'avez pas encore de compte ? <a href="?createAccount=1">Cliquez ici pour en créer un</a>.</p>
	</div>
<?php
}
