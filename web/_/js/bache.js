$(document).ready(function(){
	var mapOptions = {
          center: new google.maps.LatLng(-43.253432, -65.310137),
          zoom: 16,
          mapTypeControl: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    var map = new google.maps.Map(document.getElementById("canvasMapa"),mapOptions);

    obtenerComentarios();
});



function obtenerComentarios() {
	// body...
	comentarios= '[{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"}]';
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