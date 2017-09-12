// Funcion que carga el codigo html del thumnail en la pagina.
(function(nameSpaceThumbnail,$,undefined){

      debug = function (msg){
        console.log(msg);
      }
      nameSpaceThumbnail.imgThumbCarga = undefined ;
      nameSpaceThumbnail.imgThumbError = undefined ;
      nameSpaceThumbnail.imgThumbFondo = undefined ;

      nameSpaceThumbnail.inicializarImgs = function(imgCarga,imgError,imgFondo){
        nameSpaceThumbnail.imgThumbCarga = imgCarga
        nameSpaceThumbnail.imgThumbError = imgError
        nameSpaceThumbnail.imgThumbFondo = imgFondo
        console.debug("Inicializadas las imgs asociadas a thumbnails!");
        console.debug("Imagen de carga: " + nameSpaceThumbnail.imgThumbCarga);
        console.debug("Imagen de error: " + nameSpaceThumbnail.imgThumbError);
        console.debug("Imagen de fondo: " + nameSpaceThumbnail.imgThumbFondo);
      
      }

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
                    nameSpaceThumbnail.mostrar_error_thumnail(urlBase,json_estado.error);
                    return;
                  }else{
                    debug('Los datos capturados desde el server fueron -->');
                    debug(json_estado);
                    debug('------------------------------------------------');
                    inicializarVisoresCaptura(idFalla,json_estado,urlBase,nameSpaceThumbnail.imgThumbCarga);
                    console.debug("---> json_estado: ");
                    console.debug(json_estado);
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


      // Configura el comportamiento del thumnail.
      //nameSpaceThumbnail.configurar_thumbnail = function(rutaImg){
      configurar_thumbnail = function(rutaImg,nombreCap){
        //[ "infoMitre_1.csv", "infoMitre_2.csv" ]
        console.debug("En configurar_thumbnail " + nombreCap);
        //$("[rel='tooltip']").tooltip();
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


      inicializarVisoresCaptura = function(idFalla,jsonCapturas,urlBase,fullDirCaptura){
        debugger;
        console.debug("EN inicializarVisoresCaptura()");
        console.debug("Coleccion : " + jsonCapturas["nombresCapturas"]);

        for (var i = 0; i < jsonCapturas["nombresCapturas"].length; i++) {
          console.debug('jsonCapturas["nombresCapturas"] ');
          //nombreCap = jsonCapturas["nombresCapturas"][i];
          //Se deja solamente el nombre como identificador
          nombreCap = jsonCapturas["nombresCapturas"][i].split(".")[0];
          console.debug(nombreCap);
          //containerThumbnail = '<div id = ' + '"' + nombreCap + '"' + ' class="col-lg-4 col-sm-4 col-xs-6">';
          thumbnail = '<div id=' + '"' + nombreCap + '">';
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
          //$('#'+nombreCap).find("#containerWebGL").hide();
          //$('#'+nombreCap).find('#cargando-gif').hide();
          $("#"+nombreCap).children("#containerWebGL").hide();
          $('#'+nombreCap).children('#cargando-gif').hide();
          console.debug("fullDirCaptura: " + fullDirCaptura);
          //Se configura el thumbnail por defecto
          console.debug("Configurando el thumbnail...  ");
          debugger;
          configurar_thumbnail(fullDirCaptura,nombreCap);
          //(idFalla,titulo,descripcion,imagen,urlPcFile,
          // urlBase,capturaActual)
          //fullNameCaptura = jsonCapturas["nombresCapturas"][i];
          /*mostrar_texto_thumnail(idFalla,
                                  fullNameCaptura,
                                  fullNameCaptura,
                                  nameSpaceThumbnail.imgThumbFondo,
                                  nombreCap,
                                  urlBase,
                                  nombreCap
                                  ); */
        debugger;
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
        
        var imagen_carga = nameSpaceThumbnail.imgThumbCarga;
        $("#"+nombreCap).find("#botonVisualizador").on("click",function(){
            // AL clickear se carga el canvas y el contenedor webGL
            //inicializar_canvas(urlPcFile,imagen_carga,capturaActual);
            alert("Se cargo el canvas!!!!");
        });
        // AL clickear se carga el canvas y el contenedor webGL
        $("#boton-volver").on("click",function(){
            restaurar_thumbnail(nombreCap);
        });

      }

    }
      /* Ej. de json_final -->
       { estado: 200, dirRaizCapturas: "http://localhost/web/_/dataMultimedia/1/",
            nombresCapturas: ["infoMitre_1","infoMitre_2"] } */
      parsearDatos = function(idFalla,json_final,urlBase){
        console.debug("json_final tiene:");
        console.debug(json_final);
        console.debug("");
        for (var i = 0; i < json_final["nombresCapturas"].length ; i++) {
            capturaActual = json_final["nombresCapturas"][i];
            fullPathCaptura = json_final["dirRaizCapturas"] + capturaActual;
            imagen = nameSpaceThumbnail.imgThumbFondo;
            debugger;
            // Se parsea el csv con la descripcion
            Papa.parse(fullPathCaptura, {
                download: true,
                step: function(row){
                },
                complete: function(results, file) {
                  debugger;
                  mostrar_texto_thumnail(idFalla,results.data[0][0],
                                            results.data[1][0],imagen,urlBase,capturaActual);
                },
                error: function(err, file, inputElem, reason){
                    nameSpaceThumbnail.mostrar_error_thumnail(urlBase,"Error en PapaParse: "+err,capturaActual);
                  }
                });

            }
      }


      /*
      //BACKUP!
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
       */

       /*
      // Configura el thumbnail para el caso de exito.
      mostrar_texto_thumnail = function(idFalla,titulo,descripcion,
                                          imagenURL,urlPcFile,urlBase,
                                          capturaActual){
        debugger;
        debug("En mostrar texto thumbnail!");
        $("#descripcion").attr("class", "texto-exito");
        $("#descripcion").append("<h2>"+titulo+"</h2>");


        $("#descripcion").append("<h4>"+descripcion+"</h4>");
        //$("#botonVisualizador").attr("style","display:inline;");


        $("#"+capturaActual).find("#botonVisualizador").attr("style","display:inline;");

        // Incluir un metodo en el controlador privado para generar la vista
        // que renderiza el webGL.
        $("#"+capturaActual).find("#imagenThumb").attr("src",imagenURL);
        
        var imagen_carga = nameSpaceThumbnail.imgThumbCarga;
        $("#"+capturaActual).find("#botonVisualizador").on("click",function(){
            // AL clickear se carga el canvas y el contenedor webGL
            //inicializar_canvas(urlPcFile,imagen_carga,capturaActual);
            alert("Se cargo el canvas!!!!");
        });
        
        // AL clickear se carga el canvas y el contenedor webGL
        $("#boton-volver").on("click",function(){
            restaurar_thumbnail(capturaActual);
        });
        
      }*/

      mostrar_notificacion_exito = function(){
        $.notify({
              title: '<strong>Ok </strong>',
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


      // Este metodo oculta el thumbnail y muestra el contenido del canvas del webGL
      inicializar_canvas = function(urlPcFile,imagenCarga,capturaActual){
        $("#"+capturaActual).find("#containerThumbnail").fadeOut();
        $("#"+capturaActual).find("#cargando-gif").attr("src",imagenCarga);
        $("#"+capturaActual).find("#cargando-gif").fadeIn();
        webGL.iniciarWebGL(urlPcFile);
      }

      // Oculta el canvas y restaura el thumbnail.
      restaurar_thumbnail = function(capturaActual){
        $("#"+capturaActual).find("#containerWebGL").fadeOut();
        webGL.resetear_canvas(); 
        $("#"+capturaActual).find("#boton-info").fadeOut();
        $("#"+capturaActual).find("#containerThumbnail").fadeIn();
      }


      /*
      //BACKUP
      // Este metodo oculta el thumbnail y muestra el contenido del canvas del webGL
      inicializar_canvas = function(urlPcFile,imagenCarga){
        $("#containerThumbnail").fadeOut();
        $("#cargando-gif").attr("src",imagenCarga);
        $("#cargando-gif").fadeIn();
        webGL.iniciarWebGL(urlPcFile);
      }

      // Oculta el canvas y restaura el thumbnail.
      restaurar_thumbnail = function(){
        $("#containerWebGL").fadeOut();
        webGL.resetear_canvas(); 
        $("#boton-info").fadeOut();
        $("#containerThumbnail").fadeIn();
      }*/


      // Genera un alert para el thumnail
      nameSpaceThumbnail.mostrar_error_thumnail = function (urlBase,msgError,capturaActual){
        $("#"+capturaActual).find("#imagenThumb").attr("src",nameSpaceThumbnail.imgThumbError);
        $("#"+capturaActual).find("#descripcion").attr("class","texto-error");
        $("#"+capturaActual).find("#descripcion").append("Archivo de captura "+ capturaActual+" no encontrado");
        mostrar_notificacion_error(msgError);
        /*
        //BACKUP
        $("#imagenThumb").attr("src",urlBase+"_/img/res/errorInterno.png");
        $("#descripcion").attr("class","texto-error");
        $("#descripcion").append("Archivo no encontrado");*/

      }

}(window.nameSpaceThumbnail = window.nameSpaceThumbnail || {},jQuery));