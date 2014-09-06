$(document).ready(function(){
	Bache.init();

	Bache.redimensionarImg();

	Bache.comentarios();
   // obtenerComentarios();
    $("#botonTwitter").click(function(){
    	Bache.comentarTwitter();
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