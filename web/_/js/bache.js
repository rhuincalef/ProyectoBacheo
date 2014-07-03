$(document).ready(function(){
	inicializar();
});


function inicializar(){
  $("#modaInfoBacheAceptar").click(Bacheo.agregarMarcador);
  $("#canvasMapa").gmap3("get");
  $("#canvasMapa").gmap3({
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
  $(".seleccionarCalle").click(bindearEventoClick);
}




function bindearEventoClick(e){
e.preventDefault();
  var $mapa = $("#canvasMapa").gmap3("get");
  google.maps.event.addListener($mapa, "click", function(event){
  	capturarCoordenadasBache(event);
  });
  $("#informacionBache").modal("toggle");
  $mapa.setOptions({draggableCursor:'crosshair'});
}

function capturarCoordenadasBache(e){
	var $mapa = $("#canvasMapa").gmap3("get");
	$("#informacionBache").modal("toggle");
	google.maps.event.clearListeners($mapa, 'click');
	$mapa.setOptions({draggableCursor:''});
	var $calle = $('form[id="formularioBache"]')[0]["calle"];
	var $altura = $('form[id="formularioBache"]')[0]["altura"];
	Bacheo.obtenerCalle(e.latLng,$calle,$altura);
}


function guardarBache(){
	var $formulario = $('form[id="formularioBache"]')[0];
	var titulo = $formulario["titulo"].value;
	var calle = $formulario["calle"].value;
	var altura = parseInt($formulario["altura"].value);
	var criticidad = parseInt($formulario["criticidad"].value);
	var descripcion = $formulario["descripcion"].value;
}
