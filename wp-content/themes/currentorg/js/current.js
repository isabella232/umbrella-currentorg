jQuery(document).ready(function( $ ) {
	// Newsletter signup form interaction
	$('.newsletter-signup .email_address').focus(function() {
		$(this).siblings('.first_name, .last_name, .submit').show();
	});

	$(document).mouseup(function(e) {
		var container = $(".newsletter-signup");
		if (!container.is(e.target) && container.has(e.target).length === 0)
			container.find('.first_name, .last_name, .submit, .error').hide();
	});
});
