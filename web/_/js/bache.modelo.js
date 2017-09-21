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
		logueado= parseInt($("#logueado").text());
		latitud = parseFloat($("#latBache").text());
		longitud = parseFloat($("#longBache").text());
		var otroLat = latitud-0.0025;
	
		if (logueado) {
			estadoBache(estado,tiposEstado);
			$('#nombreEstado').append(estado.tipoEstado.nombre);
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
		var url = baseUrl+"publico/obtenerObservaciones/" + idBache;
		$.get(url, function( data ) {
			comentarios = JSON.parse(data);
			if (comentarios.length == 0 ) {
				return;
			}
			cargarComentarios(comentarios);
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
		$("#carousel-example-generic").hide();
		if(rutasImagenes.length >0){
			$("#carousel-example-generic").show();
			var $contenedor = $("#carousel");
			$contenedor.empty();
			var $indicadores = $("#carousel-indicators");
			$indicadores.empty();
			for (var i = 0; rutasImagenes.length > i; i++){
					$contenedor.append('<div class="item"><img class="scale" src="'+urlBase+rutasImagenes[i].nombreArchivo+'"></div>');
					$indicadores.append('<li data-target="#carousel-example-generic" data-slide-to="'+(i)+'"></li>');
					if(i==0){
						$($indicadores.children()[0]).addClass("active");
						$($contenedor.children()[0]).addClass("active");
					}
			};

		}
	}

	var redimensionarImg = function() {
		$(".scale").css({width: '15em', height: '15em'});
		$(".scale").imageScale({scale: 'fill', rescaleOnResize: true});
		return;
	}
	
	var cambiarEstado = function(nuevoEstado){
		var datos = {};
		datos.falla = {};
		datos.falla.id = idBache;
		datos.falla.factorArea = parseFloat($("#factorArea").val());
		datos.tipoFalla = {};
		datos.tipoFalla.id = parseInt($("#tipoFalla option:selected").val());
		if ($('#contenedorFormulario').find('textarea').val().length != 0) {
			datos.observacion = {}
			datos.observacion.comentario = $('#contenedorFormulario').find('textarea').val();
		}
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
		if (parseInt($("#tipoReparacion option:selected").val())!=0) {
			datos.reparacion = {};
			datos.reparacion.id = parseInt($("#tipoReparacion option:selected").val());
		}
		$(".modal").show();
		$.post(baseUrl+"index.php/inicio/cambiarEstadoBache",
			{'datos':JSON.stringify(datos)},
		 	function (data) {
				datos = JSON.parse(data);
				if (datos.codigo == 200) {
					setTimeout(3000);
					$(".modal").hide();
					window.location.reload();
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
		if ($('#contenedorFormulario').find('textarea').val().length != 0) {
			datos.estado.observacion = $('#contenedorFormulario').find('textarea').val();
		}
		tipoReparacionValor = parseInt($('#tipoReparacion').val());
		if (tipoReparacionValor == 0) {
			alertar("Error!","Debe ingresar un tipo de reparación!","error");
			return;
		}
		datos.falla.tipoReparacion = tipoReparacionValor;
		$('.modal').show();
		$.post(baseUrl+"inicio/cambiarEstadoBache",
			{'datos':JSON.stringify(datos)},
		 	function (data) {
				datos = JSON.parse(data);
				if (datos.codigo == 200) {
					$(".modal").hide();
					setTimeout(3000);
					window.location.reload();
					alertar("Exito!",datos.mensaje,"success");
				}else{
					$(".modal").hide();
					alertar("Error!",datos.mensaje,"error");
				}
		});
	}

	var cambiarReparado = function() {
		// Descripcion, montoReal, fechaFinReparacionReal
		var datos = {};
		datos.falla = {};
		datos.estado = {};
		datos.falla.id = idBache;
		if ($("#montoReal").val()==0 || $("#montoReal").val()=="" ) {
			alertar("Error!","Debe ingresar el monto real","error");
			return;
		}
		datos.estado.montoReal = parseFloat($("#montoReal").val());
		if ($("#fechaFinReal").val()=="") {
			alertar("Error!","Debe ingresar una fecha de finalización","error");
			return;
		}
		datos.estado.fechaFinReparacionReal = $("#fechaFinReal").val();
		if ($('#contenedorFormulario').find('textarea').length != 0) {
			datos.estado.observacion = $('#contenedorFormulario').find('textarea').val();
		}
		$(".modal").show();
		$.post(baseUrl+"inicio/cambiarEstadoBache",
			{'datos':JSON.stringify(datos)},
		 	function (data) {
				datos = JSON.parse(data);
				if (datos.codigo == 200) {
					$(".modal").hide();
					setTimeout(3000);
					window.location.reload();
					alertar("Exito!",datos.mensaje,"success");
				}else{
					$(".modal").hide();
					alertar("Error!",datos.mensaje,"error");
				}
		});
	}

	var cargarFormAEnReparacion = function() {
		$.post(baseUrl+"publico/get/Falla/"+idBache,function(data){
			var falla = JSON.parse(data).valor;
			fallas = GestorMateriales.tiposFalla;
			$select = $("#tipoReparacion");
			var opcion = new Option("No especificada",0,true,true);
			$select.append(opcion);
			var key = falla.tipoFalla.id;
			var keysReparaciones = [];
			var idTipoFalla = 0;
			for (var i = 0; i < fallas.length; i++) {
				if (fallas[i].id==key) {
					for (var j = 0; j < fallas[i].reparaciones.length; j++) {
						//console.log(fallas[i].reparaciones[j].id);
						keysReparaciones.push(fallas[i].reparaciones[j].id);
					}
					indexTipoFalla = i;
					break;
				}
			}
			$(keysReparaciones).each(function(indice,elemento){
				var opcion = new Option(capitalize(fallas[indexTipoFalla].reparaciones[indice].nombre),fallas[indexTipoFalla].reparaciones[indice].id,true,true);
				$select.append(opcion);
			});
			if (falla.tipoReparacion=='No espe')
				$select.val(0);
			else
				$select.val(falla.tipoReparacion.id);
			$select.val(falla.tipoReparacion.id);
		});
	}

	var cargarFormAReparado = function() {
		$.post(baseUrl+"publico/get/Falla/"+idBache,function(data){
			var falla = JSON.parse(data).valor;
			fallas = GestorMateriales.diccionarioTiposFalla;
			$select = $("#tipoReparacion");
			var opcion = new Option("No especificada",0,true,true);
			$select.append(opcion);
			key = falla.tipoFalla.nombre;
			var keysReparaciones = Object.keys(fallas[key].reparaciones);
			$(keysReparaciones).each(function(indice,elemento){
				var opcion = new Option(capitalize(fallas[key].reparaciones[indice].nombre),fallas[key].reparaciones[indice].id,true,true);
				$select.append(opcion);
			});
			$select.val(0);
		});
	}

	var cargarFormulario = function() {
		console.log(estado.tipoEstado.nombre);
		if (estado.tipoEstado.nombre=="Informado")
			cargarMateriales();
		if (estado.tipoEstado.nombre=="Confirmado")
			cargarFormAEnReparacion();
		if (estado.tipoEstado.nombre=="Reparando")
			cargarFormAReparado();
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
		cambiarReparado:cambiarReparado,
		cargarFormulario:cargarFormulario
	}
}());

// Ver donde poner lo que sigue.......
var GestorMateriales = (function(){
	var diccionarioMateriales = {};
	var tiposFalla = [];
	var diccionarioTiposFalla = {};
	var diccionarioTiposReparacion = {};
	
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

	var obtenerTiposFalla = function (idFallas,arregloTipos) {
		var tiposAPedir = [];
		if(idFallas == undefined){
			return tiposFalla;
		}
		idFallas.map(function(k,v){
			if (tiposFalla.length==0) {
				tiposAPedir.push(k);
			}
			$(tiposFalla).each(function (index) {
				if (tiposFalla[index].id == k)
					arregloTipos.push(tiposFalla[index]);
				else
					tiposAPedir.push(k);
			});
		});
		if (tiposAPedir.length==0 || tiposAPedir.length==undefined) {
			return;
		}
		baseUrl = $("#baseUrlBache").text();
		$.post(baseUrl+"index.php/publico/getTiposFallasPorIDs",{"idTipos":JSON.stringify(tiposAPedir)}, function(data){
			var datos = JSON.parse(data);
			var tipos = JSON.parse(datos.valor);
			$(tipos).each(function(indice,elemento){
				var unTipoFalla = new TipoFalla(elemento);
				tiposFalla.push(unTipoFalla);
    			arregloTipos.push(unTipoFalla);
    		});
		});
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
		if (tiposAPedir.length==0 || tiposAPedir.length==undefined) {
			return;
		}
		baseUrl = $("#baseUrlBache").text();
		$.post(baseUrl+"index.php/publico/getTiposFallasPorIDs",{"idTipos":JSON.stringify(tiposAPedir)}, function(data){
			var datos = JSON.parse(data);
			var tipos = JSON.parse(datos.valor);
			$(tipos).each(function(indice,elemento){
				var unTipoFalla = new TipoFalla(elemento);
				diccionarioTiposFalla[elemento.nombre] = unTipoFalla;
    			arregloTipos.push(unTipoFalla);
    		});
		});
	};

	return{
		agregarMaterial:agregarMaterial,
		diccionarioTiposFalla:diccionarioTiposFalla,
		materiales:diccionarioMateriales,
		obtenerArregloMateriales:obtenerArregloMateriales,
		obtenerFallas:obtenerFallas,
		obtenerTiposFalla:obtenerTiposFalla,
		tiposFalla:tiposFalla,
		obtenerReparaciones:obtenerReparaciones
	}
}());


var TipoFalla = function(datos){
		this.id = datos.id;
		this.nombre = datos.nombre;
		this.influencia = datos.influencia;
		this.atributos = [];
		this.reparaciones = [];
		this.multimedia = null;
		var _this = this;

		//console.log(datos);
		GestorMateriales.obtenerReparaciones(datos.reparaciones,_this.reparaciones);

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
		//console.log(datos);
		var _this = this;
		return this;
	};

var Material = function(datos){
		this.id = datos.id;
		this.nombre = datos.nombre;
		this.fallas = [];
		this.tiposFallas = [];
		//console.log(datos);
		if (datos.codigo!=400)
		{
			GestorMateriales.obtenerFallas(datos.fallas,this.fallas);
			GestorMateriales.obtenerTiposFalla(datos.fallas,this.tiposFallas);
		}
		return this;
	};

var Bacheo = (function(){
function obtenerMateriales() {
		baseUrl = $("#baseUrlBache").text();
		$.get( baseUrl+"/index.php/publico/getAlly/TipoMaterial", function(data) {
			var datos = JSON.parse(data);
			if(datos.codigo ==200){
				$(JSON.parse(datos.valor)).each(function(indice,elemento){
	    			GestorMateriales.agregarMaterial(elemento);
	    		});
			}else{
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
