<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

if (isset($con)) {
?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Alta producto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" enctype="multipart/form-data" method="post" id="guardar_producto" name="guardar_producto">
						<div id="resultados_ajax_productos"></div>
						<div class="form-group">
							<label for="codigo" class="col-sm-3 control-label">Código</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" required>
							</div>
						</div>

						<div class="form-group">
							<label for="nombre" class="col-sm-3 control-label">Descripción</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="nombre" name="nombre" placeholder="Descripción del producto" required maxlength="255"></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="imagen" class="col-sm-3 control-label">Imagen</label>
							<div class="col-sm-8">
								<img id="blah" style="max-height: 150px; width: auto" src="#" />
								<input id="imagen" name="imagen" type="file" accept="image/*">
							</div>
						</div>

						<div class="form-group">
							<label for="stock" class="col-sm-3 control-label">Stock</label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="stock" name="stock" placeholder="Stock del producto" value="0">
							</div>
						</div>

						<div class="form-group">
							<label for="unidad" class="col-sm-3 control-label">Unidad</label>
							<div class="col-sm-8">
								<select class='form-control' name='unidad' id='unidad' required>
									<option value="">Selecciona una unidad de medida</option>
									<?php
									$query_unidad = mysqli_query($con, "select * from unidad_medida order by abreviacion");
									while ($rw = mysqli_fetch_array($query_unidad)) {
									?>
										<option value="<?php echo $rw['id_unidad']; ?>"><?php echo $rw['abreviacion']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="marca" class="col-sm-3 control-label">Marca</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="marca" name="marca" placeholder="Marca del producto">
							</div>
						</div>

						<div class="form-group">
							<label for="modelo" class="col-sm-3 control-label">Modelo</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo del producto">
							</div>
						</div>

						<div class="form-group">
							<label for="numserie" class="col-sm-3 control-label">Numero Serie</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="numserie" name="numserie" placeholder="Numero de Serie">
							</div>
						</div>

						<div class="form-group">
							<label for="observaciones" class="col-sm-3 control-label">Observaciones</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" maxlength="255"></textarea>
							</div>
						</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
				</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
?>
<!-- Modal -->