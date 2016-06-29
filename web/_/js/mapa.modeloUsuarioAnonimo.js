function inicializarFormularioBache(){
  	Bacheo.myDropzone.removeAllFiles();
	$("#informacionBache").modal("toggle");
	var $divSelect = $("#contenedorSelect");
//	<select id="criticidad" class="form-control campoDerecho"> </select>
	var fallas = GestorMateriales.obtenerFallas();
	var keysFallas = Object.keys(fallas);
	$('#contenedorSelect').empty();
	var $opcionesFalla = $('<select class="form-control campoIzquierdo derechoAmpliado" id="tipoFalla"/>');
	$(keysFallas).each(function(indice,elemento){
	    var opcion = new Option(fallas[elemento].nombre,fallas[elemento].id,true,true);
	    $(opcion).click(function(){
	    });
	    $opcionesFalla.append(opcion);
	  });
//	var $divSelect = $('<div id="contenedorSelect" class="input-group tipoFalla"/>');
	$divSelect.append($('<label class="form-control campoDerecho derechoAmpliado">Tipo de Falla</label>'));
	$divSelect.append($opcionesFalla);
	$("#modaInfoBacheAceptar").unbind();
	$("#modaInfoBacheAceptar").click(function(){
		recolectarFalla();
	});

};

// Bacheo.agregarMarcador
function recolectarFalla(){
	var datos = {};
	datos.falla = {};
	datos.direccion = {};
	var $formulario = $('form[id="formularioBache"]')[0];
	datos.direccion.callePrincipal = $formulario["calle"].value;
	datos.direccion.calleSecundariaA = "No tenemos como obtenerlo!!!";
	datos.direccion.calleSecundariaB = "No tenemos como obtenerlo!!!";
	datos.direccion.altura = $formulario["altura"].value;
	datos.tipoFalla = {};
	datos.tipoFalla.id = $formulario["tipoFalla"].value;
	datos.observacion = {};
	datos.observacion.nombreObservador = "Anonimo";
	datos.observacion.emailObservador = "anonimo@mail.com";
	datos.observacion.comentario = $formulario["descripcion"].value;
	// Bacheo.Anonimo
	Bacheo.agregarAnonimo(datos);

}