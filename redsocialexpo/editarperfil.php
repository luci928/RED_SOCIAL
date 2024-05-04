<?php
session_start();
include 'lib/config.php';
include 'lib/socialnetwork-lib.php';


if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<htmL>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EDITAR MI PERFIL</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="style_css/princi.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <link rel="stylesheet" href="style_css/princi.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php echo Headerb($connect); ?>
<?php echo Side($connect); ?>
<?php
if(isset($_GET['id']))
{
$id = mysqli_real_escape_string($connect,$_GET['id']);

$miuser = mysqli_query($connect,"SELECT * FROM usuarios WHERE id_use = '$id'");
$use = mysqli_fetch_array($miuser);

if($_SESSION['id'] != $id) {
?>
<script type="text/javascript">window.location="login.php";</script>
<?php
}
?>
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar mi perfíl</h3>
            </div>
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre completo</label>
                  <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="<?php echo $use['nombre'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $use['usuario'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $use['email'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Cambiar mi avatar</label>
                  <input type="file" name="avatar">
                </div>
                <div class="checkbox" required>
                  <input type="radio" value="H" name="sexo" <?php if($use['sexo'] == 'H') { echo 'checked'; } ?> required> Hombre <br>
                  <input type="radio" value="M" name="sexo" <?php if($use['sexo'] == 'M') { echo 'checked'; } ?>> Mujer
                </div>
                <div class="form-group">
                  <label>Fecha de nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" name="nacimiento" placeholder="<?php echo $use['nacimiento'];?>" class="form-control" >
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar datos</button>
              </div>
            </form>
          </div>
          <?php
          if(isset($_POST['actualizar']))
          {
            $nombre = mysqli_real_escape_string($connect,$_POST['nombre']);
            $usuario = mysqli_real_escape_string($connect,$_POST['usuario']);
            $email = mysqli_real_escape_string($connect,$_POST['email']);
            $sexo = mysqli_real_escape_string($connect,$_POST['sexo']);
            $nacimiento = mysqli_real_escape_string($connect,$_POST['nacimiento']);
            
            if($nacimiento != '') {$nac = $nacimiento;} else {$nac = $use['nacimiento'];}

            $comprobar = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM usuarios WHERE usuario = '$usuario' AND id_use != '$id'"));
            if($comprobar == 0){
              $type = 'jpg';
              $rfoto = $_FILES['avatar']['tmp_name'];
              $name = $id.'.'.$type;

              if(is_uploaded_file($rfoto))
              {
                $destino = 'avatars/'.$name;
                $nombrea = $name;
                copy($rfoto, $destino);
              }
              else
              {
                $nombrea = $use['avatar'];
              }

              $sql = mysqli_query($connect,"UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', email = '$email', sexo = '$sexo', nacimiento = '$nac', avatar = '$nombrea' WHERE id_use = '$id'");

              if($sql) {echo "<script type='text/javascript'>window.location='editarperfil.php?id=$_SESSION[id]';</script>";}
            } else {echo 'El nombre de usuario ya está en uso, escoja otro';}
          }
          ?>
        </div>
        <div class="col-md-4">          
        </div>
        <div class="col-md-4">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Últimos registrados</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
              <?php $registrados = mysqli_query($connect,"SELECT avatar,usuario,fecha_reg FROM usuarios order by id_use desc limit 8");
              while($reg=mysqli_fetch_array($registrados)) 
              {
              ?>
                <li>
                  <img src="avatars/<?php echo $reg['avatar']; ?>" class="kgaste" alt="User Image">
                  <a class="users-list-name" href="#"><?php echo $reg['usuario']; ?></a>
                  <span class="users-list-date">Hoy</span>
                </li>
              <?php
              }
              ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<script src="js/funtion.js"></script>
<script src="dist/js/app.js"></script>
<script>
  $(function () {
    $("[data-mask]").inputmask();
  });
</script>
</body>
</html>
<?php }
