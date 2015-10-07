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
		echo 'you shall burn in hell ya stupid';
	}
	else
	{
		//echo 'yay you called the ticketing plugin for the '.$a['event'];
		BaTi_getClient();
	}
}

/** function who display the first page of the ticket system */
function BaTi_getClient()
{
	?>
	<div class="BaTi_firstPage">
		<div class="BaTi_left">
		<h1>Bienvenu dans le système de Billetterie de Japan Impact !</h1>
		<h2>Choisissez le nombre de ticket</h2>
		<hr/>
		<?php echo BaTi_getTickets() ?>
		<h2>Choisissez votre prix</h2>
		<hr/>
			<p> Cette année nous innovons ! Vous pouvez choisir combien vous payez pour vos ticket ! De cette façon, vous avez la chance de pouvoir participer à la réalisation de cet événement 
			</p>
		<?php echo BaTi_getSlider() ?>
		<h2>Interets</h2>
		<hr/>
			<p> Ici dites nous vos envie pour la prochaine édition de Japan Impact !
			</p>
		<?php echo BaTi_getInterest(); ?>
		</div>
		<div class="BaTi_right"
			<h2>Total = </h2>
			<h2>Rewards</h2>
			<?php echo BaTi_getRewards(); ?>
		</div>
	</div>

<?php
}

function BaTi_getTickets()
{
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}BaTi_tblTypeBillet");
	$msg = "";
	$msg .= "<table>
	<tr>
		<th>Type de Billet</th>
		<th>Quantité</th>
		<th>Prix (CHF)</th>
	</tr>";
	foreach($results as $row)
	{
		$msg .= "<tr>";
		$msg .= "<td>".$row->tybiNom."</td>";
		$msg .= '<td><input type="number" name="amount_type'.$row->PKTypeBillet.'"></td>';
		$msg .= "<td>".$row->tybiPrix."</td";
		$msg .= "</tr>";
	}
	
	
	$msg .= "</table>";
	return $msg;
}

function BaTi_getSlider()
{
	return "slider";
}

function BaTi_getRewards()
{
	return "crowdfunding";
}

function BaTi_getInterest()
{
	return "Interet";
}

/** function who display the login form */
function BaTi_getLoginPage()
{
?>
	<div class="BaTi_login">
      <h1>Login to Web App</h1>
      <form method="post" action="index.html">
        <p><input type="text" name="login" value="" placeholder="Username or Email"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>

    <div class="login-help">
      <p>Forgot your password? <a href="index.html">Click here to reset it</a>.</p>
    </div>
<?php
}