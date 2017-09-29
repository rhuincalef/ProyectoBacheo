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
            /*
                  if ($logueado) {
                    echo '<li>';
                    echo "<!-- Menu Toggle Script -->";
                    echo '<a id="menu-toggle" href="#menu-toggle">';
                    echo '<i class="fa fa-list-ul" aria-hidden="true">';
                    echo "</i> Sidebar</a>";
                    echo "<script>";
                    echo '$("#menu-toggle").click(function(e) {';
                    echo "e.preventDefault();";
                    echo '$("#wrapper").toggleClass("toggled");';
                    echo "});";
                    echo "</script>";
                    echo "</li>";
                  }
                  */
            ?>
              <li><a href="<?php echo $this->config->base_url();?>"><i class="fa fa-home fa-fw fa-lg"></i>Principal</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa cf-bache"></i> Baches<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li id="opcionAgregar" ><a><i class="fa fa-plus-circle"> </i> Agregar</a></li>
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
                          <!-- <div class="checkbox">
                            <label>
                              <input type="checkbox" value="remember-me"> Recordar
                            </label>
                          </div> -->
                          <button class="btn btn-lg btn-primary btn-block inicioSesion" type="submit">Entrar</button>
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
                          echo '<li><a href="'.$this->config->base_url().'index.php/registrarUsuario"><i class="fa fa-cogs"> </i> Registrar Usuarios</a></li>';
                      }
                      echo '<script type="text/javascript"> logearGraficamente("'.$usuario.'");</script>';
                  }?>
                  <li class="divider"></li>
                  <li><a id="cerrarSesion" href="#"><i class="fa fa-lock"> </i> Cerrar Sesión</a></li>
                </ul>
              </li>
              <li><a href="#"><i class="fa fa-question-circle"> </i> Ayuda</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
</div>
</header>
<?php $this->load->view('ayudaModal.php'); ?>