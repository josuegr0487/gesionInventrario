<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/
?>
<!-- Modal -->
<div class="modal fade" id="nuevaUnidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Alta unidad de medida</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="guardar_unidad" name="guardar_unidad">
					<div id="resultados_ajax"></div>
					<div class="form-group">
						<label for="nombre" class="col-sm-3 control-label">Nombre</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="nombre" name="nombre" required>
						</div>
					</div>

					<div class="form-group">
						<label for="abreviatura" class="col-sm-3 control-label">Abreviatura</label>
						<div class="col-sm-8">
							<input type="text" style="text-transform: uppercase;" class="form-control" id="abreviatura" name="abreviatura" required>
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