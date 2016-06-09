var Criticidad = (function(){

	var criticidades = [];
	

	function agregarCriticidad(criticidad,descripcion,ponderacion){
		criticidad = criticidad.toLowerCase();
		if ((criticidades.filter(function(atr){return atr.nombre == criticidad}).length != 0) || (criticidad.length == 0)){
			alertar("Error!", "El nombre no puede estar vacio ni ser repetido", "error");
			return false;
		}
		if(ponderacion.length == 0){
			alertar("Error!", "El valor de Ponderacion debe ser numerico", "error");
			return false;
		}
		var $li = $('<li class="list-group-item capitalizado contenedorLista"></li>');
		var criticidadCompleta = $("<div class='contenidoLista'>"+criticidad+"</div><div class='contenidoLista'>"+ponderacion+"</div>");
		$li.append(criticidadCompleta);
		$li.append('<span class="glyphicon glyphicon-remove tabuladoDerecha" aria-hidden="true" onclick="Criticidad.eliminarCriticidad(this);"></span>');
		$("#listaCriticidadesSeleccionadas").append($li);
		$("#sinCriticidades").addClass("oculto");
		var objetoCriticidad={"nombre":criticidad,"descripcion":descripcion,"ponderacion":ponderacion};
		criticidades.push(objetoCriticidad);
		return true;
	}

	function crearYAgregarCriticidad(){
		if(agregarCriticidad($("#nombreCriticidadNueva").val(),$("#descripcionCriticidadNueva").val(),$("#ponderacionCriticidadNueva").val())){
			$("#nombreCriticidadNueva").val("");
			$("#descripcionCriticidadNueva").val("");
			$("#ponderacionCriticidadNueva").val("");
		}
	}


	function eliminarCriticidad(elemento){

		var pos = criticidades.map(function(criticidad){ return criticidad.nombre;}).indexOf(elemento.previousSibling.previousSibling.textContent);
//		var pos = criticidades.indexOf(elemento.previousSibling.previousSibling.textContent);
		pos > -1 && criticidades.splice( pos, 1 );
		if(criticidades.length == 0)
			$("#sinCriticidades").removeClass("oculto");
		$(elemento.parentNode).remove();
	}

	return{
		criticidades:criticidades,
		agregarCriticidad:agregarCriticidad,
		crearYAgregarCriticidad:crearYAgregarCriticidad,
		eliminarCriticidad:eliminarCriticidad
	}
}());