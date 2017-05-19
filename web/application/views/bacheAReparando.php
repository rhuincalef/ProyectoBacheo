<label class="control-label" for="montoReal">Monto calculado: <?php echo $montoCalculado?></label>
<label class="control-label" for="montoReal">Monto real</label>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
    <input id="montoReal" type="number" min="0" step="any" name="montoReal" placeholder="120" class="form-control"/>
</div>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <input id="fechaFinReal" placeholder="<?php date("Y-m-d"); ?>" class="form-control" type="text"/>
</div> 
<!--
    <div class="input-append date">
      <input type="text" class="span2"><span class="add-on"><i class="icon-th"></i></span>
    </div>
        $('#sandbox-container .input-append.date').datepicker({
        clearBtn: true,
        language: "es",
        daysOfWeekDisabled: "0,6",
        daysOfWeekHighlighted: "1,2,3,4,5",
        calendarWeeks: true,
        todayHighlight: true,
        toggleActive: true
    });
-->