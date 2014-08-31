Bache = (function () {
	var init = function (argument){
		var idBache = parseFloat($("#idBache").text());
		var latitud = parseFloat($("#latBache").text());
		var longitud = parseFloat($("#longBache").text());
		var mapOptions = {
		          center: new google.maps.LatLng(latitud, longitud),
		          zoom: 16,
		          mapTypeControl: false,
		          mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
		var mapa = new google.maps.Map(document.getElementById("canvasMapa"),mapOptions);
		var posicion = new google.maps.LatLng(latitud,longitud);
		var marcador = new google.maps.Marker({
			position: posicion,
			map: mapa,
			title: "Bache "+ idBache
	  });
	}

	var comentarios = function() {
		return '[{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"}]';
	}
	
	return{
		init:init,
		comentarios:comentarios
	}
}());