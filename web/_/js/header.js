(function($) {
	$(document).ready(function(){
			
		$("#inicioSesion").on("submit", function(evento){
			evento.preventDefault();
			log('inside coolFunc', this, arguments);
			// Get the form data.
			var $form_inputs = $(this).find("input");
			// data = {'login_identity':'guille@gmail.com', 'login_password':'1234', 'remember_me':'1', 'login_user':'Submit'};
			data = {"login_identity":$($form_inputs[0]).val(), "login_password":$($form_inputs[1]).val()}
			var submit_url = $(this).attr("action")+"index.php/auth/login_via_ajax";
			$.ajax(
			{
				url: submit_url,
				type: 'POST',
				data: data,
				// data: form_data,
				success:function(arguments)
				{
					response = $.parseJSON(arguments);
					
					// If the returned login value successul.
					if (response.status == "OK")
					{
						logearGraficamente(response.data.login_identity);
						alertar(response.data.login_identity, "Login via Ajax was successful!", "success");
						window.location.reload();
					}
					// Else the login credentials were invalid.
					else
					{
						// Show an error message stating the users login credentials were invalid.
						alertar("titulo", response.data, "error");
					}
					
				}
			});
		});
		
		

		$("#cerrarSesion").click(function (evento) {
			evento.preventDefault();
			$.ajax({
				url: "index.php/auth/logout",
				type: "POST",
				success:function () {
					alertar("titulo","Se ha cerrado la sesion.","success");
					$("#opcionInicioSesion").removeClass("hide");
					$("#opcionSesion").addClass("hide");
					$("#opcionSesion .dropdown-toggle").children("a").remove();
				}
			});
		});

		$("#registrarUsuario").click(function (evento) {
			evento.preventDefault();
			window.location = "index.php/auth/registrarUsuario";
		});

		$(".cuadroBusqueda").find("input").focus(function(){
			$(".cuadroBusqueda").animate(
				{"width": "+=100px"},
			   	'slow',
			  	'swing',
			  	function(){$(".cuadroBusqueda").find("input").css({"width":"90%"})}
			 );
		});

		$(".cuadroBusqueda").find("input").blur(function(){	
			$(".cuadroBusqueda").animate(
				{"width": "-=100px"},
			   	'slow',
			  	'swing'
			 );
			$(".cuadroBusqueda").find("input").css({"width":"70%"});
		});




	});


})(jQuery);


	function alertar(titulo,texto,tipo) {
		var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25};    	
		var opts = {
			title: titulo,
			text: texto,
			addclass: "stack-bottomright",
			type: tipo,
			stack: stack_bottomright
		};
		
		new PNotify(opts);
    	
	}

	function logearGraficamente(usuario) {
		$("#opcionInicioSesion").addClass("hide");
		$("#opcionSesion").removeClass("hide");
		$("#opcionSesion .dropdown-toggle").prepend('<a href="">' + usuario + '</a>');
		$("#opcionInicioSesion").find("input").each(function (i, e) {
			$(e).val('');
		});
						
	}

	function informar(titulo,texto) {
		var tooltip = new PNotify({
		    title: titulo,
		    text: texto,
		    hide: false,
		    buttons: {
			    closer: false,
			    sticker: false
			},
		    history: {
		    	history: false
		    },
		    animate_speed: 100,
		    opacity: .9,
		    icon: "ui-icon ui-icon-comment",
		    // Setting stack to false causes PNotify to ignore this notice when positioning.
		    stack: false,
		    auto_display: false,
		    type: "info"
		});
		return tooltip;
		    
	}