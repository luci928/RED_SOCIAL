<?php
session_start();//
include 'lib/config.php';//

if(isset($_SESSION['usuario'])) {//
    header("Location: index.php");//
}
?>
<!DOCTYPE html>//
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenido a GLAJ</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="style_css/login.css">
</head>
<body class="hold-transition login-page">
  
    <div class="login-box">
        <div class="login-logo">
          <a href=""><b>G</b>LAJ</a></div>
        <div class="box">
        <div class="login-box-body">
          
          <p class="login-box-msg">Bienvenido a GLAJ</p>
          <form action="" method="post">///////////
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Usuario" name="usuario" required>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" required>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
              </div>
            </div>
            </div>
        </div>
      </form>

      <?php
      if(isset($_POST['login'])) /////////
      {
        $usuario = mysqli_real_escape_string($connect,$_POST['usuario']);
        $usuario = strip_tags($_POST['usuario']);
        $usuario = trim($_POST['usuario']);

        $contrasena = mysqli_real_escape_string($connect,md5($_POST['contrasena']));
        $contrasena = strip_tags($_POST['contrasena']);
        $contrasena = trim($_POST['contrasena']);

        $query = mysqli_query($connect,"SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'");
        $contar = mysqli_num_rows($query);
        
        if($contar == 1) {
          while($row=mysqli_fetch_array($query)) {
            if($usuario == $row['usuario'] && $contrasena == $row['contrasena'])
            {
              $_SESSION['usuario'] = $row['usuario'];/////////
              $_SESSION['id'] = $row['id_use'];
              $_SESSION['avatar'] = $row['avatar'];
              header('Location: index.php');
            }
          }
        } else {
          echo '<span class="alert alert-danger">Los datos ingresados no son correctos</span>';//
        }
      } ?>
      <br>
      <div class="box">
      <a href="registro.php" class="text-center">Registrarme en REDSOCIAL</a>
      </div>
    </div>
  </div>
</body>
</html>