Bache = (function () {
		var idBache = 0;
		var latitud = 0;
		var longitud = 0;
		var logueado = 0;
		var baseUrl = "";
		var estado = {};
		var tiposEstado = {};
		var monto = 0;

	var init = function (){
		estado = JSON.parse($("#estadoBache").text());
		tiposEstado = JSON.parse($("#tiposEstadoBache").text());
		idBache = parseFloat($("#idBache").text());
		latitud = parseFloat($("#latBache").text());
		longitud = parseFloat($("#longBache").text());
		baseUrl = $("#baseUrlBache").text();
		console.log(baseUrl);

		logueado= parseInt($("#logueado").text());
		latitud = parseFloat($("#latBache").text());
		longitud = parseFloat($("#longBache").text());

		var otroLat = latitud-0.0025;
	
		if (logueado) {
			estadoBache(estado,tiposEstado);
		};

		if (typeof google != 'undefined')
		{
			var latlon = new google.maps.LatLng(latitud, longitud);
			var latLongCenter = new google.maps.LatLng(otroLat, longitud);
			var mapOptions = {
			          //center: latLongCenter,
			          center: latlon,
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
		}


	}
	
	var comentarTwitter = function () {
		var comentario = $("#comentarioObservador").val();
		window.open("http://twitter.com/share?via=proyBacheoTw&hashtags=Bache"+idBache+"&text="+comentario);
	}

	
	var comentarios = function() {
		var url = baseUrl+"index.php/obtenerObservaciones/" + idBache;
		$.get(url, function( data ) {
				cargarComentarios(JSON.parse(data));
		});
	}

	var comentar = function() {
		var datos = {};
		datos.idBache = idBache;
		datos.nombreObservador = $("#nombreObservador").val();
		datos.comentario = $("#comentarioObservador").val();
		if (datos.comentario==""){
			alertar("Error","Debe ingresar un comentario","error");
			return;
		}
		datos.emailObservador = $("#emailObservador").val();
		$.post(baseUrl+"index.php/asociarObservacion",{idBache:datos.idBache, nombreObservador: datos.nombreObservador, comentario:datos.comentario, emailObservador: datos.emailObservador}, function (data) {
			$("#formularioComentario")[0].reset();
			alertar("Exito!","Su comentario ha sido enviado","success");
			comentarios();
		});
	}
	var cargarImagenes = function(urlBase,rutasImagenes) {
		if(rutasImagenes.length >0){
			var $contenedor = $("#carousel");
			$contenedor.empty();
			var $indicadores = $("#carousel-indicators");
			$indicadores.empty();
			for (var i = 0; rutasImagenes.length > i; i++){
					$contenedor.append('<div class="item"><img src="'+urlBase+rutasImagenes[i].nombreArchivo+'"></div>');
					$indicadores.append('<li data-target="#carousel-example-generic" data-slide-to="'+(i)+'"></li>');
					if(i==0){
						$($indicadores.children()[0]).addClass("active");
						$($contenedor.children()[0]).addClass("active");
					}
			};

		}
	}

	var redimensionarImg = function() {
	//		325 x 244
		var $img = $('.item img');
		$img.each(function (i, e) {
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

			}else{
				var temporal = e.height / e.width;
				$(e).css({'height':'244px'});
				$(e).css({'width': 244/temporal});
				temporal = (325 - e.width) / 2;
				$(e).css({'marginRight':temporal+'px', 'marginLeft':temporal+'px'});
			}
		});
	}
	
	var cambiarEstado = function(nuevoEstado){
		var datos = {};
		datos.falla = {};
		datos.falla.id = idBache;
		datos.falla.factorArea = parseFloat($("#factorArea").val());
		datos.tipoFalla = {};
		datos.tipoFalla.id = parseInt($("#tipoFalla option:selected").val());
		datos.observacion = {}
		datos.observacion.comentario = $('#contenedorFormulario textarea').val();
		datos.fecha = $("#fechaFin").val();
		datos.monto = $("#montoEstimado").val();

		/* Mis aportes............*/
		// Se envia id material por si se lo desea cambiar
		datos.material = {};
		datos.material.id = parseInt($("#material option:selected").val());
		datos.criticidad = {};
		datos.criticidad.id = parseInt($("#criticidad").val());
		// Por cada atributo
		datos.atributos = [];
		inputsAtributos = $("#contenedorAtributosFalla input");
		inputsAtributos.each(function(indice,elemento) {
			atributo = {};
			atributo.id = parseInt(elemento.attributes.propid.value);
			atributo.valor = parseFloat(elemento.value);
			datos.atributos.push(atributo);
		});
		datos.reparacion = {};
		datos.reparacion.id = parseInt($("#tipoReparacion option:selected").val());
		$.post(baseUrl+"index.php/inicio/cambiarEstadoBache",
			{'datos':JSON.stringify(datos)},
		 	function (data) {
				datos = JSON.parse(data);
				if (datos.codigo == 200) {
					alertar("Exito!",datos.mensaje,"success");
				}else{
					alertar("Error!",datos.mensaje,"error");
				}
		});

	}

	var cambiarReparando = function()
	{
		var datos = {};
		datos.falla = {};
		datos.falla.id = idBache;
		// montoEstimado, fechaFin
		datos.estado = {};
		datos.estado.montoEstimado = parseFloat($("#montoEstimado").val());
		datos.estado.fechaFinReparacionEstimada = $("#fechaFin").val();
		//datos.estado.observacion = $("#contenedorFormulario").find("textarea").val();
		console.log(datos);
		$.post(baseUrl+"inicio/cambiarEstadoBache",
			{'datos':JSON.stringify(datos)},
		 	function (data) {
				datos = JSON.parse(data);
				if (datos.codigo == 200) {
					alertar("Exito!",datos.mensaje,"success");
					setTimeout(3000);
					//window.location.reload();
				}else{
					alertar("Error!",datos.mensaje,"error");
				}
		});
	}

	var cambiarReparado = function() {
		// Descripcion, montoReal, fechaFinReparacionReal
		var datos = {};
		datos.falla = {};
		datos.falla.id = idBache;
	}

	return{
		init:init,
		comentarios:comentarios,
		comentar:comentar,
		cargarImagenes:cargarImagenes,
		redimensionarImg: redimensionarImg,
		comentarTwitter:comentarTwitter,
		cambiarEstado:cambiarEstado,
		cambiarReparando:cambiarReparando,
		cambiarReparado:cambiarReparado
	}
}());

