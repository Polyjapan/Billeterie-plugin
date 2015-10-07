jQuery(document).ready(function(){
	if (typeof jQuery.ui !== 'undefined') {
		console.log("UI loaded");
		jQuery( "#BaTi_slider" ).slider({
			  range: "min",
			  value: 0,
			  min: -2,
			  max: 500,
			  slide: function( event, ui ) {
				jQuery( "#BaTi_amount" ).val(ui.value);
			  }
			});
		jQuery( "#BaTi_amount" ).val( jQuery( "#BaTi_slider" ).slider( "value" ));
		jQuery( "#BaTi_amount" ).change(function() {
			jQuery( "#Bati_slider").slider( "option", "value",jQuery(this ).val());
			console.log("changed with val " + jQuery(this ).val());
		});
	}
	else
	{
		console.log("UI not loaded");
	}
});