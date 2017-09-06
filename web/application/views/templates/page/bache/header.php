<header class="navbar-inverse " role="banner">
<div class="container">
      <!-- Static navbar -->
      <div class="navbar navbar-default barra" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand logotipo"> <img src="<?php echo $this->config->base_url(); ?>_/img/trelew.svg">  Bacheo Trelew</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?php echo $this->config->base_url();?>"><i class="fa fa-home fa-fw fa-lg"></i>Principal</a></li>
            </ul>
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
                  <li class="divider"></li>
                  <?php 
                  if ($logueado) {
                      if ($admin) {
                          echo '<li><a href="'.$this->config->base_url().'index.php/registrarUsuario"><i class="fa fa-cogs"> </i> Registrar Usuarios</a></li>';
                      }
                      echo '<script type="text/javascript"> logearGraficamente("'.$usuario.'");</script>';
                  }?>
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