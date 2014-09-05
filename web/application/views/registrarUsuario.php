 <div class="contenedorJumbotron">
  <div class="jumbotron personalizacionJumbotron">
          
        <h1>Registrar Usuarios</h1>

  </div>

</div>
 

    <div class="container">
      <!-- <div class="alert alert-success" role="alert"> -->
      <!-- <div class="alert alert-danger" role="alert"> -->
      <div class="alert hide" role="alert">
        <!-- <a href="#" class="alert-link"></a> -->
      </div>
      <!-- <form id="registrarUsuario" class="form-signin" method="post" action="<?php echo base_url();?>/index.php/inicio/create_user"> -->
      <form id="registrarUsuario" class="form-signin" action="<?php echo base_url();?>/index.php/auth/create_user">
        <h4 class="form-signin-heading">Por favor ingrese la información de usuario a continuación.</h4>
        <input type="text" class="form-control" placeholder="First name*" required autofocus name="register_first_name">
        <br>
        <input type="text" class="form-control" placeholder="Last name*" required name="register_last_name">
        <br>
        <input type="text" class="form-control" placeholder="Phone" name="register_phone_number">
        <br>
        <input type="email" class="form-control" placeholder="Email address*" required name="register_email_address">
        <br>
        <input type="text" class="form-control" placeholder="Username*" required name="register_username">
        <br>
        <input type="password" class="form-control" placeholder="Password*" required name="register_password">
        <br>
        <input type="password" class="form-control" placeholder="Confirm Password*" required name="register_confirm_password">
        <br>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
      </form>

    </div> <!-- /container -->
