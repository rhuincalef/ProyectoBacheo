<link href="<?php echo $this->config->base_url(); ?>_/css/header.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>_/js/header.js"></script>
<div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default barra" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span></span>pan class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding-top: 0%;"> <img style="width: 70px; height: 50px" src="<?php echo $this->config->base_url(); ?>_/img/trelew.svg">  Bacheo Trelew</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="#"><i class="fa fa-home fa-fw fa-lg"></i>Principal</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-map-marker"></i> Baches<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><i class="fa fa-plus-circle"> </i> Agregar</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li id="opcionInicioSesion" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i> Iniciar Sesión <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li> 
                    <div> 
                      <form id="inicioSesion" class="navbar-form navbar-left">
                          <input type="text" class="form-control inicioSesion" placeholder="Usuario"/>
                          <input type="Password" class="form-control inicioSesion" placeholder="Contraseña"/>
                          <button type="submit" class="btn btn-primary inicioSesion">Entrar</button>
                      </form>
                  </div>
                </li>
          
              </ul>
              </li>
              <li id="opcionSesion" class="dropdown hide">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i> Hi, Pablo <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><i class="fa fa-cogs"> </i> Actividad del Sistema</a></li>
                  <li class="divider"></li>
                  <li><a id="cerrarSesion" href="#"><i class="fa fa-lock"> </i> Cerrar Sesión</a></li>
                </ul>
              </li>
              <li><a href="#"><i class="fa fa-question-circle"> </i> Ayuda</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
      
     <!--  <div class="jumbotron">
        <h1>Trelew: Lugar de Oportunidades</h1>
        <p>iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii.</p>
      </div> -->
</div>