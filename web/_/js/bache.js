$(document).ready(function(){
	// ----------------- DEFINICIÓN DE IDIOMA ----------------------
	// Recurso original:
	// http://reviblog.net/2014/01/07/jquery-ui-datepicker-poner-el-calendario-en-espanol-euskera-o-cualquier-otro-idioma/
	$.datepicker.regional['es'] = {
	  closeText: 'Cerrar',
	  prevText: '<Ant',
	  nextText: 'Sig>',
	  currentText: 'Hoy',
	  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	  weekHeader: 'Sm',
	  dateFormat: 'dd-mm-yy',
	  firstDay: 1,
	  isRTL: false,
	  showMonthAfterYear: false,
	  yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);

	Bache.init();
	$( "#fechaFin").datepicker();
	$( "#fechaFinReal").datepicker();
	url = $('#baseUrlBache').text();
	imgUrl = $('#imgUrl').text();
	imagenesBache = $('#imagenesBache').text();
	Bache.cargarImagenes(url, JSON.parse(imagenesBache));
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
			Bache.cambiarReparado();
		}
	});
	$("#enviarObservacion").click(function(){
		Bache.comentar();
	});
	$("#formularioComentario")[0].reset();
	setInterval("Bache.comentarios();",30000);
	/* Mis aportes....................*/
	Bacheo.init();
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
	console.log("estado");
	console.log(estado);
	var indice = parseInt(inArray(estado.tipoEstado, tiposEstado));
	if (estado.tipoEstado.nombre=="Reparado") {
		$($(".nav.nav-tabs.tabInfo").children()[1]).hide()
		return;
	}
	else
	{
		$('#cambiarEstado').text('Cambiar estado a: '+tiposEstado[indice+1].nombre);
	}
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
		/* No se muestran aquellos tipos de materiales que no poseen tipos de falla */
		if (materiales[elemento].fallas.length <= 0) {
			keysMateriales.splice(indice, 1);
			return;
		}
		var opcion = new Option(capitalize(materiales[elemento].nombre),materiales[elemento].id,true,true);
		$(opcion).click(function(){
			cargarTiposFalla(materiales[elemento].fallas);
		});
		$select.append(opcion);
	});
	$select.val(keysMateriales[0]);
	cargarTiposFalla(materiales[keysMateriales[0]].fallas);
}

/* cargarTiposFalla: Obtiene y completa la parte del formulario encargada de presentar los diferentes tipos
 * de falla registrados en el sistema																		*/
function cargarTiposFalla(fallas){
	var $opcionesFallas = $('#tipoFalla');
	$opcionesFallas.empty();
	$(fallas).each(function(indice,elemento){
		var opcion = new Option(capitalize(elemento.nombre),elemento.id,true,true);
	    $(opcion).click(function(){
	    	cargarOpcionesFalla(elemento.atributos,elemento.reparaciones,elemento.criticidades);
	    });
	    $opcionesFallas.append(opcion);
	});
	cargarOpcionesFalla(fallas[0].atributos,fallas[0].reparaciones, fallas[0].criticidades);
	$opcionesFallas.val(fallas[0].id);
}

function cargarOpcionesFalla (atributos,reparaciones, criticidades) {
	var $contenedorAtributos = $("#contenedorAtributosFalla");
	$contenedorAtributos.empty();
	$(atributos).each(function(indice,elemento){
		var $unDiv = $('<div/>');
		$unDiv.append($('<label class="control-label itemFormularioEstado">'+capitalize(elemento.nombre)+'</label>'));
		$unDiv.append($('<input type="number" propId="'+elemento.id+'" step="0.1" min="0" class="form-control selectFormulario itemFormularioEstado" required="" placeholder="0.5"/>'));
		$contenedorAtributos.append($unDiv);
	});
	$contenedorAtributos.append($('<label class="control-label itemFormularioEstado" for="tipoReparacion"> Tipo de Reparación</label>'));
	var $opcionesReparacion = $('<select id="tipoReparacion" name="tipoReparacion" class="form-control itemFormularioEstado"></select>');
	var opcion = new Option("No especificada",0,true,true);
	$opcionesReparacion.append(opcion);
	var keysReparaciones = Object.keys(reparaciones);
	$(keysReparaciones).each(function(indice,elemento){
		var opcion = new Option(capitalize(reparaciones[elemento].nombre),reparaciones[elemento].id,true,true);
		$opcionesReparacion.append(opcion);
	});
	$contenedorAtributos.append($opcionesReparacion);
	$opcionesReparacion.val(0);
	var $opcionesCriticidades = $('#criticidad');
	$opcionesCriticidades.empty();
	$(criticidades).each(function(indice, elemento){
		var opcion = new Option(capitalize(elemento.nombre), elemento.id, true, true);
		$opcionesCriticidades.append(opcion);
	});
	$opcionesCriticidades.val(criticidades[0].id);
}
