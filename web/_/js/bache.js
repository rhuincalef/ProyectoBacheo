$(document).ready(function(){
	debug();
	Bache.init();
	$( "#fechaFin").datepicker();
	$( "#fechaFinReal").datepicker();

	url = $('#baseUrlBache').text();
	imagenesBache = $('#imagenesBache').text();
	// Bache.cargarImagenes(url, );
	Bache.redimensionarImg();

	Bache.comentarios();
    $("#botonTwitter").click(function(){
    	Bache.comentarTwitter();
    });
    $("#registrarEstadoBache").click(function(evento){
		evento.preventDefault();
		estado = JSON.parse($("#estadoBache").text());
		console.log(estado.tipoEstado.nombre);
		nuevoEstado = estado.tipoEstado.nombre;
		if ("Informado"==nuevoEstado) {
		Bache.cambiarEstado();
		}
		if ("Confirmado"==nuevoEstado) {
			Bache.cambiarReparando();
		}
		if ("Reparando"==nuevoEstado) {
			alertar("Error!", "Falta implementación", "error");
			//Bache.cambiarReparado();
		}
		window.location.reload();
	});

	$("#enviarObservacion").click(function(){
		Bache.comentar();
	});
	$("#formularioComentario")[0].reset();
	
	setInterval("Bache.comentarios();",30000);

	/* Mis aportes....................*/
	Bacheo.init();
	$('.tabInfo li:eq(1)').click(function(){
		cargarMateriales();
	});
	$('.tabInfo li').not(':eq(1)').click(function() {
		$(":checkbox").prop("checked", false);
	});

});

	
function cargarComentarios(comentarios) {
	$comentarios = $('<div id="comentarios" class="divComentarios"></div>');
	$("#observaciones").empty();
	$("#observaciones").append($comentarios);
	$comentarios.append("");
	for (var i = 0; i < comentarios.length; i++) {
		var $comentarioUsuario = $('<div/>');
		$comentarioUsuario.addClass("comentarioUsuario")
		var $avatar= $('<div/>');
		$avatar.addClass("avatar");
		var $comentario = $('<div/>');
		$comentario.addClass("comentarioIndividual");
		if (comentarios[i].hasOwnProperty('screenName')) {
			$avatar.append('<a href="https://twitter.com/'+comentarios[i].screenName+'" target="_blank">'+comentarios[i].screenName+'</a>('+comentarios[i].fecha+') Dice:');
			$avatar.css('background-image','url('+comentarios[i].imagenPerfil+')');			
		}else{
			$avatar.append(comentarios[i].usuario+" ("+comentarios[i].fecha+") Dice:");
		}
		
		$comentario.append(comentarios[i].texto);
		$comentarioUsuario.append($avatar);
		$comentarioUsuario.append($comentario);
		$comentarios.append($comentarioUsuario);
	};
	$("#comentarios").scrollTop(1000);	
}

function inArray(elem,array)
{
    var len = array.length;
    for(var i = 0 ; i < len;i++)
    {
        if(JSON.stringify(array[i]) == JSON.stringify(elem)){return i;}
    }
    return -1;
}

function estadoBache(estado, tiposEstado){
	var indice = parseInt(inArray(estado.tipoEstado, tiposEstado));
	var valFin = (indice+1) % (tiposEstado.length) + 1;
	if(valFin == 0){
		valFin = 4;
		tiposEstado.push(tiposEstado[0]);
	}
	$("#nombreEstado").text("Estado de Falla: "+tiposEstado[indice].nombre);
	indice = indice + 1;
	$('#cambiarEstado').text('Cambiar estado a: '+tiposEstado[indice].nombre);
	$("#contenedorControladorEstado").append('<div id="slider" class="controlEstado"></div>');
	$( "#slider" ).slider({
		value:parseInt(indice),
		min: parseInt(indice),
		max: valFin,
		step: 1,
		slide: function( event, ui ) {
			var indiceCarga = ui.value;
			$("#cambiarEstado").empty();
			$("#cambiarEstado").text("Cambiar estado a: "+tiposEstado[indiceCarga].nombre);
			cargarFormularioTecnico(indiceCarga);
		}
	});
	cargarFormularioTecnico(indice);
}


