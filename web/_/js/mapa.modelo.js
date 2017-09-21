var GestorMateriales = (function(){
	var diccionarioMateriales = {};
	var diccionarioTiposFalla = {};
	var diccionarioTiposReparacion = {};
	
	var agregarMaterial = function(datos) {
		if(diccionarioMateriales.hasOwnProperty(datos.id))
			return diccionarioMateriales[datos.id];
		diccionarioMateriales[datos.id] = new Material(datos);
	};

	var obtenerReparaciones = function(idReparaciones,arregloReparaciones) {
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
		$.post("index.php/publico/getReparacionesPorIDs",{"idReparaciones":JSON.stringify(reparacionesAPedir)},function(data){
			var reparaciones = JSON.parse(data).valor;
			$(JSON.parse(reparaciones)).each(function(indice,elemento){
				var unaReparacion = new TipoReparacion(elemento);
				diccionarioTiposReparacion[elemento.id] = unaReparacion;
    			arregloReparaciones.push(unaReparacion);
    		});
		});
	};

	var obtenerArregloMateriales = function() {
		return diccionarioMateriales;
	};

	var obtenerFallas = function(idFallas,arregloTipos) {
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
		$.post("index.php/publico/getTiposFallasPorIDs",{"idTipos":JSON.stringify(tiposAPedir)}, function(data){
			var datos = JSON.parse(data);
			var tipos = JSON.parse(datos.valor);
			$(tipos).each(function(indice,elemento){
				var unTipoFalla = new TipoFalla(elemento);
				diccionarioTiposFalla[elemento.id] = unTipoFalla;
    			arregloTipos.push(unTipoFalla);
    		});
		});

	};

	return {
		agregarMaterial:agregarMaterial,
		diccionarioTiposFalla:diccionarioTiposFalla,
		materiales:diccionarioMateriales,
		obtenerArregloMateriales:obtenerArregloMateriales,
		obtenerFallas:obtenerFallas,
		obtenerReparaciones:obtenerReparaciones
	}
}());

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
	var materiales = [];
	var criticidadImagen = [];
	var marcadores = [];
	var marcadoresVisualizados = [];
	var marcadoresReparados = [];
	var cluster;
	var arrayCluster = [];

	if (typeof google != 'undefined')
	{
		var geocoder = new google.maps.Geocoder();
	}

/* Marcador: Objeto que representa la información básica del bache a mostrar en la páguina principal,
 * Es creado cuando desde el servidor se indica que el bache fue agregado de manera correcta, o al
 * obtener los datos del servidor (carga inicial)														*/
	Marcador = function(datos, mapa) {
		this.id = datos.id;
		this.criticidad = datos.criticidad;
		this.estado = datos.estado;
		this.posicion = datos.posicion;
		console.log(datos);
		console.log("datos.estado");
		console.log(typeof(datos.estado));
		switch(datos.estado) {
			case "Informado":
				var icono = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" ;
				break;
			case "Confirmado":
				var icono = "http://maps.google.com/mapfiles/ms/icons/red-dot.png" ;
				break;
			case "Reparando":
				var icono = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png" ;
				break;
			case "Reparado":
				var icono = "http://maps.google.com/mapfiles/ms/icons/green-dot.png" ;
				break;
			default:
				console.log("No se encuentra el estado de la falla a visualizar!!!");
		}
		this.icono = icono
		if (this.estado!="Reparado") {
			this.agregarAMapa(mapa);
		}
		return this;
	}

	Marcador.prototype.agregarAMapa = function (mapa) {
		var marcador = new google.maps.Marker({
			position: this.posicion,
			map: mapa,
			title: this.titulo,
			animation: google.maps.Animation.DROP,
			icon: this.icono
		});
		marcador.id = this.id;
		this.marker = marcador;
		google.maps.event.addListener(marcador,"click", function(){
			window.open("index.php/inicio/getBache/id/"+marcador.id);
		});
	}


