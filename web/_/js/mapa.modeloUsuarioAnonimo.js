function inicializarFormularioBache(){
  	Bacheo.myDropzone.removeAllFiles();
	$("#informacionBache").modal("toggle");
	var $divSelect = $("#contenedorSelect");
//	<select id="criticidad" class="form-control campoDerecho"> </select>
//	var $formulario = $("#formularioBache");
	var fallas = GestorMateriales.obtenerFallas();
	var keysFallas = Object.keys(fallas);
//	$formulario.empty();
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

};