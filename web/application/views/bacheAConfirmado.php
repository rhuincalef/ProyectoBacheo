<label class="control-label itemFormularioEstado" for="material"> Material</label>
<select class="form-control itemFormularioEstado" type="text" id="material" name="material"></select>
<label for="factorArea" class="control-label itemFormularioEstado"> Factor Área (%)</label>
<input type="number" class="form-control itemFormularioEstado" name="factorArea" id="factorArea" placeholder="0.5" required="" step="0.1" min="0"/>
<label class="control-label itemFormularioEstado" for="tipoFalla"> Tipo de falla: <?php echo $criticidad ?></label>
<select class="form-control itemFormularioEstado" type="text" id="tipoFalla" name="tipoFalla"></select>
<label class="control-label itemFormularioEstado"> Atributos</label>
<div style="width:100%; border-top-style:solid; border-top-color: grey; border-bottom-style: solid; border-bottom-color: grey;" class="input-group" id="contenedorAtributosFalla"/>
	<input id="ancho" class="form-control itemFormularioEstado" type="text" placeholder="Ancho" name="ancho"/>
	<label class="control-label itemFormularioEstado" for="tipoReparacion"> Tipo de reparación</label>
</div>
<label class="control-label itemFormularioEstado" for="criticidad"> Criticidad</label>
<select class="form-control itemFormularioEstado" type="text" id="criticidad" name="criticidad">
</select>