/* guardarBache: Funcion encargada de obtener los datos del formulario y desencadenar el guardado de un
 * nuevo Bache 																							*/
	var guardarBache = function(datos) {
		guardarMarcador(datos);
	}

/* cargarMarcador: Funcion en encargada de cargar un marcador para ser visualizado en el mapa.
 * Es utilizada por la carga inicial, al obtener los datos desde el servidor							*/
	var cargarMarcador = function(datos) {
		var $mapa = $("#canvasMapa").gmap3("get");
		var marcador = new Marcador(datos,$mapa);
		if (datos.estado != "Reparado") {
			marcadores.push(marcador);
			cluster.addMarker(marcador.marker,true);
			return;
		}
		marcadoresReparados.push(marcador);
		return;
	}

	function guardarImagenes(idBache) {
		var direccion = "subirImagen/"+idBache;
		Bacheo.myDropzone.options.url = "subirImagen/"+idBache;
        console.log("Se inicializó el formulario con el script de carga de imágenes.");
		Bacheo.myDropzone.processQueue();
	}

	function datosValidos (calle, altura, descripcion) {
		var patron = /(\w+)\s*(\w+)/;
		if (!patron.exec(calle)){
			alertar("Oups!","El parametro del campo 'Titulo' contiene errores","error");
			return false;
		};
		patron =  /^(?:\+|-)?\d+$/;
		if (!patron.exec(altura)){
			alertar("Oups!","El parámetro del campo 'Altura' contiene errores","error");
			return false;
		};
		return true;
	}

/* guardarMarcador: Funcion llamada desde "guardarBache", efectua la llamada al servidor para realizar
 * dicha accion, obteniendo las coordenadas reales de la dirección especificada y, de resultar efectiva
 * la carga del nuevo bache en el servidor, realiza la renderizacion del mismo para ser visualizado en
 * el mapa 																								*/
//	var guardarMarcador = function(calle,altura,descripcion,objetoFalla){
	var guardarMarcador = function(datosFalla){
		var datos={};
		if (!datosValidos(datosFalla.direccion.callePrincipal, datosFalla.direccion.altura))
			return;
		obtenerLatLng(datosFalla.direccion.callePrincipal,datosFalla.direccion.altura,function (posicion){
			datosFalla.falla.latitud = posicion.lat();
			datosFalla.falla.longitud = posicion.lng();
			datos.posicion = posicion;
    		$.post('crear/Falla',
	            {"datos": JSON.stringify(datosFalla)},
	            function(data) {
	                var respuestaServidor = $.parseJSON(data);
	                if(respuestaServidor.codigo == 200){
	                	datos = $.parseJSON(respuestaServidor.valor);
	                	datos.posicion = new google.maps.LatLng(parseFloat(datos.latitud),parseFloat(datos.longitud));
	    				cargarMarcador(datos);
	    				guardarImagenes(datos.id);
						alertar("Exito!","Bache notificado con exito","success");
						$("#formularioBache")[0].reset();

	    			}else{
						alertar("la Pucha!","No fue posible informar el bache","error");
	    			}
	            }
          	);
		});
	}

