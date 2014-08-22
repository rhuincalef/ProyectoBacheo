$(document).ready(function(){
	var mapOptions = {
          center: new google.maps.LatLng(-43.253432, -65.310137),
          zoom: 16,
          mapTypeControl: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

    // alertar("laPucha","fue un la pucha","error");

    var map = new google.maps.Map(document.getElementById("canvasMapa"),mapOptions);


/*ESto capas que no va aca pero todavia estoy laburando con esto. */

    Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
        // The configuration we've talked about above
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        acceptedFiles: "image/*",
        dictDefaultMessage: "Arrastrar las imagenes aqui o click para agregarlas",
        // The setting up of the dropzone
        // init: function() {
        //   var myDropzone = this;
        //  // Here's the change from enyo's tutorial...
        //     // $("#submit-all").click(function (e) {
        //     //     e.preventDefault();
        //     //     e.stopPropagation();
        //     //     myDropzone.processQueue();
        //     //     }
        //     // );

        // }
        init: function() {
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
});

function inicializarFormularioBache(){
  cargarCriticidad();
	$("#informacionBache").modal("toggle");
};

function cargarCriticidad(){
  var opciones = $("#criticidad").find("option");
  opciones.each(function(indice,elemento){
    var globo = informar("Informacion","Hola que tal "+indice);
    $(elemento).hover(function(event){
      var posicionY = $(event.target).position().top+100;
      globo.get().css({'top': posicionY });
      globo.open();

    });
    $(elemento).mouseout(function(){globo.remove() ;});
  })
  
};