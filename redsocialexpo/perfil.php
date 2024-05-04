<?php session_start();
include 'lib/config.php';
include 'lib/socialnetwork-lib.php';

if(!isset($_SESSION['usuario'])) {
  header("Location: login.php");
} ?>///////////////////

<?php
  if(isset($_GET['id'])) 
  {
    $id = mysqli_real_escape_string($connect,$_GET['id']);
    $infouser = mysqli_query($connect,"SELECT * FROM usuarios WHERE id_use = '$id'");
    $use = mysqli_fetch_array($infouser);
    $amistad = mysqli_query($connect, "SELECT * FROM amigos WHERE (de = '".$_SESSION['id']."' AND para = '$id') OR (de = '$id' AND para = '".$_SESSION['id']."')");
    $ami = mysqli_fetch_array($amistad);

     ?>/////////////
    
    <!DOCTYPE html>//////////
      <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <title><?php echo $use['nombre']; ?> | REDSOCIAL</title>
          <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
          <link rel="stylesheet" href="style_css/princi.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css">
          <link rel="stylesheet" href="dist/css/AdminLTE.css">
          <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
          
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
          <script src="js/jquery.jscroll.js"></script>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
          <div class="wrapper">
            <?php echo Headerb ($connect); ?>
            <?php echo Side ($connect); ?>
            <div class="content-wrapper">
              <section class="content">
                <div class="row">
                  <div class="col-md-3">
                    <div class="box box-primary">
                      <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive" src="avatars/<?php echo $use['avatar'];?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $use['nombre'];?></h3> 
                       
                        <p clas s="text-muted text-center">Software Engineer</p>
                        <ul class="list-group list-group-unbordered">
                          <li class="list-group-item">
                            <b>Followers</b> <a class="pull-right">1,322</a>
                          </li>
                          <li class="list-group-item">
                            <b>Following</b> <a class="pull-right">543</a>
                          </li>
                          <li class="list-group-item">
                            <b>Friends</b> <a class="pull-right">13,287</a>
                          </li>
                        </ul>           
                        <?php if($_SESSION['id'] != $id) /////////////
                        
                        {?>
                          <form action="" method="post">             
                          
                          <?php
                           
                            if ($ami) 
                            { 
                              if ($ami['estado'] == 1) {
                                  echo '<input type="submit" class="btn btn-danger btn-block" name="dejarseguir" value="Dejar de seguir">';
                              } else {
                                  echo '<input type="submit" class="btn btn-primary btn-block" name="seguirdirecto" value="Seguir">';
                              }
                           } 
                            else { 
                                echo '<input type="submit" class="btn btn-primary btn-block" name="seguirdirecto" value="Seguir">';
                            }
                            ?>
                           <?php }?>
                          </form>
                        <?php if(isset($_POST['seguirdirecto'])) {
                          $add = mysqli_query($connect, "INSERT INTO amigos (de,para,fecha,estado) values ('".$_SESSION['id']."','$id',now(),'1')");
                          if($add) {
                            echo '<script>window.location="perfil.php?id='.$id.'"</script>';
                          }
                        } ?>
                        <?php if(isset($_POST['dejarseguir'])) {
                          $add = mysqli_query($connect,"DELETE FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
                          if($add) {
                            echo '<script>window.location="perfil.php?id='.$id.'"</script>';
                          }
                        } ?>
                        <br>
                        <a href="chat.php?usuario=<?php echo $id; ?>"><input type="button" class="btn btn-default btn-block" name="dejarseguir" value="Enviar chat"></a>
                      </div>
                    </div>
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">About Me</h3>
                      </div>
                      <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
                        <p class="text-muted">B.S. in Computer Science from the University of Tennessee at Knoxville</p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                        <p class="text-muted">Malibu, California</p>
                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                        <p>
                          <span class="label label-danger">UI Design</span>
                          <span class="label label-success">Coding</span>
                          <span class="label label-info">Javascript</span>
                          <span class="label label-warning">PHP</span>
                          <span class="label label-primary">Node.js</span>
                        </p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="<?php echo $pag == 'miactividad' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=miactividad">Actividad</a></li>                            
                      </ul>
                      <div class="tab-content">         
                        <div class="scroll">///////////////////
                                  
                          <?php $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'miactividad';
                            require_once $pagina.'.php'; ?>
                        </div>                            
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <script src="js/funtion.js"></script>
          <script src="dist/js/app.js"></script>////no
        </body>
      </html>
<?php } ?>