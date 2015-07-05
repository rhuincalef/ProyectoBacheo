 <div class="contenedorJumbotron">
  <div class="jumbotron personalizacionJumbotron">
          
        <h1>Inicio de Sesion Requerido</h1>

  </div>

</div>
 

    <div class="container">
      <!-- <div class="alert alert-success" role="alert"> -->
      <!-- <div class="alert alert-danger" role="alert"> -->
      <div class="alert hide" role="alert">
        <!-- <a href="#" class="alert-link"></a> -->
      </div>
      <div class="contenedorFormularioLogin">
        <div>
          <form id="inicioSesion" class="form-signin" action="<?php echo $this->config->base_url();?>">
            <h4 class="form-signin-heading"> Por favor ingrese datos de Sesión.</h4>
            <input type="text" class="form-control" placeholder="Usuario*" required name="register_username">
            <br>
            <input type="password" class="form-control" placeholder="Password*" required name="register_password">
            <br>
            <br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
          </form>
        </div>
      </div>

    </div> <!-- /container -->
