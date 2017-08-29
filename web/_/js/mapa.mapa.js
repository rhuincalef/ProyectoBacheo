$(document).ready(function(){
  inicializar();
  Bacheo.myDropzone = 4;
  Dropzone.options.imagenesForm = {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 5, // MB
    maxFiles:8, //Cantidad maxima de archivos para admitir dentro de dropzone
    autoProcessQueue:false,
    parallelUploads:8,
    maxFiles: 5,
    acceptedFiles: "image/*",
    dictDefaultMessage: "Arrastrar las imagenes aqui o click para agregarlas",

    init: function() {
      Bacheo.myDropzone = this;
      this.on("addedfile", function(file) {
        // Create the remove button
        var removeButton = Dropzone.createElement("<button>Remove file</button>");
        // Capture the Dropzone instance as closure.
        var _this = this;
        // Listen to the click event
        removeButton.addEventListener("click", function(e) {
          // Make sure the button click doesn't submit the form:
          e.preventDefault();
          e.stopPropagation();
          // Remove the file preview.
          _this.removeFile(file);
          // If you want to the delete the file on the server as well,
          // you can do the AJAX request here.
        });
        // Add the button to the file preview element.
        file.previewElement.appendChild(removeButton);
      });
    }
  };
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
  $("#seleccionarCalle").click(bindearEventoClick);
  $("#buscarCalle").geocomplete("autocomplete").setBounds(boundsTrelew);
  $("#opcionAgregar").click(function(){
    inicializarFormularioBache();     
  });
  $("#verReparadas").addClass('reparados');
  $("#verReparadas").click(function(e) {
    e.preventDefault();
    $("#verReparadas").empty();
    if ($("#verReparadas").hasClass('reparados')) {
      alertar("Fallas","Ver fallas reparadas.","informar");
      $("#verReparadas").removeClass('reparados');
      console.log(Bacheo.marcadores);
      Bacheo.arrayCluster.map(function(cluster, i) {
        cluster.clearMarkers();
      });
      cluster = new MarkerClusterer($("#canvasMapa").gmap3("get"));
      Bacheo.marcadoresReparados.map(function(marcador, i) {
        console.log(i);
        marcador.agregarAMapa($("#canvasMapa").gmap3("get"));
        cluster.addMarker(marcador.marker, true);
      });
      Bacheo.arrayCluster.push(cluster);
      $("#verReparadas").append('<i class="fa fa-eye"></i> Fallas no reparadas');
    } else {
      alertar("Fallas","Ver fallas no reparadas.","informar");
      $("#verReparadas").addClass('reparados');
      console.log(Bacheo.marcadoresReparados);
      Bacheo.arrayCluster.map(function(cluster, i) {
        cluster.clearMarkers();
      });
      $("#verReparadas").append('<i class="fa fa-eye"></i> Fallas reparadas');
      cluster = new MarkerClusterer($("#canvasMapa").gmap3("get"));
      Bacheo.marcadores.map(function(marcador, i) {
        console.log(i);
        marcador.agregarAMapa($("#canvasMapa").gmap3("get"));
        cluster.addMarker(marcador.marker, true);
      });
      Bacheo.arrayCluster.push(cluster);
    }
    return false;
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
  if ($('#formularioBache textarea').val().length != 0) {
    var descripcion = $formulario["descripcion"].value;
  }
}