// Ver donde poner lo que sigue.......
var GestorMateriales = (function(){
	var diccionarioMateriales = {};
	var diccionarioTiposFalla = {};
	var diccionarioTiposReparacion = {};
/*	var diccionarioCriticidades = {};*/
	
	var agregarMaterial = function(datos){
		if(diccionarioMateriales.hasOwnProperty(datos.id))
			return diccionarioMateriales[datos.id];
		diccionarioMateriales[datos.id] = new Material(datos);
	};

	var obtenerReparaciones = function(idReparaciones,arregloReparaciones){
		var reparacionesAPedir = [];
		idReparaciones.map(function(k,v){
			if(diccionarioTiposReparacion.hasOwnProperty(k))
				arregloReparaciones.push(diccionarioTiposReparacion[k]);
			else
				reparacionesAPedir.push(k);
		});
		if (reparacionesAPedir.length==0) {
			return;
		}
		baseUrl = $("#baseUrlBache").text();
		$.post(baseUrl+"index.php/publico/getReparacionesPorIDs",{"idReparaciones":JSON.stringify(reparacionesAPedir)},function(data){
			var reparaciones = JSON.parse(data).valor;
			$(JSON.parse(reparaciones)).each(function(indice,elemento){
				var unaReparacion = new TipoReparacion(elemento);
				diccionarioTiposReparacion[elemento.id] = unaReparacion;
    			arregloReparaciones.push(unaReparacion);
    		});
		});
	};

	var obtenerArregloMateriales = function(){
		return diccionarioMateriales;
	};


	var obtenerFallas = function(idFallas,arregloTipos){
		var tiposAPedir = [];
		if(idFallas == undefined){
			return diccionarioTiposFalla;
		}
		idFallas.map(function(k,v){
			if(diccionarioTiposFalla.hasOwnProperty(k))
				arregloTipos.push(diccionarioTiposFalla[k]);
			else
				tiposAPedir.push(k);
		});
		if (tiposAPedir.length==0) {
			return;
		}
		baseUrl = $("#baseUrlBache").text();
		$.post(baseUrl+"index.php/publico/getTiposFallasPorIDs",{"idTipos":JSON.stringify(tiposAPedir)}, function(data){
			var datos = JSON.parse(data);
			var tipos = JSON.parse(datos.valor);
			$(tipos).each(function(indice,elemento){
				var unTipoFalla = new TipoFalla(elemento);
				diccionarioTiposFalla[elemento.id] = unTipoFalla;
    			arregloTipos.push(unTipoFalla);
    		});
		});
	};

/*
	var obtenerCriticidades = function(idCriticidades,arregloCriticidades){
		var criticidadesAPedir = [];
		if (idCriticidades == undefined) {
			return diccionarioCriticidades;
		};
		idCriticidades.map(function(k,v){
			if(diccionarioCriticidades.hasOwnProperty(k))
				arregloCriticidades.push(diccionarioCriticidades[k]);
			else
				criticidadesAPedir.push(k);
		});
		if (criticidadesAPedir.length==0) {
			return;
		}
		baseUrl = $("#baseUrlBache").text();
		$.post(baseUrl+"index.php/publico/getCriticidadesPorIDs",{"arregloIDsCriticidades":JSON.stringify(criticidadesAPedir)}, function(data){
			var datos = JSON.parse(data);
			var tipos = JSON.parse(datos.valor);
			$(tipos).each(function(indice,elemento){
				criticidad = {"id":elemento.id, "nombre":elemento.nombre, "descripcion":elemento.descripcion};
				diccionarioCriticidades[criticidad.id] = criticidad;
				arregloCriticidades.push(criticidad);
    		});
		});
	};
*/
	return{
		agregarMaterial:agregarMaterial,
		diccionarioTiposFalla:diccionarioTiposFalla,
		materiales:diccionarioMateriales,
		obtenerArregloMateriales:obtenerArregloMateriales,
		obtenerFallas:obtenerFallas,
		//obtenerCriticidades:obtenerCriticidades,
		obtenerReparaciones:obtenerReparaciones
	}
}());


