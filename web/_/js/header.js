(function($) {
	$(document).ready(function(){
		$("#inicioSesion").on("submit", function(evento){
			evento.preventDefault();
			log('inside coolFunc', this, arguments);
			$("#opcionInicioSesion").addClass("hide");
			$("#opcionSesion").removeClass("hide");
		});
	});
})(jQuery);