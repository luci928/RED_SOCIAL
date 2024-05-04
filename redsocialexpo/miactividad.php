<?php
include 'lib/config.php';/////
?>

<script type="text/javascript">
</script>

<?php
$CantidadMostrar=5;/////
$aid = mysqli_real_escape_string($connect,$_GET['id']);
$compag = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
$TotalReg = mysqli_query($connect,"SELECT * FROM publicaciones WHERE usuario = '$aid'");
$totalr = mysqli_num_rows($TotalReg);
$TotalRegistro = ceil($totalr/$CantidadMostrar);
$IncrimentNum = (($compag + 1) <= $TotalRegistro) ? ($compag + 1) : 0;
$consultavistas = "SELECT */////////////////////
    FROM
    publicaciones WHERE usuario = '$aid'
    ORDER BY
    fecha DESC LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
$consulta = mysqli_query($connect,$consultavistas);
while ($lista = mysqli_fetch_array($consulta)) {////////////////

  $userid = mysqli_real_escape_string($connect,$lista['usuario']);
  $usuariob = mysqli_query($connect,"SELECT * FROM usuarios WHERE id_use = '$userid'");
  $use = mysqli_fetch_array($usuariob);
  $fotos = mysqli_query($connect,"SELECT * FROM fotos WHERE publicacion = '$lista[fecha]'");
  $fot = mysqli_fetch_array($fotos);
?>
  <div class="box box-widget">/////////////
    <div class="box-header with-border">
      <div class="user-block">
        <img class="img-circle" src="avatars/<?php echo $use['avatar']; ?>" alt="User Image">
        <span class="description" onclick="location.href='perfil.php?id=<?php echo $use['id_use'];?>';" style="cursor:pointer; color: #3C8DBC;""><?php echo $use['usuario'];?></span>
        <span class="description"><?php echo $lista['fecha'];?></span>
      </div>
      <div class="box-tools">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      <p><?php echo $lista['contenido'];?></p>
      <?php if(!empty($lista['imagen'])): ?>
        <img src="publicaciones/<?php echo $lista['imagen'];?>.jpg" width="500" height="flex">
      <?php endif; ?>
      <br><br>
      <ul class="list-inline">
        <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Compartir </button>
        <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share-o-up"></i> Me gusta </button>
      </ul>
    </div>
  </div>

  <br><br>

<?php
}
if($IncrimentNum <= 0) {} else {//////////////
  echo "<a href=\"miactividad.php?id=$aid&pag=".$IncrimentNum."\">Seguiente</a>";
}
?>

<script>
$(document).ready(function() {///////////////
  $('.scroll').jscroll({
    loadingHtml: '<img src="images/invisible.png" alt="Loading" />'
  });
});
</script>