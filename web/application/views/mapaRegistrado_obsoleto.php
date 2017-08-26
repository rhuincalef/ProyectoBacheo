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
              <textarea name="descripcion" placeholder="Descripcion" maxlength="100" class="form-control campoDescripcion"></textarea>
          </form> 


          <!-- <form id="my-awesome-dropzone" action="/upload" class="dropzone cargarImagenes">   -->
          <form id="imagenesForm" action="./index.php/inicio/subirImagen/21" class="dropzone cargarImagenes">  
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

<div id="wrapper">
<!-- Sidebar -->
<div id="sidebar-wrapper">
  <ul class="sidebar-nav">
      <li class="sidebar-brand">
          <a href="#">
              Filtrar calles por Fallas
          </a>
      </li>
      <li hidden="">
          <a href="#">Seleccionar Calle: </a>
          <!-- <label>Seleccionar Calle: </label> -->
      </li>
      <li>
        <form role="search">
            <div class="form-group">
              <!--<i class="fa fa-search"></i>-->
              <input id="buscarCalleSideBar" type="text small" placeholder="9 de Julio" style="height: 2em;" />
            </div>
        </form>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown"> Tipos de Falla <b class="caret"></b>
        </a>
      </li>
      <ul class="dropdown-menu" role="menu">
        <li><a href="#">Grietas</a></li>
        <li><a href="#">Baches</a></li>
      </ul>
      <li>
        <button id="buscarFallasCalle" class="btn btn-primary" style="width: 83.4%; margin-top:2em;"> Buscar</button>
      </li>
      <!--
      -->
  </ul>
</div>
<!-- /#sidebar-wrapper -->
<!--
-->
</div>
<div id="canvasMapa" class="contenedorMapa"> Mapa </div>