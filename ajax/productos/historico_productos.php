<?php
	/*-------------------------
	Autor: Armando Castillo Rojas
	Proyecto: Gestion de equipos
	Matricula: ES1410904543
  Universidad: UnADM
	---------------------------*/
	require_once ("../config/db.php");//configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//funcion que conecta a la base de datos
	if (isset($_POST['id']))
	{
		$id_historial = $_POST['id'];
?>
<!-- Modal -->
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Historico producto</h4>
		</div>
		<div class="modal-body">

		<form class="form-horizontal" method="post" id="historico_producto" name="historico_producto">
		<?php 
			$query_data=mysqli_query($con,"select * from productos where id_producto='$id_historial'");
			$row=mysqli_fetch_array($query_data);
		?>
		<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" value="<?php echo $row['codigo_producto']?>" required readonly>
				</div>
			</div>
			
			<div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required readonly><?php echo $row['nombre_producto']?></textarea>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th>Fecha</th>
						<th>Acción</th>
					</tr>
					<?php
						$query_historial=mysqli_query($con,"select * from historial where id_producto='$id_historial' order by id_historial");
						while($rw=mysqli_fetch_array($query_historial)) {
					?>
					<tr>					
						<td><?php echo $rw['fecha'];?></td>
						<td><?php echo $rw['log'];?></td>				
					</tr>
					<?php
					}
					?>
				</table>
			</div>		
		</div>

		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
		</form>
	</div>
	</div>
<?php
}
?>

<!-- Modal -->