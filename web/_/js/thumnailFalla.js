// Funcion que carga el codigo html del thumnail en la pagina.
(function(nameSpaceThumbnail,$,undefined){

      debug = function (msg){
        console.log(msg);
      }
      nameSpaceThumbnail.imgThumbCarga = undefined ;
      nameSpaceThumbnail.imgThumbError = undefined ;
      nameSpaceThumbnail.imgThumbFondo = undefined ;
      nameSpaceThumbnail.dirRaizCapturas = undefined;
      nameSpaceThumbnail.EXTENSION_CAPTURA = undefined;

      inicializarAyuda = function(contenedorVisor){
        $("#ayudaVisor").animate({width: 'hide'});
        $("#botonCerrar").on("click",function(){
          $("#ayudaVisor").animate({width: 'hide'});
        });
      }


      nameSpaceThumbnail.inicializarImgs = function(imgCarga,imgError,imgFondo,extCaptura){
        nameSpaceThumbnail.imgThumbCarga = imgCarga;
        nameSpaceThumbnail.imgThumbError = imgError;
        nameSpaceThumbnail.imgThumbFondo = imgFondo;
        nameSpaceThumbnail.EXTENSION_CAPTURA = extCaptura;

        console.debug("Inicializadas las imgs asociadas a thumbnails!");
        console.debug("Imagen de carga: " + nameSpaceThumbnail.imgThumbCarga);
        console.debug("Imagen de error: " + nameSpaceThumbnail.imgThumbError);
        console.debug("Imagen de fondo: " + nameSpaceThumbnail.imgThumbFondo);
        console.debug("Extension captura: " + nameSpaceThumbnail.EXTENSION_CAPTURA);
      }



      mostrar_notificacion_exito = function(){
        $.notify({
              title: '<strong>Ok: </strong>',
              message: "Datos para visualizacion generados correctamente"
            },
            {
              type: 'success'
        });
      }



      mostrar_notificacion_error = function(msgError){
        $.notify({
              title: '<strong>Error en el servidor: </strong>',
              message: msgError
            },
            {
              type: 'danger'
        });
      }

      mostrar_notificacion_warning = function(mensajeWarning){
       $.notify({
              title: '<strong>Carga de fallas inconclusa: </strong>',
              message: mensajeWarning
            },
            {
              //type: 'notice'
              type: 'info'
        });
       //debugger;
      }


      /* Ej. de json_final -->
       { estado: 200, dirRaizCapturas: "http://localhost/web/_/dataMultimedia/1/",
            nombresCapturas: ["infoMitre_1","infoMitre_2"] } */

      nameSpaceThumbnail.solicitarCapturas = function (idFalla,urlBase){
        var url_nube = urlBase+ "index.php/obtenerDatosVisualizacion/"+idFalla;
        console.debug("En solicitarCapturas()...");
        $.ajax({
            url: url_nube,
            success:function(data,status,jqhxr){
                  debug('Peticion realizada!');
                  debug(jqhxr.responseText);
                  var json_estado = JSON.parse(jqhxr.responseText);
                  if (json_estado.estado == 400){
                    debug("Ha ocurrido un error en el servidor -->");
                    debug(json_estado.error);
                    //nameSpaceThumbnail.mostrar_error_thumnail(urlBase,json_estado.error);
                    mostrar_notificacion_error(json_estado.error);
                    return;
                  }

                  if (json_estado.nombresCapturas.length == 0) {
                    mostrar_notificacion_warning("No existen archivos de captura asociados a la falla");
                  }

                  if(json_estado.estado == 200){
                    mostrar_notificacion_exito();
                    debug('Los datos capturados desde el server fueron -->');
                    debug(json_estado);
                    debug('------------------------------------------------');
                    inicializarVisoresCaptura(idFalla,json_estado,urlBase,nameSpaceThumbnail.imgThumbCarga);
                    console.debug("---> json_estado: ");
                    console.debug(json_estado); 
                  }                  
            },
            error: function(data,textoErr,jqhxr){
                  // a = '{"estado":402,"datos": {},"error":"Error al escribir la imagen"}';
                  // JSON.parse(a);
                  debug('Error en la solicitud 1-->');
                  debug(data);
                  var json1 = JSON.parse(data.responseText);
                  nameSpaceThumbnail.mostrar_error_thumnail(urlBase,json1.error);
                }
              });
      }


      // Configura el comportamiento del thumnail.
      //nameSpaceThumbnail.configurar_thumbnail = function(rutaImg){
      configurar_thumbnail = function(rutaImg,nombreCap){
        //[ "infoMitre_1.csv", "infoMitre_2.csv" ]
        console.debug("En configurar_thumbnail " + nombreCap);
        $('#'+nombreCap).find(".thumbnail").hover(
            function(){
              $(this).find('.caption').slideDown(350); //.fadeIn(250)
            },
            function(){
              $(this).find('.caption').slideUp(250); //.fadeOut(205)
            }
        );
        $('#'+nombreCap).find("#imagenThumb").attr("src",rutaImg);
        $('#'+nombreCap).find(".thumbnail").find('.caption').slideUp(250);      
        console.debug("Finalizo configuracion de thumbnail");
        
      }

      /* Ej. de json_final -->
       { estado: 200, dirRaizCapturas: "http://localhost/web/_/dataMultimedia/1/",
            nombresCapturas: ["infoMitre_1","infoMitre_2"] } */
      inicializarVisoresCaptura = function(idFalla,jsonCapturas,urlBase,fullDirCaptura){
        console.debug("EN inicializarVisoresCaptura()");
        console.debug("Coleccion : " + jsonCapturas["nombresCapturas"]);

        //Se inicializan los botones de ayuda asociados a la ayuda una unica vez
        inicializarAyuda();


        
        nameSpaceThumbnail.dirRaizCapturas = jsonCapturas["dirRaizCapturas"];
        console.debug("dirRaizCapturas: " + nameSpaceThumbnail.dirRaizCapturas);

        for (var i = 0; i < jsonCapturas["nombresCapturas"].length; i++) {
          console.debug('jsonCapturas["nombresCapturas"] ');
          //nombreCap = jsonCapturas["nombresCapturas"][i];
          //Se deja solamente el nombre como identificador
          nombreCap = jsonCapturas["nombresCapturas"][i].split(".")[0];
          console.debug(nombreCap);
          //containerThumbnail = '<div id = ' + '"' + nombreCap + '"' + ' class="col-lg-4 col-sm-4 col-xs-6">';
          thumbnail = '<div id=' + '"' + nombreCap + '" class="divContainerThumbnail">';
          thumbnail += '<div class="thumbnail" > \
                                                  \
                          <div class="caption" > \
                            <div id="descripcion" > \
                            </div> \
                              <p> <a id="botonVisualizador" class="btn btn-lg btn-primary" style="display:none;">Ver</a> \
                              </p> \
                            </div> \
                            <img id ="imagenThumb" class="img-responsive"></img> \
                          </div> \
                          \
                        <!-- Imagen que se muestra cuando se carga el csv desde el servidor -->\
                          <img id="cargando-gif"></img>\
                          \
                     </div>';

          $('#containerThumbnail').append(thumbnail);

          containerWebGL = '<!-- Contenedor para renderizar la captura '+ nombreCap + ' webGL -->\
            <!-- <div id="containerWebGL" style="display:block; width:50%; height:50%; position:relative;"> --> \
            <div id="containerWebGL" >\
              <div class="row">\
              \
              <button id="botonAyudaVisor"  type="button"  \
                      class="btn btn-primary boton-personalizado btn-lg "> Ayuda visor</button>\
                      \
                <!-- Boton de regreso --> \
                <button id="boton-volver"   data-toggle="collapse"   data-target="#datos-falla"   type="button"  \
                      class="btn btn-primary boton-personalizado btn-lg "> Regresar </button> \
                \
                <div id ="error-alert" style="display:none; ">Error al cargar la captura remota ' + nombreCap+ '</div> \
                \
              </div> \
              \
              <div class="row">\
                <div id="canvasWebGL"></div> \
              </div>\
            </div>'; 

          $('#'+nombreCap).append(containerWebGL);

          //Se esconden el gif de carga y el canvas para renderizar WebGL
          $("#"+nombreCap).children("#containerWebGL").hide();
          $('#'+nombreCap).children('#cargando-gif').hide();
          console.debug("fullDirCaptura: " + fullDirCaptura);
          //Se configura el thumbnail por defecto
          console.debug("Configurando el thumbnail...  ");
          configurar_thumbnail(fullDirCaptura,nombreCap);
          var titulo = nombreCap;
          var descripcion = jsonCapturas["nombresCapturas"][i];
          //Se termina de configurar la descripcion del thumbnail
          $("#"+nombreCap).find("#descripcion").attr("class", "texto-exito");
          $("#"+nombreCap).find("#descripcion").append("<h2>"+titulo+"</h2>");
          $("#"+nombreCap).find("#descripcion").append("<h4>"+descripcion+"</h4>");
          $("#"+nombreCap).find("#botonVisualizador").attr("style","display:inline;");

          // Incluir un metodo en el controlador privado para generar la vista
          // que renderiza el webGL.
          $("#"+nombreCap).find("#imagenThumb").attr("src",nameSpaceThumbnail.imgThumbFondo);
          
          $("#"+nombreCap).find("#botonVisualizador").on("click",function(){
              // AL clickear se carga el canvas y el contenedor webGL
              console.debug("Se cargo el canvas!!!!");
              inicializar_canvas($(this),
                                  jsonCapturas["dirRaizCapturas"] + jsonCapturas["nombresCapturas"][i],
                                  nameSpaceThumbnail.imgThumbCarga,
                                  jsonCapturas["dirRaizCapturas"]);

          });
          // AL clickear se carga el canvas y el contenedor webGL
          $("#"+nombreCap).find("#boton-volver").on("click",function(){
              restaurar_thumbnail($(this));
          });

          $("#"+nombreCap).find("#botonAyudaVisor").on("click",function(){
              $("#ayudaVisor").animate({width: 'show'});
          });


      }

    }


      cargarVisualizador = function(archCaptura,divContenedorThumbnail){
        console.debug("Cargando los datos del visualizador para la falla: " + archCaptura);
        var urlCaptura = nameSpaceThumbnail.dirRaizCapturas + divContenedorThumbnail.attr("id") + nameSpaceThumbnail.EXTENSION_CAPTURA;
        console.debug("URL de la captura: " + urlCaptura);
        var webGLCanvas = divContenedorThumbnail.find("#canvasWebGL").get(0);
        webGL.iniciarWebGL(urlCaptura,webGLCanvas);
      }



      // Se expande el visualizador a un tamaño
      expandirThumbnail = function(divContenedorThumbnail){
        console.debug("Expandiendo el thumbnail");
        cargarVisualizador(divContenedorThumbnail.attr("id"),divContenedorThumbnail);
        
        divContenedorThumbnail.find("#cargando-gif").fadeOut();
        divContenedorThumbnail.find("#containerWebGL").show();
        divContenedorThumbnail.css("width","100%");

      }

      // Este metodo oculta el thumbnail y muestra el contenido del canvas del webGL
      inicializar_canvas = function(botonVisualizador,urlPcFile,
                                      imagenCarga,dirRaizCapturas){
        
        //divContenedorThumbnail es <div> principal que contiene la falla
        var divContenedorThumbnail = botonVisualizador.parents(".thumbnail").parent();
        divContenedorThumbnail.find(".thumbnail").fadeOut();
        divContenedorThumbnail.find(".thumbnail").hide();

        divContenedorThumbnail.find("#cargando-gif").attr("src",imagenCarga);
        divContenedorThumbnail.find("#cargando-gif").fadeIn();
        console.debug("Expandiendo thumbnail de la falla: " + divContenedorThumbnail);  
        expandirThumbnail(divContenedorThumbnail);

      }

      //Resetea los valores del canvas que hagan falta
      restaurarCanvas = function(archCaptura){
        console.debug("Restaurando canvas");
        var contenedorCanvas = $("#"+archCaptura).find("#canvasWebGL");
        contenedorCanvas.empty();
      }

      // Oculta el canvas y restaura el thumbnail.
      restaurar_thumbnail = function(botonVolver){
        var divContenedorWebGL = botonVolver.parents("#containerWebGL").parent();
        var archCaptura = divContenedorWebGL.attr("id");
        restaurarCanvas(archCaptura); 

        //Se oculta el canvas de webGL y se muestra el thumbnail de nuevo
        divContenedorWebGL.find("#containerWebGL").hide();
        divContenedorWebGL.find(".thumbnail").fadeIn();
        divContenedorWebGL.find(".thumbnail").show();
        divContenedorWebGL.css("width","30%");

      }

}(window.nameSpaceThumbnail = window.nameSpaceThumbnail || {},jQuery));