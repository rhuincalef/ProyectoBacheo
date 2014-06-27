<div id="informacionBache" class="modal fade informacionBache" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header tituloFormularioBache">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
        <h4 class="modal-title">Información sobre Bache</h4>
      </div>

        <div class="contenedorCampos">
          <form id="formularioBache">
              <input name="titulo" type="text" class="form-control campoIzquierdo" placeholder="Titulo">
              <select id="criticidad" class="form-control campoDerecho">
                <option value="0">Pequeño</option>
                <option value="1">Mediano</option>
                <option value="2">Grande</option>
              </select>
              
              <button class="seleccionarCalle" rel="tooltip" title="Marcar calle en el Mapa" ><i class="fa fa-crosshairs"></i></button>
              <input name="calle" type="text" class="form-control campoIzquierdo campoCalle" placeholder="Calle">
              <input name="altura" type="numeric" class="form-control campoDerecho" placeholder="Altura">
              <textarea name="descripcion" placeholder="Descripcion" maxlength="100" class="form-control campoDescripcion"></textarea>
            </form> 
            <form id="my-awesome-dropzone" action="/upload" class="dropzone cargarImagenes">  
        <div class="dropzone-previews"></div>
        <div class="fallback"> <!-- this is the fallback if JS isn't working -->
        <input name="file" type="file" multiple />
        </div>

    </form>
 
        </div>

         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button id="modaInfoBacheAceptar" type="button" class="btn btn-primary" data-dismiss="modal">Guardar Bache</button>
        </div>
    </div>
  </div>
</div>


<div id="canvasMapa" class="contenedorMapa"> Mapa </div>