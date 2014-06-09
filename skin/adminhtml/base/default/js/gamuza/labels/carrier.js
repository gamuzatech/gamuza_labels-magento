Event.observe(window, 'load', function(){
carrier_option_id = 'carrier_option_' + $('customer_carrier_id').getValue ();
$(carrier_option_id).setValue (true);
});
