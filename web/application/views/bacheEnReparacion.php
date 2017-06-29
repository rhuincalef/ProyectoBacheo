<label class="control-label col-sm-10" for="montoCalculado"> Monto Calculado a partir de Tipo de Reparación: $<?php echo $montoCalculado; ?></label>
<label class="control-label col-sm-10" for="montoEstimado"> Monto estimado</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
	<input id="montoEstimado" placeholder="10" class="form-control" type="number" name="montoEstimado" step="any" min="0"/>
	
</div>
<label class="control-label col-sm-10" for="tipoReparacion"> Tipo de reparación</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
	<select id="tipoReparacion" placeholder="" class="form-control" name="montoEstimado"></select>	
</div>
<label class="control-label col-sm-10" for="fechaFin"> Fecha fin reparación estimada</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	<input id="fechaFin" placeholder="<?php date("Y-m-d"); ?>" class="form-control" type="text">
</div> 