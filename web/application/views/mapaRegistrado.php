<!-- Modal Agragar Bache -->
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
          <button type="button" style="width: 45%;" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button id="modaInfoBacheAceptar" style="width: 45%; margin-right: 4%" type="button" class="btn btn-primary" data-dismiss="modal">Guardar Bache</button>
        </div>
    </div>
  </div>
</div>
<!-- /#Modal Agragar Bache -->
<!-- wrapper -->
<div id="wrapper">
	<!-- Sidebar -->
	<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
	    <ul class="nav sidebar-nav">
	        <li class="brand">
	            <a href="#">
	               Opciones
	            </a>
	        </li>
	        <li>
	        	<div class="panel panel-default panel-side-bar">
	        		<div class="panel-body">
	        			<div class="btn-group btn-input clearfix">
	        				<button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
	        					<span data-bind="label">Seleccionar</span>&nbsp;<span class="caret"></span>
	        				</button>
	        				<ul class="dropdown-menu dropdown-menu-side-bar" role="menu">
								<li><a href="#">Filtrado de fallas por calle</a></li>
							</ul>
	        			</div>
	        		</div>
	        	</div>
	        </li>
	        <li class="formulario-side-bar">
	        	 <form class="navbar-form navbar-left" role="search" style="width: 100%;">
					<div class="form-group" style="width: 100%; display: block;">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-search"></i></span>
							<input id="buscarCalleSideBar" type="text small" placeholder="9 de Julio" style="height: 2em; height: 2em; float: left; width: 100%;" />
						</div>
					</div>
	        		<a id="seleccionarTipoFallaSideBar" href="#"> Seleccionar Tipo de Falla
	        			<span class="caret"></span>
	        		</a>
	        		<div id="tipoFallaCheckbox">
	        		</div>
	        		<a id="seleccionarTipoEstadoSideBar" href="#"> Seleccionar Estado de Falla
	        		<span class="caret"></span>
	        		</a>
	        		<div id="tipoEstadoCheckbox">
	        		</div>
	        		<button id="trazarRuta" type="button" class="btn btn-primary col-md-12"> Buscar</button>
	        		<button id="limpiarRuta" type="button" class="btn btn-primary col-md-12"> Limpiar Ruta</button>
	        	</form>
	        </li>
	    </ul>
	</nav>
	<!-- /#sidebar-wrapper -->
	<!-- Page Content -->
	<div id="page-content-wrapper">
		<button id="menu-toggle" class="btn btn-primary btn-side-bar" style="position: fixed; float: left; display: block; z-index: 999;" data-toggle="offcanvas">
			<i class="fa fa-list-ul" aria-hidden="true"></i>
		</button>
		<header class="navbar-inverse " role="banner">
		<div class="container">
			<!-- Static navbar -->
			<div class="navbar navbar-default barra" role="navigation">
				<div class="container-fluid">
				  <div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				      <span class="sr-only">Toggle navigation</span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				    </button>
				    <a class="navbar-brand logotipo"> <img src="<?php echo $this->config->base_url(); ?>_/img/trelew.svg">  Bacheo Trelew</a>
				  </div>
				  <div class="navbar-collapse collapse">
				    <ul class="nav navbar-nav">
				    <?php 
				          if ($logueado) {
				            echo "<script>";
				            echo '$("#menu-toggle").click(function(e) {';
				            echo "e.preventDefault();";
				            echo '$("#wrapper").toggleClass("toggled");';
				            echo "});";
				            echo "</script>";
				          }
				    ?>
				      <li><a href="<?php echo $this->config->base_url();?>"><i class="fa fa-home fa-fw fa-lg"></i>Principal</a></li>
				      <li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-map-marker"></i> Baches <b class="caret"></b></a>
				        <ul class="dropdown-menu">
				          <li id="opcionAgregar"><a href="#"><i class="fa fa-plus-circle"> </i> Agregar</a></li>
				          <li><a id="verReparadas" href="#"><i class="fa fa-eye"> </i> Fallas reparadas</a></li>
				        </ul>
				      </li>
				      <li class="dropdown">
				      	<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa cf-bache"></i> Tipo Falla <b class="caret"></b></a>
				      	<ul class="dropdown-menu">
				      		<li><a target="_blank" href="<?php echo $this->config->base_url().'publico/creacionTipoFalla';?>"><i class="fa fa-plus-circle"> </i> Agregar</a>
				      		</li>
				      	</ul>
				      </li>
				    </ul>

				     <form class="navbar-form navbar-left" role="search">
				      <div class="form-group cuadroBusqueda">
				        <input id="buscarCalle" type="text" placeholder="">
				        <i class="fa fa-search"></i>
				      </div>
				    </form>

				    
				    <ul class="nav navbar-nav navbar-right">
				      <li id="opcionInicioSesion" class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i> Iniciar Sesión <b class="caret"></b></a>
				        <ul class="dropdown-menu cuadroSesion">
				          <li> 
				            <div>
				              <div class="container">
				                <form id="inicioSesion" action="<?php echo $this->config->base_url(); ?>" class="form-signin">
				                  <h2 class="form-signin-heading">Inicio de Sesión</h2>
				                  <input type="text" class="form-control inicioSesion" placeholder="Usuario" required autofocus>
				                  <input type="password" class="form-control inicioSesion" placeholder="Password" required>
				                  <button class="btn btn-lg btn-primary btn-block inicioSesion">Entrar</button>
				                </form>
				              </div>
				          </div>
				        </li>
				  
				      </ul>
				      </li>
				      <li id="opcionSesion" class="dropdown hide">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i><b class="caret"></b></a>
				        <ul class="dropdown-menu">
				          <li><a href="#"><i class="fa fa-cogs"> </i> Actividad del Sistema</a></li>
				          <?php 
				          if ($logueado) {
				              if ($admin) {
				                  echo '<li><a target="_blank" href="'.$this->config->base_url().'index.php/registrarUsuario"><i class="fa fa-cogs"> </i> Registrar Usuarios</a></li>';
				              }
				              echo '<script type="text/javascript"> logearGraficamente("'.$usuario.'");</script>';
				          }?>
				          <li class="divider"></li>
				          <li><a id="cerrarSesion" href="#"><i class="fa fa-lock"> </i> Cerrar Sesión</a></li>
				        </ul>
				      </li>
				      <li><a id="ayuda" href="#"><i class="fa fa-question-circle"> </i> Ayuda</a></li>
				    </ul>
				  </div>
				  <!--/.nav-collapse -->
				</div>
				<!--/.container-fluid -->
			</div>
		</div>
		</header>
		<div id="canvasMapa" class="contenedorMapa"> Mapa </div>
	</div>
	<!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->