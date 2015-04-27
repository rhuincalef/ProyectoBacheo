
<div class="contenido">

	<div class="jumbotron personalizacionJumbotron">
        <h1>Creación Tipo Falla</h1>
	</div>

	<div class="contenedorABM">

		<div id="secciones" class="list-group">
			<a id="nombreTipoFalla" class="list-group-item disabled">
			    <h4 class="list-group-item-heading">Nombre Tipo Falla:</h4>
			    <input name="nombreTipoFalla" type="text" placeholder="Ej:Bache" class="list-group-item-text"/>
		  	</a>	
			<a id="material" class="list-group-item active">
			    <h4 class="list-group-item-heading">Material</h4>
			    <p class="list-group-item-text">algo de materiales</p>
			</a>
			<a id="agregarAtributo" class="list-group-item">
			    <h4 class="list-group-item-heading">Atributos</h4>
			    <p class="list-group-item-text">algo de atributos</p>
			</a>
			<a id="agregarTipoCriticidad" class="list-group-item">
			    <h4 class="list-group-item-heading">Criticidad</h4>
			    <p class="list-group-item-text">algo de Criticidades</p>
			</a>
			<a id="agregarTipoReparacion" class="list-group-item">
			    <h4 class="list-group-item-heading">Reparaciones</h4>
			    <p class="list-group-item-text">algo de reparaciones</p>
			</a>
		</div>

	</div>

	<div id="contenedorOpcioens" class="contenedorABM datosAsociados">
	
		<div id="contenidomaterial">
			Material
			<br>
			<input name="atributo" type="text" placeholder="algo de material"/>
			<input name="unidadMedida" type="text" placeholder="Ej:Mts"/>
		</div>


		<div class="oculto" id="contenidoagregarAtributo">
			Atributos
			<br>
			<input name="atributo" type="text" placeholder="Ej:Ancho"/>
			<input name="unidadMedida" type="text" placeholder="Ej:Mts"/>
		</div>



		<div class="oculto" id="contenidoagregarTipoCriticidad">
			CRITICIDAD
			<br>
				<input name="nombreCriticidad" type="text" placeholder="Ej:Bajo"/>
				<input name="ponderacionFalla" type="number" placeholder="Ej:12.3"/>

		</div>

		<div class="oculto" id="contenidoagregarTipoReparacion">
			REPARACIONES
			<br>
			<input name="nombreTipoReparacion" type="text" placeholder="Ej:Sellado de Juntas"/>
			<input name="descripcionReparacion" type="text" placeholder="Ej:Descripción de la reparación"/>
			<input name="costoReparacion" type="text" placeholder="Ej:$578.25"/>
		</div>

	</div>

<!-- tipos reperacion // material // criticidades // tipo de atributos -->


</div>
