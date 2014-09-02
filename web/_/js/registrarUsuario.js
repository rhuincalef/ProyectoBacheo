(function($) {
	$(document).ready(function(){
		$("#registrarUsuario").on("submit", function (event) {
			event.preventDefault();
			$(".alert").empty();
			var $form_inputs = $(this).find("input");
			var form_data = {};
			// Get the form data.
			$form_inputs.each(function() 
			{
				form_data[this.name] = $(this).val();
			});
			// Get the url that the ajax form data is to be submitted to.
			var submit_url = $(this).attr('action');
			$.ajax({
				url: submit_url,
				type: 'POST',
				data: form_data,
				success: function (response) {
					if (response){
						$(".alert").addClass("alert-success");
						// Empty the login form content and replace it will a successful.
						$("#registrarUsuario").find("input").each(function (i, e) {
							$(e).val('');
						});
					}else{
						$(".alert").addClass("alert-danger");
					}
					// Show the message received.
					// $(".alert").children().text(response);
					$(".alert").append('<i class="fa fa-warning">  </i>');
					$(".alert").append(response);
					// $(".alert p").prepend('<i class="fa fa-warning"></i>');
					$(".alert").removeClass("hide");
				}
			});
		});

	});


})(jQuery);