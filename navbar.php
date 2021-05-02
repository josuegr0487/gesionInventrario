<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

if (isset($title)) {
?>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">CREAKTO    - Gestion de Inventario</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">

          <li class="dropdown <?php if (isset($active_dropdown)) {
                                echo $active_dropdown;
                              } ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-list-alt"></i> Catálogos <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="<?php if (isset($active_medida)) {
                            echo $active_medida;
                          } ?>"><a href="unidad_medida.php">Unidad de Medida</a></li>
              <li class="<?php if (isset($active_proyecto)) {
                            echo $active_proyecto;
                          } ?>"><a href="proyectos.php">Proyecto</a></li>
              <li class="<?php if (isset($active_productos)) {
                            echo $active_productos;
                          } ?>"><a href="productos.php">Productos</a></li>
              <li role="separator" class="divider"></li>
              <li class="<?php if (isset($active_usuarios)) {
                            echo $active_usuarios;
                          } ?>"><a href="usuarios.php">Usuarios</a></li>
            </ul>
          </li>


          <li class="<?php if (isset($active_inventario)) {
                        echo $active_inventario;
                      } ?>"><a href="gestion.php"><i class='glyphicon glyphicon-barcode'></i> Inventario</a></li>
          <li class="<?php if (isset($active_entradas)) {
                        echo $active_entradas;
                      } ?>"><a href="entradas.php"><i class='glyphicon glyphicon-save'></i> Entradas</a></li>
          <li class="<?php if (isset($active_salidas)) {
                        echo $active_salidas;
                      } ?>"><a href="salidas.php"><i class='glyphicon glyphicon-open'></i> Salidas</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
<?php
}
?>