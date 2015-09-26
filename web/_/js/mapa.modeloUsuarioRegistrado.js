/* inicializarFormularioBache: Funcion encargada de renderizar los elementos del formulario
 * segun coresponde a un usuario registrado																		*/
function inicializarFormularioBache(){
  	Bacheo.myDropzone.removeAllFiles();
	$("#informacionBache").modal("toggle");
	var $divSelect = $("#contenedorSelect");
	$divSelect.empty();
	var materiales = GestorMateriales.obtenerArregloMateriales();
	var keysMateriales = Object.keys(materiales);
	var $opcionesMaterial = $('<select class="form-control campoIzquierdo derechoAmpliado" name="tipoMaterial" id="tipoMaterial"/>');
	$(keysMateriales).each(function(indice,elemento){
	    var opcion = new Option(materiales[elemento].nombre,materiales[elemento].id,true,true);
	    $(opcion).click(function(){
	    	cargarTiposFalla(materiales[elemento].fallas);
	    });
	    $opcionesMaterial.append(opcion);
	  });
	$divSelect.append($('<label class="campoIzquierdo izquierdoReducido">Tipo de Material</label>'));
	$divSelect.append($opcionesMaterial);
	$divSelect.append($('<label class="campoIzquierdo izquierdoReducido">Factor Área (%)</label>'));
	$divSelect.append('<input class="form-control campoDerecho derechoAmpliado" name="factorArea" id="factorArea" type="number" step="any" min="0"/>');

	$divSelect.append($('<div id="contenedorSelectFallas" class="input-group" style="width:100%;"/>'));
	cargarTiposFalla(materiales[keysMateriales[0]].fallas);

	$("#modaInfoBacheAceptar").unbind();
	$("#modaInfoBacheAceptar").click(function(){
		recolectarFalla();
	});
};

/* cargarTiposFalla: Obtiene y completa la parte del formulario encargada de presentar los diferentes tipos
 * de falla registrados en el sistema																		*/
function cargarTiposFalla(fallas){
	var $divSelectFallas = $("#contenedorSelectFallas");
	$divSelectFallas.empty();
	$divSelectFallas.append($('<label class="campoIzquierdo izquierdoReducido">Tipo de Falla</label>'));
	var $opcionesFallas = $('<select class="form-control campoDerecho derechoAmpliado" name="tipoFalla" id="tipoFalla"/>');
	$(fallas).each(function(indice,elemento){
		var opcion = new Option(elemento.nombre,elemento.id,true,true);
	    $(opcion).click(function(){
	    	cargarOpcionesFalla(elemento.atributos,elemento.reparaciones);
	    });
	    $opcionesFallas.append(opcion);
	});
	$opcionesFallas.val(fallas[0].id);
	$divSelectFallas.append($opcionesFallas);
	$divSelectFallas.append('<div id="contenedorAtributosFalla" class="input-group" style="width:100%;"/>');
	cargarOpcionesFalla(fallas[0].atributos,fallas[0].reparaciones);
}

/* cargarOpcionesFalla: Agrega al formulario los campos a llenar correspondientes a las propiedades del tipo 
 * de falla especificado en la casilla de seleccion de Tipo de Falla										*/
function cargarOpcionesFalla(atributos,reparaciones){
	var $contenedorAtributos = $("#contenedorAtributosFalla");
	$contenedorAtributos.empty();
	$(atributos).each(function(indice,elemento){
		var $unDiv = $('<div/>');
		$unDiv.append($('<label class="campoIzquierdo izquierdoReducido">'+elemento.nombre+'</label>'));
		$unDiv.append($('<input type="number" propId="'+elemento.id+'" step="any" min="0" class="campoDerecho derechoAmpliado"/>'));
		$contenedorAtributos.append($unDiv);
	});
	$contenedorAtributos.append($('<label class="campoIzquierdo izquierdoReducido">Tipo de Reparación</label>'));
	var $opcionesReparacion = $('<select class="form-control campoDerecho derechoAmpliado" name="tipoReparacion" id="tipoReparacion"/>');
	var keysReparaciones = Object.keys(reparaciones);
	$(keysReparaciones).each(function(indice,elemento){
	    var opcion = new Option(reparaciones[elemento].nombre,reparaciones[elemento].id,true,true);
	    $opcionesReparacion.append(opcion);
	  });
	$contenedorAtributos.append($opcionesReparacion);
}

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
	datos.tipoMaterial = $formulario["tipoMaterial"].value;
	datos.tipoFalla = $formulario["tipoFalla"].value;
	datos.observacion = $formulario["descripcion"].value;
	datos.falla.factorArea = $formulario["factorArea"].value;
	datos.reparacion = $formulario["tipoReparacion"].value;
	var arregloAtributos = $("#contenedorAtributosFalla").find("input");
	datos.atributos = [];
	for (var i = arregloAtributos.length - 1; i >= 0; i--) {
		var attr = {"id":$(arregloAtributos[i]).attr("propId"),"valor":arregloAtributos[i].value};
		datos.atributos.push(attr);
	};
	Bacheo.agregarMarcador(datos);
}