function inicializarFormularioBache(){
  	Bacheo.myDropzone.removeAllFiles();
	$("#informacionBache").modal("toggle");
	var $divSelect = $("#contenedorSelect");
	$divSelect.empty();
	var materiales = GestorMateriales.obtenerArregloMateriales();
	var keysMateriales = Object.keys(materiales);
	var $opcionesMaterial = $('<select class="form-control campoIzquierdo derechoAmpliado" id="tipoMaterial"/>');
	$(keysMateriales).each(function(indice,elemento){
	    var opcion = new Option(materiales[elemento].nombre,materiales[elemento].id,true,true);
	    $(opcion).click(function(){
	    	cargarTiposFalla(materiales[elemento].fallas);
	    });
	    $opcionesMaterial.append(opcion);
	  });
	$divSelect.append($('<label class="campoIzquierdo izquierdoReducido">Tipo de Material</label>'));
	$divSelect.append($opcionesMaterial);
	$divSelect.append($('<div id="contenedorSelectFallas" class="input-group" style="width:100%;"/>'));
	cargarTiposFalla(materiales[keysMateriales[0]].fallas);
};

function cargarTiposFalla(fallas){
	//alert("CARGAR TIPOS FALLA");
	var $divSelectFallas = $("#contenedorSelectFallas");
	$divSelectFallas.empty();
	$divSelectFallas.append($('<label class="campoIzquierdo izquierdoReducido">Tipo de Falla</label>'));
	var $opcionesFallas = $('<select class="form-control campoDerecho derechoAmpliado" id="tipoFalla"/>');
	$(fallas).each(function(indice,elemento){
		var opcion = new Option(elemento.nombre,elemento.id,true,true);
	    $(opcion).click(function(){
	    	cargarOpcionesFalla(elemento.atributos);
	    });
	    $opcionesFallas.append(opcion);
	});
	$opcionesFallas.val(fallas[0].id);
	$divSelectFallas.append($opcionesFallas);
	$divSelectFallas.append('<div id="contenedorAtributosFalla" class="input-group" style="width:100%;"/>');
	cargarOpcionesFalla(fallas[0].atributos);
}

function cargarOpcionesFalla(atributos){
	var $contenedorAtributos = $("#contenedorAtributosFalla");
	$contenedorAtributos.empty();
	$(atributos).each(function(indice,elemento){
		var $unDiv = $('<div/>');
		$unDiv.append($('<label class="campoIzquierdo izquierdoReducido">'+elemento.nombre+'</label>'));
		$unDiv.append($('<input type="number" propId="'+elemento.id+'" step="any" min="0" class="campoDerecho derechoAmpliado"/>'));
		$contenedorAtributos.append($unDiv);
	});
}