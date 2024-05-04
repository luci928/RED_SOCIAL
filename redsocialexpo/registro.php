
<?php

session_start();
include 'lib/config.php';

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php ?> Registro</title>

  <link rel="stylesheet" href="style_css/registro.css">
  </head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href=""><b>G</b>LAJ</a>
  </div>
  <div class="box">
    <div class="register-box-body">
      <p class="login-box-msg">Regístrate</p>
      <form action="#" name="redsocial" method="post">
        <div class="form-group has-feedback">
          <input type="text" name="nombre" class="form-control" placeholder="Nombre completo"value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" required>
        </div>
        <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required> 
        </div>
        <div class="form-group has-feedback">
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" required>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="repcontrasena" class="form-control" placeholder="Repita la contraseña" required>
        </div>
        <div class="row">
          <div class="col-xs-10">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="check" required> Acepto los <a href="https://www.fibralink.es/terminos-y-condiciones-redes-sociales/">términos y condiciones</a>
              </label>
            </div>
          </div>
          <div class="col-xs-12">
            <input type="submit" name="registrar" class="btn btn-primary btn-block btn-flat" value="Registrarse"></input>
          </div>
        </div>
    </div>
    </div>
    </form>

    <?php
    if (isset($_POST["registrar"])) {
        $nombre = $_POST["nombre"];
        $email =  $_POST["email"];
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $repcontrasena = $_POST["repcontrasena"];

        $comprobarusuario = mysqli_num_rows(mysqli_query($connect,"SELECT usuario FROM usuarios WHERE usuario = '$usuario'"));
        $comprobaremail = mysqli_num_rows(mysqli_query($connect,"SELECT email FROM usuarios WHERE email = '$email'"));

        if ($comprobarusuario >= 1) {
    ?>
      <br>
      <div class="alert alert-danger alert-dismissible">
        <span  class="close" data-dismiss="alert" aria-hidden="true">&times;</span>
        El nombre de usuario está en uso, por favor escoja otro
      </div>
    <?php
        } else {
          if ($comprobaremail >= 1) {
    ?>
            <br>
            <div class="alert alert-danger alert-dismissible">
              <span  class="close" data-dismiss="alert" >&times;</span>
              El email ya está en uso por favor escoja otro o verifique si tiene una cuenta
            </div>
    <?php
          } else {
            if ($contrasena != $repcontrasena) {
            ?>
              <br>
              <div class="alert alert-danger alert-dismissible">
                <span  class="close" data-dismiss="alert" ></span>
                Las contraseñas no coinciden
              </div>
            <?php
            } else {
              $consulta= "INSERT INTO usuarios (nombre,email,usuario,contrasena,fecha_reg, avatar) VALUES ('$nombre','$email','$usuario','$contrasena',now(), 'defect.jpg')";
              $resultado = mysqli_query($connect,$consulta);
              if ($resultado) { 
            ?>
                <br>
                <div class="alert alert-success alert-dismissible">
                  <span  class="close" data-dismiss="alert" >&times;</span>
                  Felicidades se ha registrado correctamente
                </div>
            <?php
              }
            }
          }
        }
    }
    ?>
    <br>
    <a href="login.php" class="box"class="text-center">Iniciar sesión</a>
  </div>

<script src="js/funtion.js"></script>
</div>
</body>
</html>