/* obtenerLatLng: obtiene, dados una calle y altura, las coordenadas de dicha direccion 				*/
	function obtenerLatLng (calle,altura,callback) {
		var calle = calle+" "+altura;
		var direccion = calle+", Trelew, Chubut Province, Argentina	";
		geocoder.geocode( { 'address': direccion }, function(results1, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				callback(results1[0].geometry.location);
			} else {
					alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}

/* obtenerCalle: obtiene, dada una coordenada, la calle mas cercana a la que puede pertenecer, y el
 * rango de numeros en que dicha coordenada puede encontrarse y coloca dichos valores en las
 * variables "calle" y "altura", que corresponden a los inputs de igual nombre del formulario			*/
	function obtenerCalle(latlng,calle,altura) {
		geocoder.geocode({'latLng': latlng}, function(results, status) {
		    if (status == google.maps.GeocoderStatus.OK) {
		    	console.log(results[0]);
		    	if (results[1]){
		    		if(results[0].address_components.length ==6){
		    			calle.value = results[0].address_components[1].long_name;
		    			altura.placeholder= results[0].address_components[0].long_name;              
		    		}else{
		    			calle.value = results[0].address_components[0].long_name;
		    			altura.placeholder = "---";
		    		}
		         	
		        }
		    } else {
		        alert("Geocoder failed due to: " + status);
		    }
	    });
	}

/* mapa: Funcion que renderiza un mapa GoogleMap en el contenedor especificado, centrandolo en la 
 * ciudad de Trelew 																					*/
	var mapa = function($contenedor) {
		  $contenedor.gmap3({
		    map:{
		     	options:{
			        mapTypeId: google.maps.MapTypeId.ROADMAP,
			        mapTypeControl: false,
			        navigationControl: true,
			        scrollwheel: true,
			        streetViewControl: true,
			        center:[-43.253150,-65.309413],
			        zoom: 14,
			    }
			}
		  });

		  var map = $contenedor.gmap3("get");
		  cluster = new MarkerClusterer(map,marcadores);
		  arrayCluster.push(cluster);
		  traerBaches();
	}

	var traerBaches = function() {
		$.get( "index.php/getBaches", function( data ) {
			var datos = JSON.parse(data);
	        var fallas = JSON.parse(datos.valor);
	        console.log(fallas);
			$(fallas).each(function (index, falla) {
				var dato = {};
				dato.titulo = '';
				dato.criticidad = falla.criticidad;
				dato.posicion = new google.maps.LatLng(parseFloat(falla.latitud),parseFloat(falla.longitud));
				dato.id = parseInt(falla.id);
				dato.estado = falla.estado;
				cargarMarcador(dato);
			});
			alertar("Carga Completa","Se concluyó la carga de los baches","success");
		});
	}

	function obtenerMateriales() {
		$.get( "getAlly/TipoMaterial", function(data) {
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

	function agregarAnonimo(datosFalla) {
		console.log("Agregar Falla Anónima");
		console.log(datosFalla);
		var datos={};
		if (!datosValidos(datosFalla.direccion.callePrincipal, datosFalla.direccion.altura, datosFalla.observacion))
			return;
		obtenerLatLng(datosFalla.direccion.callePrincipal,datosFalla.direccion.altura,function (posicion){
			datosFalla.falla.latitud = posicion.lat();
			datosFalla.falla.longitud = posicion.lng();
			datos.posicion = posicion;
    		$.post('crearFallaAnonima',
	            {"clase": "Falla", 	"datos":JSON.stringify(datosFalla)},
	            function(data) {
	                var respuestaServidor = $.parseJSON(data);
	                if(respuestaServidor.codigo == 200){
	                	datos = respuestaServidor.valor;
	                	datos = $.parseJSON(respuestaServidor.valor);
	                	datos.posicion = new google.maps.LatLng(parseFloat(datos.latitud),parseFloat(datos.longitud));
	    				cargarMarcador(datos);
	    				guardarImagenes(datos.id);
						alertar("Éxito!","Bache notificado con éxito","success");
						$("#formularioBache")[0].reset();

	    			}else{
						alertar("la Pucha!","No fue posible informar el bache","error");
	    			}
	            }
          	);
		});
	}

	var inicializar = function($contenedor) {
		mapa($contenedor);
		obtenerMateriales();
	};
/* return no es una funcion!: publica los métodos y propiedades que se puedan acceder, con el nombre
 * especificado 																						*/
return {
	agregarMarcador:guardarBache,
	generarMapa:mapa,
	marcadores:marcadores,
	cluster:cluster,
	marcadoresVisualizados:marcadoresVisualizados,
	obtenerCalle:obtenerCalle,
	prueba:guardarMarcador,
	agregarAnonimo:agregarAnonimo,
	arrayCluster:arrayCluster,
	marcadoresReparados:marcadoresReparados,
	init:inicializar
}

}());