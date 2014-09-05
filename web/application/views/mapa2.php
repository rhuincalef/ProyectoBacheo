<div id="informacionBache" class="modal fade informacionBache" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header tituloFormularioBache">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
        <h4 class="modal-title">Información sobre Bache</h4>
      </div>

        <script type="text/javascript" >
          $(function(){
              Dropzone.options.myAwesomeDropzone = {
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 5, // MB
                maxFiles:8, //Cantidad maxima de archivos para admitir dentro de dropzone
                autoProcessQueue:false,
                parallelUploads:8
              };
              var myDropzone = new Dropzone("#my-awesome-dropzone", { url: "./index.php/inicio/subirImagen/21"});

              console.log("Se inicializo el formulario con el script de carga de imagenes.");
              $( "#modaInfoBacheAceptar").unbind( "click" );
              $("#modaInfoBacheAceptar").bind("click",function(){
                 // console.log("Los archivos encolados son:"+myDropzone.getQueuedFiles());
                // web/index.php/inicio/formBache
                myDropzone.processQueue();
                console.log("Se llamo al metodo de procesar archivos en cola programaticamente!")

              });
          });
        </script>

        <div class="contenedorCampos">
          <form id="formularioBache" action="web/inicio/subirImagen/62" >
          <!-- <form id="formularioBache" > -->
              <input name="titulo" type="text" class="form-control campoIzquierdo" placeholder="Titulo">
              <select id="criticidad" class="form-control campoDerecho">
                <option value="baja">Pequeño</option>
                <option value="media">Mediano</option>
                <option value="alta">Grande</option>
              </select>

              <!-- <div class="alerta">  
                <strong>Nota:</strong> Esta descripcion corresponde a un bache mediano
              </div> -->

              <button id="seleccionarCalle" type='button' class="seleccionarCalle" rel="tooltip" title="Marcar calle en el Mapa" ><i class="fa fa-crosshairs"></i></button>
              <input name="calle" type="text" class="form-control campoIzquierdo campoCalle" placeholder="Calle">
              <input name="altura" type="numeric" class="form-control campoDerecho" placeholder="Altura">
              <textarea name="descripcion" placeholder="Descripcion" maxlength="100" class="form-control campoDescripcion"></textarea>
          </form> 
          <!-- COdigo hardcodeado para subir una imagen al mapa 62 -->
          <!-- ../inicio/subirImagen/62 -->

          <form id="my-awesome-dropzone"  class="dropzone cargarImagenes">  
              <div class="dropzone-previews"></div>
              <div class="fallback"> 
                <input name="file" type="file" multiple />
              </div>
          </form>

          <!-- <form id="my-awesome-dropzone" action="../inicio/subirImagen/62" class="dropzone cargarImagenes">  
              <div class="dropzone-previews"></div>
              <div class="fallback"> 
                <input name="file" type="file" multiple />
              </div>
          </form> -->
 
        </div>

         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button id="modaInfoBacheAceptar" type="button" class="btn btn-primary" data-dismiss="modal">Guardar Bache</button>
        </div>
    </div>
  </div>
</div>


<div id="canvasMapa" class="contenedorMapa"> Mapa </div>