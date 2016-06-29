$(document).ready(function(){
// alertar("laPucha","fue un la pucha","error");

/*ESto capas que no va aca pero todavia estoy laburando con esto. */
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
        
    // Dropzone.options.imagenesForm = { // The camelized version of the ID of the form element
    //     // The configuration we've talked about above
    //     autoProcessQueue: false,
    //     uploadMultiple: true,
    //     parallelUploads: 5,
    //     maxFiles: 5,
    //     acceptedFiles: "image/*",
    //     dictDefaultMessage: "Arrastrar las imagenes aqui o click para agregarlas",
        // The setting up of the dropzone
        // init: function() {
        //   var myDropzone = this;
        //  // Here's the change from enyo's tutorial...
        //     // $("#submit-all").click(function (e)   
        //     //     e.preventDefault();
        //     //     e.stopPropagation();  
        //     //     myDropzone.processQueue();
        //     //     }
        //     // );

        // }
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


    $("#opcionAgregar").click(function(){
    	inicializarFormularioBache();    	
    });
    inicializar();
});

function inicializar(){
//  $("#modaInfoBacheAceptar").click(Bacheo.agregarMarcador);
  if (typeof google == 'undefined')
  {
    return;
  }
  Bacheo.init($("#canvasMapa"));
  //Bacheo.generarMapa($("#canvasMapa"));
  $("#seleccionarCalle").click(bindearEventoClick);

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