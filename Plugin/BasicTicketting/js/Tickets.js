jQuery(document).ready(function(){
console.log("Pommes");
if (typeof jQuery.ui !== 'undefined') {
console.log("UI loaded");
jQuery( "#BaTi_slider" ).slider({
      range: "min",
      value: 0,
      min: -2,
      max: 500,
      slide: function( event, ui ) {
        jQuery( "#BaTi_amount" ).val(ui.value + "CHF");
      }
    });
}
else
{
console.log("UI not loaded");
}
jQuery( "#BaTi_amount" ).val( jQuery( "#BaTi_slider" ).slider( "value" ) + "CHF" );
console.log("patate");
});
console.log("Banane");
console.log("Poire");