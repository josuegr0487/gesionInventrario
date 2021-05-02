<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

if (isset($con)) {
?>
	<!-- Modal -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Consultar producto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" enctype="multipart/form-data" method="post" id="consultar_producto" name="consultar_producto">
						<div id="resultados_ajax2"></div>
						<div class="form-group">
							<label for="mod_codigo" class="col-sm-3 control-label">Código</label>
							<div class="col-sm-8">
                                <input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" readonly>
                                <input type="hidden" name="mod_id" id="mod_id" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="mod_nombre" class="col-sm-3 control-label">Descripción</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Descripción del producto" maxlength="255" readonly></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="mod_imagen" class="col-sm-3 control-label">Imagen</label>
							<div class="col-sm-8">
							    <img id="blah" style="max-height: 150px; width: auto" src="#"/>
							</div>
						</div>

						<div class="form-group">
							<label for="mod_stock" class="col-sm-3 control-label">Stock</label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="mod_stock" name="mod_stock" placeholder="Stock del producto" value="0" readonly>
							</div>
						</div>

						<div class="form-group">
							<label for="mod_unidad" class="col-sm-3 control-label">Unidad</label>
							<div class="col-sm-8">
								<select class='form-control' name='mod_unidad' id='mod_unidad' disabled>
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
							<label for="mod_marca" class="col-sm-3 control-label">Marca</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="mod_marca" name="mod_marca" placeholder="Marca del producto" readonly>
							</div>
						</div>

						<div class="form-group">
							<label for="mod_modelo" class="col-sm-3 control-label">Modelo</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="mod_modelo" name="mod_modelo" placeholder="Modelo del producto" readonly>
							</div>
						</div>

						<div class="form-group">
							<label for="mod_numserie" class="col-sm-3 control-label">Numero Serie</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="mod_numserie" name="mod_numserie" placeholder="Numero de Serie" readonly>
							</div>
						</div>

						<div class="form-group">
							<label for="mod_observaciones" class="col-sm-3 control-label">Observaciones</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="mod_observaciones" name="mod_observaciones" placeholder="Observaciones" maxlength="255" readonly></textarea>
							</div>
						</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
?>
<!-- Modal -->