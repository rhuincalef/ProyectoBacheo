$(document).ready(function(){
	Bache.init();

	Bache.redimensionarImg();

	Bache.comentarios();
   // obtenerComentarios();
    $("#botonTwitter").click(function(){
    	Bache.comentarTwitter();
    });
    $("#registrarEstadoBache").click(function(evento){
		evento.preventDefault();
		Bache.cambiarEstado();
	});
});


function obtenerComentarios() {
	//var comentarios = Bache.comentarios();
	//cargarComentarios(JSON.parse(comentarios));
}

	
function cargarComentarios(comentarios) {
	$comentarios = $('<div id="comentarios" class="divComentarios"></div>');
	$("#observaciones").append($comentarios);
	$comentarios.append("");
	for (var i = 0; i < comentarios.length; i++) {
		var $comentarioUsuario = $('<div/>');
		$comentarioUsuario.addClass("comentarioUsuario")
		var $avatar= $('<div/>');
		$avatar.addClass("avatar");
		var $comentario = $('<div/>');
		$comentario.addClass("comentarioIndividual");
		$avatar.append(comentarios[i].usuario+" ("+comentarios[i].fecha+") Dice:");
		$comentario.append(comentarios[i].texto);
		$comentarioUsuario.append($avatar);
		$comentarioUsuario.append($comentario);
		$comentarios.append($comentarioUsuario);
	};	
}


function estadoBache(estado, tiposEstado){
	var indice = parseInt(estado[estado.length-1].idTipoEstado)-1;
	$("#nombreEstado").text("Estado del Bache: "+tiposEstado[indice].nombre);
	$("#contenedorControladorEstado").append('<div id="slider" class="controlEstado"></div>');
	$( "#slider" ).slider({
		value:parseInt(indice),
		min: 0,
		max: tiposEstado.length-1,
		step: 1,
		slide: function( event, ui ) {
			$("#nombreEstado").empty();
			$("#nombreEstado").text("Estado del Bache: "+tiposEstado[ui.value].nombre);
			cargarFormularioTecnico(ui.value);
		}
	});
}


function cargarFormularioTecnico (estado) {
	var $form = $("#formularioEspecificacionesTecnicas");
	// $form.empty();
 // 	switch(estado){
	// 	case 1:
	// 		$form.append($('<label class="control-label col-sm-2" for="material"> Material</label><select class="form-control selectFormulario" type="text" id="material" name="material"> <option value="0" selected="selected">Pavimento</option>   <option value="1">Asfalto</option>   <option value="2">Adoquin</option></select>'));
	// 		$form.append($('<br><input id="numeroBaldosa" class="form-control" type="text" placeholder="Baldosa" name="baldosa"/>'));
	// 		$form.append($('<label class="control-label col-sm-2" for="rotura"> Rotura</label><select class="form-control selectFormulario" type="text" id="tipoRotura" name="tipoRotura"> <option value="0" selected="selected">Esquina</option>   <option value="1">Asfalto</option>   <option value="2">Adoquin</option></select>'));
	// 		$form.append($('<br><input id="ancho" class="form-control" type="text" placeholder="Ancho" name="ancho"/>'));
	// 		$form.append($('<br><input id="largo" class="form-control" type="text" placeholder="Largo" name="largo"/>'));
	// 		$form.append($('<br><input id="profundidad" class="form-control" type="text" placeholder="Profundidad" name="profundidad"/>'));
 // 			$form.append($('<label class="control-label col-sm-2" for="criticidad"> Criticidad</label><select class="form-control selectFormulario" type="text" id="criticidad" name="criticidad"> <option value="0" selected="selected">Baja</option>'));
 // 			break;
	// 	case 2:
	// 		$form.append($('<label for="Ancho"> Ancho</label><input id="Ancho"/>'));
	// 		$form.append($('<br><label for="Largo"> Largo</label><input id="Largo"/>'));
	// 		$form.append($('<br><label for="Profundidad"> Profundidad</label><input id="Profundidad"/>'));
	// 		break;
		
	// 	default:
	// 		break;
	// }

	$("#contenedorFormulario").show();
	$("#contenedorEstado1").show();
	
}