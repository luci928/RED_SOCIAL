<?php
include("lib/config.php");
function Headerb ($connect) { ?>
<header class="main-header">
    <a href="index.php" class="logo">
      <span class="logo-lg"><b>G</b>LAJ</span></a>
    <nav class="navbar navbar-static-top">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php $confirmar2 = mysqli_query($connect,"SELECT avatar,usuario FROM usuarios WHERE id_use = '".$_SESSION['id']."'");
                  while($confir2 = mysqli_fetch_array($confirmar2)) {?>
            <img src="avatars/<?php echo isset($confir2['avatar']) ? $confir2['avatar'] : $confir2['avatar'] ?>"  class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ucwords($confir2['usuario']); ?></span></a>
              <?php } ?>
            <ul class="dropdown-menu">
              <?php $confirmar = mysqli_query($connect,"SELECT avatar,usuario FROM usuarios WHERE id_use = '".$_SESSION['id']."'");
                  while($confir = mysqli_fetch_array($confirmar)) {?>
                    <li class="user-header">
                      <img src="avatars/<?php echo $confir['avatar'] ?>" class="img-circle" alt="User Image">
                      <p>
                        <?php echo ucwords($confir['usuario']) ?>
                        <small>Miembro desde Mayo 31</small></p>
                    </li>
              <?php } ?>
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="#">Seguidores</a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="#">Seguidos</a>
                  </div>
                </div>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="editarperfil.php?id=<?php echo $_SESSION['id'];?>" class="btn btn-default btn-flat">Editar perfil</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Cerrar sesión</a></div>
              </li>
            </ul>
          </li>
          <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
        </ul>
      </div>
    </nav>
  </header>
<?php
}
?>

<?php 
include("lib/config.php");
function Side ($connect){ ?>
  <aside class="main-sidebar">
    <section class="sidebar">
      
    <?php $confirmar2 = mysqli_query($connect,"SELECT avatar,usuario FROM usuarios WHERE id_use = '".$_SESSION['id']."'");
                  while($confir2 = mysqli_fetch_array($confirmar2)) {?>

      <div class="user-panel">
        <div class="pull-left image">

          <img src="avatars/<?php echo isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'jpg'; ?>"  class="kgaste" class= "img-circle"  alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ucwords($_SESSION['usuario']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <?php } ?>
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Encuentra a tus amigos">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
        </div>
      </form>
      <ul class="sidebar-menu">
        <li class="header">MENÚ DE NAVEGACIÓN</li>
        <li>

        <li><a href="mensajes.php">
            <i class="fa fa-comment"></i> <span>Chat</span>
            
        <li><a href="index.php">
            <i class="fa fa-user"></i> <span>Mis seguidores</span>
          </a></li>
        <li><a href="index.php">
            <i class="fa fa-arrow-right"></i> <span>Seguidos</span>
          </a></li>
        <li><a href="index.php"><i class="fa fa-heart"></i> <span>Me gusta</span>
          </a></li>
          </ul>
        </li>
      </ul>
    </section>
  </aside>
<?php } ?>