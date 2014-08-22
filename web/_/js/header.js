(function($) {
	$(document).ready(function(){
		$("#inicioSesion").on("submit", function(evento){
			evento.preventDefault();
			log('inside coolFunc', this, arguments);
			$("#opcionInicioSesion").addClass("hide");
			$("#opcionSesion").removeClass("hide");
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
		// tipo = "error";
		// tipo = "info";
       // tipo = "success";  
		    new PNotify({
		      title: titulo,
		      text: texto,
		      addclass: "stack-bottomright",  
		      type:tipo
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