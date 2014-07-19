var Bacheo = (function(){
	var marcadores = [];
	var cluster;
	var geocoder = new google.maps.Geocoder();

/* Marcador: Objeto que representa la información básica del bache a mostrar en la páguina principal,
 * Es creado cuando desde el servidor se indica que el bache fue agregado de manera correcta, o al
 * obtener los datos del servidor (carga inicial)														*/
	Marcador = function(datos, mapa){
		this.id=datos.id;
		this.criticidad = datos.criticidad;
		this.marker = new google.maps.Marker({
			position: datos.posicion,
			map: mapa,
			title: datos.titulo
	  });
		return this;
	}

/* guardarBache: Funcion encargada de obtener los datos del formulario y desencadenar el guardado de un
 * nuevo Bache 																							*/
	var guardarBache = function(){
		var $formulario = $('form[id="formularioBache"]')[0];
		var calle = $formulario["calle"].value;
		var altura = $formulario["altura"].value;
		var descripcion = $formulario["descripcion"].value;
		var titulo = $formulario["titulo"].value;
		var criticidad = $formulario["criticidad"].value;
		guardarMarcador(titulo,criticidad,calle,altura,descripcion);
	}

/* cargarMarcador: Funcion en encargada de cargar un marcador para ser visualizado en el mapa.
 * Es utilizada por la carga inicial, al obtener los datos desde el servidor							*/
	var cargarMarcador = function(datos){
		var $mapa = $("#canvasMapa").gmap3("get");
		var marcador = new Marcador(datos,$mapa);
		marcadores.push(marcador);
		cluster.addMarker(marcador.marker,true);
	}

/* guardarMarcador: Funcion llamada desde "guardarBache", efectua la llamada al servidor para realizar
 * dicha accion, obteniendo las coordenadas reales de la dirección especificada y, de resultar efectiva
 * la carga del nuevo bache en el servidor, realiza la renderizacion del mismo para ser visualizada en
 * el mapa 																								*/
	var guardarMarcador = function(titulo, criticidad, calle, altura, descripcion){
		var datos={};
		datos.titulo = titulo;
		datos.criticidad = criticidad;
		datos.descripcion = descripcion;

		obtenerLatLng(calle,altura,function (posicion){
    	$.post( 
				"index.php/inicio/AltaBache",
             { titulo: titulo, latitud: posicion.lat(), longitud:posicion.lng(), criticidad: criticidad, descripcion:descripcion, calle:calle, alturaCalle:altura},
             function(data) {
                datos.posicion = posicion;
                var respuestaServidor = parseInt(data);
                if(respuestaServidor > -1){
                    datos.id = respuestaServidor;
    				cargarMarcador(datos);
					alertar("Exito!","Bache notificado con exito","success");
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
	function obtenerCalle(latlng,calle,altura){
		geocoder.geocode({'latLng': latlng}, function(results, status) {
		    if (status == google.maps.GeocoderStatus.OK) {
		    	console.log(results[0]);
		    	if (results[1]){
		         	calle.value = results[0].address_components[1].long_name;
		         	altura.placeholder= results[0].address_components[0].long_name;              
		        }
		    } else {
		        alert("Geocoder failed due to: " + status);
		    }
	    });
	}

/* mapa: Funcion que renderiza un mapa GoogleMap en el contenedor especificado, centrandolo en la 
 * ciudad de Trelew 																					*/
	var mapa = function($contenedor){
		  $contenedor.gmap3("get");
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
	}
/* return no es una funcion!: publica los métodos y propiedades que se puedan acceder, con el nombre
 * especificado 																						*/
return{
	agregarMarcador:guardarBache,
	generarMapa:mapa,
	marcadores:marcadores,
	obtenerCalle:obtenerCalle,
	prueba: guardarMarcador
}


}())