(function($) {
	$(document).ready(function(){
		$("#crearUsuario").on("submit", function (event) {
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
				success: function (arguments) {
					response = $.parseJSON(arguments);
					if (response.status=='OK'){
						// $(".alert").addClass("alert-success");
						alertar("Exito!", response.message, "success");
						// Empty the login form content and replace it will a successful.
						$("#crearUsuario").find("input").each(function (i, e) {
							$(e).val('');
						});
					}else{
						$(".alert").addClass("alert-danger");
						alertar("Error!", response.message, "error");
					}
				}
			});
		});

	});


})(jQuery);