Bache = (function () {
		this.idBache = 61;
		var latitud = 0;
		var longitud = 0;
	var init = function (){
		this.idBache = parseFloat($("#idBache").text());
		latitud = parseFloat($("#latBache").text());
		longitud = parseFloat($("#longBache").text());
		//base = $("#baseUrl").text();
		var otroLat = latitud-0.0025;
		var latlon = new google.maps.LatLng(latitud, longitud);
		var latLongCenter = new google.maps.LatLng(otroLat, longitud);
		var mapOptions = {
		          center: latLongCenter,
		          zoom: 16,
		          mapTypeControl: false,
		          mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
		var mapa = new google.maps.Map(document.getElementById("canvasMapa"),mapOptions);
		var marcador = new google.maps.Marker({
			position: latlon,
			map: mapa,
			title: "Bache "+ idBache
	  });
//		mapa.setCenter(latLongCenter);
	}
	
	function comentarTwitter () {
		window.open("http://twitter.com/share?via=proyBacheoTw&hashtags=Bache"+this.idBache+"&text=este texto");
	}

	var comentarios = function() {
		$.get("http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/obtenerObservaciones/"+this.idBache, function( data ) {
			cargarComentarios(JSON.parse(data));
			//return data;	
		});
		//return '[{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"}]';
	}


	cargarImagenes = function(urlBase,rutasImagenes) {
		if(rutasImagenes.length >0){
			var $contenedor = $("#carousel");
			$contenedor.empty();
			var $indicadores = $("#carousel-indicators");
			$indicadores.empty();
			for (var i = 0; rutasImagenes.length > i; i++) {
					$contenedor.append('<div class="item"><img src="'+urlBase+rutasImagenes[i]+'" width="325px"  alt=""></div>');
					$indicadores.append('<li data-target="#carousel-example-generic" data-slide-to="'+(i)+'"></li>');
					if(i==0){
						$($indicadores.children()[0]).addClass("active");
						$($contenedor.children()[0]).addClass("active");
					}
			};
		}
	}
	
	return{
		init:init,
		comentarios:comentarios,
		cargarImagenes:cargarImagenes,
		comentarTwitter:comentarTwitter 
	}
}());