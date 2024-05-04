<?php
include 'lib/config.php';

$CantidadMostrar = 5;
$compag = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? (int)$_GET['pag'] : 1;

$inicio = ($compag - 1) * $CantidadMostrar;

$consultavistas = "SELECT *
                    FROM
                    publicaciones
                    ORDER BY
                    fecha DESC
                    LIMIT $inicio, $CantidadMostrar";
$consulta = mysqli_query($connect, $consultavistas);

while ($lista = mysqli_fetch_array($consulta)) {
    $userid = mysqli_real_escape_string($connect, $lista['usuario']);
    $usuariob = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_use = '$userid'");
    $use = mysqli_fetch_array($usuariob);
    
    ?>
    <div class="box box-widget">
        <div class="box-header with-border">
            <div class="user-block">

            <?php 
            $confirmar = mysqli_query($connect,"SELECT avatar FROM usuarios WHERE id_use = '$userid'"); 
                 
            while($confir = mysqli_fetch_array($confirmar)) 
                  {
            ?>
                <img src="avatars/<?php echo $confir['avatar']; ?>" class="img-circle img-sm" alt="User Image">
            <?php
                  }
            ?>

                <span class="description" onclick="location.href='perfil.php?id=<?php echo $use['id_use'];?>';" style="cursor:pointer; color: #3C8DBC;""><?php echo $use['usuario'];?></span>
                
                <span class="description"><?php echo $lista['fecha']; ?></span>
            </div>
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
        <p><?php echo $lista['contenido'];?></p>

              
              <?php if(!empty($lista['imagen'])): ?>
        
                <img src="publicaciones/<?php echo $lista['imagen'];?>.jpg" width= 500 height> <!-- Modifica el tamaño aquí -->
                <?php endif; ?>
        <br><br>
            
            <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Compartir </button>
            <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share-o-up"></i> Me gusta </button>
        </div>
        <div class="box-footer box-comments">
            <div class="box-comment">

            
            </div>
            
        </div>
    </div>
    <br><br>
<?php
}

$IncrimentNum = $compag + 1;

if ($IncrimentNum > 0) {
    echo "<a href=\"publicaciones.php?pag=" . $IncrimentNum . "\"</a>";
}
?>
