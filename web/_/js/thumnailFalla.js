// Funcion que carga el codigo html del thumnail en la pagina.
(function(nameSpaceThumbnail,$,undefined){

      debug = function (msg){
        console.log(msg);
      }

      nameSpaceThumbnail.solicitarDatos = function (idFalla,urlBase){
      var url_nube = urlBase+"index.php/obtenerDatosVisualizacion/"+idFalla;
      debug("Ruta de la peticion cgi -->");
      debug(url_nube);
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
                }else if(json_estado.estado == 401){
                  debug("Ha ocurrido un error en el servidor -->");
                  debug(json_estado.error);
                  nameSpaceThumbnail.mostrar_error_thumnail(urlBase,json_estado.error);
                  return;
                }else if(json_estado.estado == 402){
                  debug("Ha ocurrido un error en el servidor -->");
                  debug(json_estado.error);
                  nameSpaceThumbnail.mostrar_error_thumnail(urlBase,json_estado.error);
                  return;
                }else{
                  debug('Los datos capturados desde el server fueron -->');
                  debug(json_estado);
                  debug('------------------------------------------------');
                  parsearDatos(idFalla,json_estado,urlBase);
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

      parsearDatos = function(idFalla,json_final,urlBase){
        // Peticiones del json.
        csv_nube = json_final["raiz_tmp"]+json_final["csv_nube"];
        imagen = json_final["raiz_tmp"]+json_final["imagen"];
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
        $("#descripcion").attr("class", "texto-exito");
        $("#descripcion").append("<h2>"+titulo+"</h2>");
        $("#descripcion").append("<h4>"+descripcion+"</h4>");
        $("#botonVisualizador").attr("style","display:inline;");

        // Incluir un metodo en el controlador privado para generar la vista
        // que renderiza el webGL.
        $("#imagenThumb").attr("src",imagen);
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