var TipoFalla = function(datos){
		this.id = datos.id;
		this.nombre = datos.nombre;
		this.influencia = datos.influencia;
		this.atributos = [];
		// this.criticidades = datos.criticidades;
		//this.criticidades = [];
		this.reparaciones = [];
		this.multimedia = null;
		var _this = this;

		console.log(datos);
		GestorMateriales.obtenerReparaciones(datos.reparaciones,_this.reparaciones);
		//GestorMateriales.obtenerCriticidades(datos.criticidades,_this.criticidades);

		baseUrl = $("#baseUrlBache").text();
		$.post(baseUrl+"publico/getTiposAtributo", {"idTipos":JSON.stringify(datos.atributos)}, function(data) {
			var datos = JSON.parse(data);
			if(datos.codigo == 200){
				var attr = JSON.parse(datos.valor);
				$(attr).each(function(indice,elemento){
	    			_this.atributos.push({"id":elemento.id,"nombre":elemento.nombre});
	    		});
			}
		});
		this.getMultimedia = function(){
			if(this.multimedia != null)
				return this.multimedia;
			baseUrl = $("#baseUrlBache").text();
			$.get(baseUrl+"index.php/publico/getMultimediaTipoFalla/"+_this.id, function(data) {
				var datos = JSON.parse(data);
				$(datos).each(function(indice,elemento){
	    			_this.multimedia = elemento.multimedia;
	    			return _this.multimedia;
	    		});
			});
		};

		return this;
	};

var TipoReparacion = function(datos){
		this.id = datos.id;
		this.nombre = datos.nombre;
		this.descripcion = datos.descripcion;
		this.costo = datos.costo;
		console.log(datos);
		var _this = this;
		return this;
	};

var Material = function(datos){
		this.id = datos.id;
		this.nombre = datos.nombre;
		this.fallas = [];
		console.log(datos);
		if (datos.codigo!=400)
			GestorMateriales.obtenerFallas(datos.fallas,this.fallas);
		return this;
	};

var Bacheo = (function(){
function obtenerMateriales() {
		baseUrl = $("#baseUrlBache").text();
		$.get( baseUrl+"/index.php/publico/getAlly/TipoMaterial", function(data) {
			console.log(data);
			var datos = JSON.parse(data);
			if(datos.codigo ==200){
				$(JSON.parse(datos.valor)).each(function(indice,elemento){
	    			GestorMateriales.agregarMaterial(elemento);
	    		});
				console.log(datos.mensaje);
			}else{
				console.log("Nada que mostrar");
				alert(datos.mensaje);
			}
		});
	}

var inicializar = function(){
		obtenerMateriales();
	};

return{
	init:inicializar
}
}());