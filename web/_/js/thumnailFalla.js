// Funcion que carga el codigo html del thumnail en la pagina.
(function(nameSpaceThumbnail,$,undefined){

      debug = function (msg){
        console.log(msg);
      }

      nameSpaceThumbnail.solicitarCapturas = function (idFalla,urlBase){
        var url_nube = urlBase+ "index.php/obtenerDatosVisualizacion/"+idFalla;

        $.ajax({
            url: url_nube,
            success:function(data,status,jqhxr){
                  debug('Peticion realizada!');
                  debug(jqhxr.responseText);
                  var json_estado = JSON.parse(jqhxr.responseText);
                  if (json_estado.estado == 400){
                    debug("Ha ocurrido un error en el servidor -->");
                    debug(json_estado.error);
                    nameSpaceThumbnail.mostrar_error_thumnail(urlBase,json_estado.error);
                    return;
                  }else{
                    debug('Los datos capturados desde el server fueron -->');
                    debug(json_estado);
                    debug('------------------------------------------------');
                    inicializarVisoresCaptura(idFalla,json_estado,urlBase);
                    //parsearDatos(idFalla,json_estado,urlBase);
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

      inicializarVisoresCaptura = function(idFalla,jsonCapturas,urlBase){
        console.debug("EN inicializarVisoresCaptura()");
        console.debug("Coleccion : " + jsonCapturas["nombresCapturas"]);
        for (var i = 0; i < jsonCapturas["nombresCapturas"].length; i++) {
          console.debug('jsonCapturas["nombresCapturas"] ');
          nombreCap = jsonCapturas["nombresCapturas"][i];
          console.debug(nombreCap);
          contenidoThumnail = "<div id = " + "'" + nombreCap + "'" + " class='col-lg-4 col-sm-4 col-xs-6'>";
          contenidoThumnail +=  '<div class="thumbnail" > \
                                    <div class="caption" > \
                                      <div id="descripcion" > \
                                      </div> \
                                      <p> <a id="botonVisualizador" class="btn btn-lg btn-primary" style="display:none;">Ver</a> \
                                      </p> \
                                  </div> \
                                    <img id ="imagenThumb" class="img-responsive"></img> \
                                  </div> \
                                  <!-- Imagen que se muestra cuando se carga el csv desde el servidor -->\
                                    <img id="cargando-gif"></img>\
                               </div>';

          $('#containerThumnail').append(contenidoThumnail);
          $('#containerThumnail').append();

          containerWebGL = '<!-- Contenedor para renderizar la captura '+ nombreCap + ' webGL -->\
            <div id="containerWebGL" style="display:block; width:50%; height:50%; position:relative;" >\
            \
              <div class="row">\
                <!-- Boton de regreso --> \
                <button id="boton-volver"   data-toggle="collapse"   data-target="#datos-falla"   type="button"  \
                      class="btn btn-primary boton-personalizado btn-lg ">Regresar </button> \
                <div id ="error-alert" style="display:none; ">Error al cargar la captura remota ' + nombreCap+ '</div> \
              </div> \
            </div>'; 
          $('#'+nombreCap).append(containerWebGL);
          //Se esconden el gif de carga y el canvas para renderizar WebGL
          $('#'+nombreCap).find("#containerWebGL").hide();
          $('#'+nombreCap).find('#cargando-gif').hide();
      }
    }




      parsearDatos = function(idFalla,json_final,urlBase){
        // Peticiones del json.
        csv_nube = json_final["raiz_tmp"]+json_final["csv_nube"];
        imagen = json_final["imagen"];
        path_csv =json_final["raiz_tmp"]+json_final["info_csv"];
        
        // Se parsea el csv con la descripcion
        Papa.parse(path_csv, {
            download: true,
            complete: function(results, file) {
              mostrar_texto_thumnail(idFalla,results.data[0][0],
                                        results.data[1][0],imagen,csv_nube,urlBase);

        },
        error: function(err, file, inputElem, reason){
            nameSpaceThumbnail.mostrar_error_thumnail(urlBase,"Error en PapaParse: "+err);
          }
        });
      }


      // Configura el comportamiento del thumnail.
      nameSpaceThumbnail.configurar_thumbnail = function(rutaImg){
        $("[rel='tooltip']").tooltip();
        $('.thumbnail').hover(
            function(){
              $(this).find('.caption').slideDown(350); //.fadeIn(250)
            },
            function(){
              $(this).find('.caption').slideUp(250); //.fadeOut(205)
            }
        );
        $("#imagenThumb").attr("src",rutaImg);
        $(".thumbnail").find('.caption').slideUp(250);      
      }

      // Configura el thumbnail para el caso de exito.
      mostrar_texto_thumnail = function(idFalla,titulo,descripcion,imagen,urlPcFile,urlBase){
        debug("En mostrar texto thumbnail!");
        //$("#descripcion").attr("class", "texto-exito");
        //$("#descripcion").append("<h2>"+titulo+"</h2>");
        //$("#descripcion").append("<h4>"+descripcion+"</h4>");
        $("#botonVisualizador").attr("style","display:inline;");

        // Incluir un metodo en el controlador privado para generar la vista
        // que renderiza el webGL.
        $("#imagenThumb").attr("src",urlBase+imagen);
        // $("#botonVisualizador").attr("href","app/views/viewer.php?c=" + idFalla);


        var imagen_carga = urlBase+"_/img/res/generandoArchivos.svg";
        $("#botonVisualizador").on("click",function(){
            // AL clickear se carga el canvas y el contenedor webGL
            inicializar_canvas(urlPcFile,imagen_carga);
        
        });
        $("#boton-volver").on("click",function(){
            // AL clickear se carga el canvas y el contenedor webGL
            restaurar_thumbnail();
        });


        $.notify({
              title: '<strong>Ok </strong>',
              message: "Datos para visualizacion generados correctamente"
            },
            {
              type: 'success'
        });        
      }

      // Este metodo oculta el thumbnail y muestra el contenido del canvas del webGL
      inicializar_canvas = function(urlPcFile,imagenCarga){
        $("#containerThumnail").fadeOut();
        $("#cargando-gif").attr("src",imagenCarga);
        $("#cargando-gif").fadeIn();
        webGL.iniciarWebGL(urlPcFile);
      }

      // Oculta el canvas y restaura el thumbnail.
      restaurar_thumbnail = function(){
        $("#containerWebGL").fadeOut();
        webGL.resetear_canvas(); 
        $("#boton-info").fadeOut();
        $("#containerThumnail").fadeIn();
      }

      // Genera un alert para el thumnail
      nameSpaceThumbnail.mostrar_error_thumnail = function (urlBase,msgError){
        $.notify({
              title: '<strong>Error en el servidor: </strong>',
              message: msgError
            },
            {
              type: 'danger'
        });
        $("#imagenThumb").attr("src",urlBase+"_/img/res/errorInterno.png");
        $("#descripcion").attr("class","texto-error");
        $("#descripcion").append("Archivo no encontrado");
      }

}(window.nameSpaceThumbnail = window.nameSpaceThumbnail || {},jQuery));