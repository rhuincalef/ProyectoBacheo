var Atributo = (function(){

	var atributos = [];
	

	function agregarAtributo(atributo,unidad){
		atributo = atributo.toLowerCase();
		if ((atributos.filter(function(atr){return atr.nombre == atributo}).length != 0) || (atributo.length == 0) ){
			alertar("Error!", "El nombre no puede estar vacio ni ser repetido", "error");
			return false;
		}
		if(ponderacion.length == 0){
			alertar("Error!", "El valor de Unidad no puede estar vacio", "error");
			return false;
		}
		var $li = $('<li class="list-group-item capitalizado contenedorLista"></li>');
		var atributoCompleto = $("<div class='contenidoLista'>"+atributo+"</div><div class='contenidoAtributo'>"+unidad+"</div>");
		$li.append(atributoCompleto);
		$li.append('<span class="glyphicon glyphicon-remove tabuladoDerecha" aria-hidden="true" onclick="Atributo.eliminarAtributo(this);"></span>');
		$("#listaAtributosSeleccionados").append($li);
		$("#sinAtributos").addClass("oculto");
		var objAtributo = {"nombre":atributo,"unidad":unidad};
		atributos.push(objAtributo);
		return true;
	}

	function crearYAgregarAtributo(){
		if(agregarAtributo($("#nombreAtributoNuevo").val(),$("#unidadAtributoNuevo").val())){
			$("#nombreAtributoNuevo").val("");
			$("#unidadAtributoNuevo").val("");
		}
	}


	function eliminarAtributo(elemento){
		var pos = atributos.map(function(atributo){ return atributo.nombre;}).indexOf(elemento.previousSibling.previousSibling.textContent);
		pos > -1 && atributos.splice( pos, 1 );
		if(atributos.length == 0)
			$("#sinAtributos").removeClass("oculto");
		$(elemento.parentNode).remove();
	}

	return{
		agregarAtributo:agregarAtributo,
		crearYAgregarAtributo:crearYAgregarAtributo,
		eliminarAtributo:eliminarAtributo,
		atributos:atributos
	}
}());