<label class="control-label" for="montoRealCalculado">Monto estimado: $<?php echo $montoCalculado; ?></label>
<label class="control-label" for="montoReal">Monto real</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
    <input id="montoReal" type="number" min="0" step="any" name="montoReal" placeholder="120" class="form-control"/>
</div>
<?php setlocale(LC_TIME, 'es_AR.UTF-8'); ?>
<label class="control-label" for="fechaFinReal"><i class="fa fa-calendar"></i> Fecha de finalización reparación estimada: <?php echo strftime("%d de %B de %Y", strtotime($fechaFinReparacionEstimada)); ?></label>
<label class="control-label" for="fechaFinReal">Fecha de finalización reparación real</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <input id="fechaFinReal" placeholder="<?php date("d-m-Y"); ?>" class="form-control" type="text"/>
</div>
<label class="control-label" for="tipoReparacion"> Tipo de reparación seleccionado: <?php echo $tipoReparacion->nombre; ?></label>