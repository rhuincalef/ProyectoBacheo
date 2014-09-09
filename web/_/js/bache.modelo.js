Bache = (function () {
		var idBache = 0;
		var latitud = 0;
		var longitud = 0;
		var logueado = 0;
		var baseUrl = "";
		var estado = {};
		var tiposEstado = {};

	var init = function (){
		estado = JSON.parse($("#estadoBache").text());
		tiposEstado = JSON.parse($("#tiposEstadoBache").text());
		idBache = parseFloat($("#idBache").text());
		latitud = parseFloat($("#latBache").text());
		longitud = parseFloat($("#longBache").text());
		baseUrl = $("#baseUrl").text();

		logueado= parseInt($("#logueado").text());
		latitud = parseFloat($("#latBache").text());
		longitud = parseFloat($("#longBache").text());

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

		if (logueado) {estadoBache(estado,tiposEstado);};

		var indice = parseInt(estado[estado.length-1].idTipoEstado)-1;
		$("#campoEstadoBache").text(tiposEstado[indice].nombre);
		$("#campoFechaEstado").text(estado[estado.length-1].fecha);
	}
	
	var comentarTwitter = function () {
		window.open("http://twitter.com/share?via=proyBacheoTw&hashtags=Bache"+idBache+"&text=este texto");
	}

	var comentarios = function() {
		var url = baseUrl + "index.php/inicio/obtenerObservaciones/" + idBache;
		$.get(url, function( data ) {
		//$.get("http://localhost/proyectoBacheo/index.php/inicio/obtenerObservaciones/"+this.idBache, function( data ) {
				cargarComentarios(JSON.parse(data));
			//return '[{"comentario":"una basura este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"},{"comentario":"una cagada este bache", "usuario":"Doe","fecha":"11/12/1980"}]';
		});
	}


	var cargarImagenes = function(urlBase,rutasImagenes) {
		if(rutasImagenes.length >0){
			var $contenedor = $("#carousel");
			$contenedor.empty();
			var $indicadores = $("#carousel-indicators");
			$indicadores.empty();
			for (var i = 0; rutasImagenes.length > i; i++){
					$contenedor.append('<div class="item"><img src="'+urlBase+rutasImagenes[i]+'"></div>');
					$indicadores.append('<li data-target="#carousel-example-generic" data-slide-to="'+(i)+'"></li>');
					if(i==0){
						$($indicadores.children()[0]).addClass("active");
						$($contenedor.children()[0]).addClass("active");
					}
			};

			$('.item').each(function (i, e) {
				// body...
				$(e).css({'background-color':'gray'});
			});
		}
	}

	var redimensionarImg = function() {
//		325 x 244
	var $img = $('.item img');
	$img.each(function (i, e) {
//alert("1");
		if(e.width > e.height)
		{
			var temporal = e.width / e.height;
			e.width = 325;
			// $(e).css({'width':'325px'});
			e.height = 325 / temporal;
			temporal = 325 / temporal;
			// $(e).css({'height':temporal});
			temporal = (244 - e.height) / 2;
//			$(e).css({'marginTop':temporal+'px', 'marginBottom':temporal+'px'});
			temporal = temporal+'px';
//			$(e).css({'marginBottom':temporal});

var $divPadre = $(e).parent();
$divPadre.css({'marginBottom':temporal});
$divPadre.css({"paddingTop":temporal});	

		}else{
			var temporal = e.height / e.width;
			$(e).css({'height':'244px'});
			$(e).css({'width': 244/temporal});
			temporal = (325 - e.width) / 2;
			$(e).css({'marginRight':temporal+'px', 'marginLeft':temporal+'px'});
		}
	});
	}
	
	return{
		init:init,
		comentarios:comentarios,
		cargarImagenes:cargarImagenes,
		redimensionarImg: redimensionarImg,
		comentarTwitter:comentarTwitter
	}
}());