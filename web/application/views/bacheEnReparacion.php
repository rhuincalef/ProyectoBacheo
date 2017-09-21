<label class="control-label" for="montoCalculado"> Monto Calculado a partir de Tipo de Reparación: $<?php echo $montoCalculado; ?></label>
<label class="control-label" for="montoEstimado"> Monto estimado</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
	<input id="montoEstimado" placeholder="$<?php echo $montoCalculado; ?>" class="form-control" type="number" name="montoEstimado" step="any" min="0"/>
	
</div>
<label class="control-label" for="tipoReparacion"> Tipo de reparación seleccionado: <?php echo $tipoReparacion->nombre; ?></label>
<label class="control-label" for="tipoReparacion"> Tipo de reparación</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-cogs"></i></span>
	<select id="tipoReparacion" placeholder="" class="form-control" name="tipoReparacion"></select>	
</div>
<label class="control-label" for="fechaFin"> Fecha fin reparación estimada</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	<input id="fechaFin" placeholder="<?php date("Y-m-d"); ?>" class="form-control" type="text">
</div>
<!--
<div class="sandbox-container">
    <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input class="form-control" type="text" name="">
    </div>
</div>
-->