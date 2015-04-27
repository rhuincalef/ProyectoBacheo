
var seleccionado = "material";
var anteriorSeleccionado = "material";
$(document).ready(function(){
	var listaOpciones = $("#secciones").find(".list-group-item");
	for (var i = 1; i < listaOpciones.length; i++) {
		(function(elemento){
			elemento.click(function(){
				cargarOpciones(elemento.attr("id"));
			});
		}($(listaOpciones[i])));

	};

});

function cargarOpciones(opcion){
	anteriorSeleccionado = seleccionado;
	seleccionado = opcion;
	//var listaOpciones = $("#contenedorOpciones").find(".list-group-item");
	$("#"+anteriorSeleccionado).removeClass("active");
	$("#contenido"+anteriorSeleccionado).addClass("oculto");

	$("#"+seleccionado).addClass("active");
	$("#contenido"+opcion).removeClass("oculto");

}

