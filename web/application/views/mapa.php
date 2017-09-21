<div id="informacionBache" class="modal fade informacionBache" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header tituloFormularioBache">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Información sobre Falla</h4>
      </div>

        <div class="contenedorCampos">
          <form id="formularioBache">
              <input name="calle" type="text" class="form-control campoIzquierdo campoCalle" placeholder="Calle">
              <button id="seleccionarCalle" type='button' class="seleccionarCalle" rel="tooltip" title="Marcar calle en el Mapa" ><i class="fa fa-crosshairs"></i></button>
              <input name="altura" type="numeric" class="form-control campoDerecho" placeholder="Altura">
              <div id="contenedorSelect" class="input-group tipoFalla"></div>
              <textarea name="descripcion" placeholder="Observación" maxlength="100" class="form-control campoDescripcion"></textarea>
          </form> 
          <form id="imagenesForm" action="./index.php/inicio/subirImagen/21" class="dropzone cargarImagenes">
              <div class="dropzone-previews"></div>
              <div class="fallback"> <!-- this is the fallback if JS isn't working -->
              <input name="file" type="file" multiple />
              </div>
          </form>
        </div>
         <div class="modal-footer">
           <div class="row"> 
            <button type="button" style="width: 45%;" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="modaInfoBacheAceptar" style="width: 45%; margin-right: 4%" type="button" class="btn btn-primary" data-dismiss="modal">Guardar Bache</button>
           </div>
        </div>
    </div>
  </div>
</div>
<div id="canvasMapa" class="contenedorMapa"> Mapa </div>