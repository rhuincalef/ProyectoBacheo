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


	cargarImagenes = function(urlBase,rutasImagenes) {
		var $contenedor = $("#carousel");
		$contenedor.empty();
		var $indicadores = $("#carousel-indicators");
		$indicadores.empty();
		for (var i = 0; rutasImagenes.length > i; i++) {
				$contenedor.append('<div class="item"><img src="'+urlBase+rutasImagenes[i]+'" width="325px"  alt=""></div>');
				$indicadores.append('<li data-target="#carousel-example-generic" data-slide-to="'+(i)+'"></li>');
				if(i==0)
					$($indicadores.children()[0]).addClass("active");
		};
	}
	
	return{
		init:init,
		comentarios:comentarios,
		cargarImagenes:cargarImagenes
	}
}());