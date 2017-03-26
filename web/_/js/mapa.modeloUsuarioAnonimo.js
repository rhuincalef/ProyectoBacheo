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

/* Tipo de Falla anonima - Evitamos mostrar algunos datos */
var TipoFalla = function(datos){
	this.id = datos.id;
	this.nombre = datos.nombre;
	this.influencia = datos.influencia;
	this.atributos = [];
	this.criticidades = [];
	this.reparaciones = [];
	this.multimedia = null;
	var _this = this;

	console.log(datos);
	GestorMateriales.obtenerReparaciones(datos.reparaciones,_this.reparaciones);

	$.post("index.php/publico/getTiposAtributo", {"idTipos":JSON.stringify(datos.atributos)}, function(data) {
		var datos = JSON.parse(data);
		if(datos.codigo == 200){
			var attr = JSON.parse(datos.valor);
			$(attr).each(function(indice,elemento){
    			_this.atributos.push({"id":elemento.id,"nombre":elemento.nombre});
    		});
		}
	});
	this.getMultimedia = function(){
		if(this.multimedia != null)
			return this.multimedia;
		$.get( "index.php/publico/getMultimediaTipoFalla/"+_this.id, function(data) {
			var datos = JSON.parse(data);
			$(datos).each(function(indice,elemento){
    			_this.multimedia = elemento.multimedia;
    			return _this.multimedia;
    		});
		});
	};

	return this;
};
