$(document).ready(function(){
  inicializar();
});

function inicializar(){
  if (typeof google == 'undefined')
  {
    alertar("La Pucha!","No ha sido posible cargar las librerías de Google. Varias funcionalidades de la aplicación no se podrán utilizar.","error");
    return;
  }
  Bacheo.init($("#canvasMapa"));

  var boundsTrelew = new google.maps.LatLngBounds(
    new google.maps.LatLng(-43.230650145567985, -65.37500381469727),
    new google.maps.LatLng(-43.28790660359147, -65.25123596191406)
  );

  $("#buscarCalle").geocomplete({
    map: $("#canvasMapa").gmap3("get"),
    country: 'ar',
    bounds:boundsTrelew,
    componentRestrictions:{
      postal_code:'9100'
    }
  });

  $("#buscarCalle").geocomplete("autocomplete").setBounds(boundsTrelew);
  $("#opcionAgregar").click(function(){
    inicializarFormularioBache();     
  });
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