function cargarFormularioTecnico (estado) {
	var $form = $("#formularioEspecificacionesTecnicas");
	$("#contenedorEstado").show();
	$("#contenedorFormulario").show();
}

/* Mis aportes....................*/
function cargarMateriales () {
	var $select = $("#material");
	$select.empty();
	var materiales = GestorMateriales.obtenerArregloMateriales();
	var keysMateriales = Object.keys(materiales);
	$(keysMateriales).each(function(indice,elemento){
		var opcion = new Option(materiales[elemento].nombre,materiales[elemento].id,true,true);
		$(opcion).click(function(){
			cargarTiposFalla(materiales[elemento].fallas);
		});
		$select.append(opcion);
	});
	cargarTiposFalla(materiales[keysMateriales[0]].fallas);
}

/* cargarTiposFalla: Obtiene y completa la parte del formulario encargada de presentar los diferentes tipos
 * de falla registrados en el sistema																		*/
function cargarTiposFalla(fallas){
	var $opcionesFallas = $('#tipoFalla');
	$opcionesFallas.empty();
	$(fallas).each(function(indice,elemento){
		var opcion = new Option(elemento.nombre,elemento.id,true,true);
	    $(opcion).click(function(){
	    	cargarOpcionesFalla(elemento.atributos,elemento.reparaciones,elemento.criticidades);
	    });
	    $opcionesFallas.append(opcion);
	});
	$('#tipoFalla').val(fallas[0].id);
	cargarOpcionesFalla(fallas[0].atributos,fallas[0].reparaciones, fallas[0].criticidades);
}

function cargarOpcionesFalla (atributos,reparaciones, criticidades) {
	var $contenedorAtributos = $("#contenedorAtributosFalla");
	$contenedorAtributos.empty();
	$(atributos).each(function(indice,elemento){
		var $unDiv = $('<div/>');
		$unDiv.append($('<label class="control-label col-sm-4 itemFormularioEstado">'+elemento.nombre+'</label>'));
		$unDiv.append($('<input type="number" propId="'+elemento.id+'" step="0.1" min="0" class="form-control selectFormulario itemFormularioEstado" value="0.5"/>'));
		//$unDiv.append($('<input type="number" propId="'+elemento.id+'" step="0.1" min="0" class="form-control selectFormulario itemFormularioEstado form-desactivado" value="0.5" disabled=""/>'));
		$contenedorAtributos.append($unDiv);
	});
	$contenedorAtributos.append($('<label class="control-label col-sm-10 itemFormularioEstado" for="tipoReparacion"> Tipo de Reparación</label>'));
	//var $opcionesReparacion = $('<select id="tipoReparacion" name="tipoReparacion" class="form-control col-sm-4 itemFormularioEstado form-desactivado" disabled=""></select>');
	var $opcionesReparacion = $('<select id="tipoReparacion" name="tipoReparacion" class="form-control col-sm-4 itemFormularioEstado"></select>');
	var keysReparaciones = Object.keys(reparaciones);
	$(keysReparaciones).each(function(indice,elemento){
	    var opcion = new Option(reparaciones[elemento].nombre,reparaciones[elemento].id,true,true);
	    $opcionesReparacion.append(opcion);
	  });
	$contenedorAtributos.append($opcionesReparacion);

	var $opcionesCriticidades = $('#criticidad');
	$opcionesCriticidades.empty();
	$(criticidades).each(function(indice, elemento){
		var opcion = new Option(elemento.nombre, elemento.id, true, true);
		$opcionesCriticidades.append(opcion);
	});
}