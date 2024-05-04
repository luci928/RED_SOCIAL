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
<html class="no-js">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REDSOCIAL</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="style_css/princi.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">

  <link rel="stylesheet" href="dist/css/AdminLTE.css">

  <link rel="stylesheet" href="dist/css/skins/_all-skins.css">

  <link rel="stylesheet" type="text/css" href="css/component.css" />

  <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="js/jquery.jscroll.js"></script>

    <style type="text/css">
        .scroll {
            width: 100%;
        }

        .scroll.jscroll-loading {
            width: 10%;
            margin: -500px auto;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php echo Headerb ($connect); ?>

<?php echo Side ($connect); ?>

  <div class="content-wrapper">

    <section class="content">

      <div class="row">
        <div class="col-md-8">
          <!-- /.box -->
          <div class="row">
            <div class="col-md-12">              
              <div class="box box-primary direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">¿Qué estás pensando?</h3>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
              </div>
                <div class="box-footer">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                      <textarea name="publicacion" onkeypress="return validarn(event)" placeholder="¿Qué estás pensando?" class="form-control" cols="200" rows="3" required></textarea>
                      <br><br><br><br>

                      <input type="file" name="foto" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"/>
                      <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Sube una foto</span></label>

                    <br>

                      <button type="submit" name="publicar" class="btn btn-primary btn-flat">Publicar</button>
                    </div>
                  </form>

                  <?php
                  if(isset($_POST['publicar'])) 
                  {
                    $publicacion = mysqli_real_escape_string($connect,$_POST['publicacion']);

                    $result = mysqli_query($connect, "SHOW TABLE STATUS WHERE `Name` = 'publicaciones'");
                    $data = mysqli_fetch_assoc($result);
                    $next_increment = $data['Auto_increment'];

                    $alea = substr(strtoupper(md5(microtime(true))), 0,12);
                    $code = $next_increment.$alea;

                    $type = 'jpg';
                    $rfoto = $_FILES['foto']['tmp_name'];
                    $name = $code.".".$type;

                    if(is_uploaded_file($rfoto))
                    {
                      $destino = "publicaciones/".$name;
                      $nombre = $name;
                      copy($rfoto, $destino);
                    }
                    else
                    {
                      $nombre = '';
                    }
                    $subir = mysqli_query($connect,"INSERT INTO publicaciones (usuario,fecha,contenido,imagen,comentarios) values ('".$_SESSION['id']."',now(),'$publicacion','$nombre','1')");

                    if($subir) {echo '<script>window.location="index.php"</script>';}
                  }     
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="scroll">
            <?php require_once 'publicaciones.php'; ?>
          </div>

            <script>

            $(document).ready(function() {
              $('.scroll').jscroll({
                loadingHtml: '<img src="imagenes/carga.jpg" alt="Loading" style="width: 20px; height: 20px;">' // Ajusta el ancho y alto aquí
        });
            });
            </script>
        </div>
        <div class="col-md-4">          
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Solicitudes de amistad</h3>
            </div>

            <div class="box-body">   
            </div>
          </div>
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
                      <img src="avatars/<?php echo $reg['avatar']; ?>" class="kgaste" alt="User Image" width="200" height="200">
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

  <aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">   
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">Chat Settings</h3>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
        </form>
      </div>
    </div>
  </aside>

  <div class="control-sidebar-bg"></div>

</div>
<script src="js/funtion.js"></script>

<script src="dist/js/app.js"></script>

<script src="js/publicacion.js"></script>

</body>

<script>
        $(document).ready(function() {
            $('.scroll').jscroll({
                loadingHtml: '<img src="images/invisible.png" alt="Loading" />',
                autoTrigger: true,
                padding: 0,
                nextSelector: 'a.jscroll-next:last',
                contentSelector: '.scroll',
                callback: function() {
                    $('ul.pagination:visible:first').hide();
                }
            });
        });
    </script>

</html>