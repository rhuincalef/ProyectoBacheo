var Bacheo = (function(){
	var marcadores=[];
	var geocoder = new google.maps.Geocoder();

	Marcador = function(datos, mapa){
		this.criticidad = datos.criticidad;
		this.marker = new google.maps.Marker({
			position: datos.posicion,
			map: mapa,
			title: datos.titulo
	  });
		return this;
	}

	var guardarBache = function(){
		var $formulario = $('form[id="formularioBache"]')[0];
		var calle = $formulario["calle"].value;
		var altura = $formulario["altura"].value;
		var descripcion = $formulario["descripcion"].value;
		var titulo = $formulario["titulo"].value;
		var criticidad = $formulario["criticidad"].value;
		guardarMarcador(titulo,criticidad,calle,altura,descripcion);
	}

	var cargarMarcador = function(datos){
		var $mapa = $("#canvasMapa").gmap3("get");
		var marcador = new Marcador(datos,$mapa);
		marcadores.push(marcador);
	}

	var guardarMarcador = function(titulo, criticidad, calle, altura, descripcion){
		var datos={};
		datos.titulo = titulo;
		datos.criticidad = criticidad;
		datos.descripcion = descripcion;

		obtenerLatLng(calle,altura,function (posicion){
			datos.posicion = posicion;
			cargarMarcador(datos);
		});
	}


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

	function obtenerCalle(latlng,calle,altura){
		geocoder.geocode({'latLng': latlng}, function(results, status) {
		    if (status == google.maps.GeocoderStatus.OK) {
		    	if (results[1]){
		         	calle.value = results[0].address_components[1].long_name;
		         	altura.placeholder= results[0].address_components[0].long_name;              
		        }
		    } else {
		        alert("Geocoder failed due to: " + status);
		    }
	    });
	}

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
	}

return{
	agregarMarcador:guardarBache,
	generarMapa:mapa,
	marcadores:marcadores,
	obtenerCalle:obtenerCalle
}


}())