$(document).ready(function(){
	Bache.init();
	Bache.redimensionarImg();
    obtenerComentarios();
    $("#botonTwitter").click(function(){
    	comentarTwitter();
    });
});

function comentarTwitter (argument) {

	window.open("http://twitter.com/share&text=probando algo de tiwtteerr");
}

function obtenerComentarios() {
//	comentarios= '[{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"}]';
	var comentarios = Bache.comentarios();
	cargarComentarios(JSON.parse(comentarios));
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
		$comentario.append(comentarios[i].comentario);
		$comentarioUsuario.append($avatar);
		$comentarioUsuario.append($comentario);
		$comentarios.append($comentarioUsuario);
	};	
}