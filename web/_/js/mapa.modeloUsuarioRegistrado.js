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

};

function cargarTiposFalla(fallas){
	alert("CARGAR TIPOS FALLA");
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
	$divSelectFallas.append($opcionesFallas);
}

function cargarOpcionesFalla(atributos){

}