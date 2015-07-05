var Reparacion = (function(){

	var reparaciones = [];
	var reparacionesExistentes = [];

	function inicializar(){
//		$.get( "/proyectoBacheo/getAll/TipoReparacion", function( data ) {
		$.get( "getAll/TipoReparacion", function( data ) {
			var respuesta = JSON.parse(data);
			if(respuesta.codigo == CODIGO_EXITO){
				$("#sinReparacionesExistentes").addClass("oculto");
				var reparaciones = JSON.parse(respuesta.valor);
				reparaciones.map(function(reparacion){
					reparacionesExistentes.push(reparacion);
					cargarReparacion(reparacion);
				});
			}

			
		});

	}

	function cargarReparacion(reparacion){
		reparacion.nombre = reparacion.nombre.toLowerCase();
		var $a = $('<a class="list-group-item capitalizado"></a>');
		$a.append('<span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Reparacion.agregarReparacionExistente(this)"></span>');
		$a.append('<h4 name="nombre" class="list-group-item-heading">'+reparacion.nombre+'</h4>');
		$a.append('Descripcion:<p name="descripcion" class="list-group-item-text sangria">'+reparacion.descripcion+'</p>');
		$a.append('<br>');
		$a.append('Costo:<p name="costo" class="sangria"> '+reparacion.costo+' </p>');
		$("#listaReparacionesExistentes").append($a);
	}

	function agregarReparacion(reparacion,costo,descripcion){

		reparacion = reparacion.toLowerCase();
		if ((reparaciones.filter(function(rep){return rep.nombre == reparacion}).length != 0)  || (reparacion.length == 0) ){
			alertar("Error!", "El nombre no puede estar vacio ni ser repetido", "error");
			return false;
		}	
		if(costo.length == 0){
			alertar("Error!", "El valor del Costo debe ser numerico", "error");
			return false;
		}

		var objReparacion={"nombre":reparacion,"costo":costo,"descripcion":descripcion};
		$("#listaReparacionesSeleccionadas").append('<a class="list-group-item capitalizado"><span class="glyphicon glyphicon-remove tabuladoDerecha" aria-hidden="true" onclick="Reparacion.eliminarReparacion(this)"></span><h4 name="nombre" class="list-group-item-heading capitalizado">'+reparacion+'</h4>Descripcion:<p name="descripcion" class="list-group-item-text sangria">'+descripcion+'</p><br>Costo($):<p name="costo" class="sangria">'+costo+'</p></a>');	
		$("#sinReparaciones").addClass("oculto");
		reparaciones.push(objReparacion);
		return true;
	}

	function crearYAgregarReparacion(){
		if(agregarReparacion($("#nombreReparacionNueva").val(),$("#costoReparacionNueva").val(),$("#descripcionReparacionNueva").val())){;
			$("#nombreReparacionNueva").val("");
			$("#costoReparacionNueva").val("");
			$("#descripcionReparacionNueva").val("");
		}
			
	}

	function agregarReparacionExistente(elemento){
		var costo = $(elemento.parentNode).find("[name|=costo]").text();
		var reparacion = $(elemento.parentNode).find("[name|=nombre]").text();
		var descripcion = $(elemento.parentNode).find("[name|=descripcion]").text();
		agregarReparacion(reparacion,costo,descripcion);

	}

	function eliminarReparacion(elemento){
		$(elemento.parentNode).remove();
		var pos = reparaciones.map(function(reparacion){ return reparacion.nombre;}).indexOf($(elemento.parentNode).find("[name|=nombre]").text());
		pos > -1 && reparaciones.splice( pos, 1 );
		if(reparaciones.length == 0)
			$("#sinReparaciones").removeClass("oculto");

	}

	return{
		inicializar:inicializar,
		reparaciones:reparaciones,
		agregarReparacion:agregarReparacion,
		crearYAgregarReparacion:crearYAgregarReparacion,
		agregarReparacionExistente:agregarReparacionExistente,
		eliminarReparacion:eliminarReparacion
	}
}());