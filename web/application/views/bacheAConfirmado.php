<label class="control-label col-sm-2 itemFormularioEstado" for="material"> Material</label>
<select class="form-control itemFormularioEstado" type="text" id="material" name="material"></select>;
<label for="factorArea" class="control-label col-sm-4 itemFormularioEstado"> Factor Área (%)</label>
<input type="number" class="form-control itemFormularioEstado" name="factorArea" id="factorArea" value="0.5" step="0.1" min="0"/>
<label class="control-label col-sm-4 itemFormularioEstado" for="tipoFalla"> Tipo de Falla</label>
<select class="form-control itemFormularioEstado" type="text" id="tipoFalla" name="tipoFalla"/>
	<option value="0" selected="selected">Esquina</option>
	<option value="1">Huellon</option>
	<option value="2">Fisura Transversal</option>
</select>
<label class="control-label col-sm-4 itemFormularioEstado"> Atributos</label>
<div style="width:100%; border-top-style:solid; border-top-color: grey; border-bottom-style: solid; border-bottom-color: grey;" class="input-group" id="contenedorAtributosFalla"/>
	<input id="ancho" class="form-control itemFormularioEstado" type="text" placeholder="Ancho" name="ancho"/>
	<label class="control-label col-sm-8 itemFormularioEstado" for="tipoReparacion"> Tipo de Reparación</label>
</div>
<label class="control-label col-sm-2 itemFormularioEstado" for="criticidad"> Criticidad</label>
<select class="form-control itemFormularioEstado" type="text" id="criticidad" name="criticidad">
</select>
