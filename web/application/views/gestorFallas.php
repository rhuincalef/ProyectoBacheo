
<div class="contenido">

	<div class="jumbotron personalizacionJumbotron">
        <h1>Creación Tipo Falla</h1>
	</div>

	<div class="contenedorABM">

		<div id="secciones" class="list-group">
			<a id="nombreTipoFalla" class="list-group-item disabled">
			    <h4 class="list-group-item-heading">Nombre Tipo Falla:
			    	<input name="nombreTipoFalla" type="text" placeholder="Ej:Bache" class="list-group-item-text tabuladoDerecha inputLi"/>
			    </h4>
			    <h4 class="list-group-item-heading">Influencía Tipo Falla:
			    	<input name="influenciaTipoFalla" type="number" placeholder="Ej:10" class="list-group-item-text tabuladoDerecha inputLi"/>
			    </h4>
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

	<div id="contenedorOpcioens" class="contenedorABM datosAsociados list-group">
	
		<div class="opcion" id="contenidomaterial">
			<h4>Material</h4>
			<div>
				<h5>Materiales Seleccionados</h5>
				<ul id="listaMaterialesSeleccionados" class="list-group">
					<li id="sinMateriales" class="list-group-item">No Hay Materiales Seleccionados!</li>
				</ul>
			</div>
			<div>
				<h5>Materiales Existentes</h5>
				<ul class="list-group">
					<li class="list-group-item capitalizado">M1 <span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span></li>
					<li class="list-group-item capitalizado">M2 <span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span></li>
					<li class="list-group-item capitalizado">M3 <span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span></li>
				</ul>
			</div>
			<div>
				<h5>Nuevo Material</h5>
				<ul class="list-group">
					<li class="list-group-item">
						Nombre Material:<input id="nombreMaterialNuevo" class="tabuladoDerecha inputLi" name="atributo" type="text" placeholder="Ej:Pavimento Flexible"/>
					</li>
					<li class="list-group-item">
						<button id="crearYAgregarMaterial" type="button" class="btn btn-primary ancho100">Crear y Agregar</button>
					</li>
				</ul>
			</div>
		</div>


		<div class="oculto opcion" id="contenidoagregarAtributo">
			<h4>Atributos</h4>
			<div>
				<h5>Atributos Agregados</h5>
				<ul id="listaAtributosSeleccionados" class="list-group">
					<li id="sinAtributos" class="list-group-item">No Hay Atributos!</li>
				</ul>
			</div>
			
			<div>
				<h5>Nuevo Atributo</h5>
				<ul class="list-group">
					<li class="list-group-item">
						Nombre Atributo:					
						<input id="nombreAtributoNuevo" name="atributo" class="tabuladoDerecha inputLi" type="text" placeholder="Ej:Ancho"/>
					</li>
					<li class="list-group-item">
						Unidad De Medida:
						<input id="unidadAtributoNuevo" name="unidadMedida" class="tabuladoDerecha inputLi" type="text" placeholder="Ej:Mts"/>
					</li>
					<li class="list-group-item">
						<button id="crearYAgregarAtributo" type="button" class="btn btn-primary ancho100">Crear y Agregar</button>
					</li>
				</ul>
			</div>
		</div>



		<div class="oculto opcion" id="contenidoagregarTipoCriticidad">
			<h4>Criticidad</h4>
			<div>
				<h5>Criticidades Agregadas</h5>
				<ul id="listaCriticidadesSeleccionadas" class="list-group">
					<li id="sinCriticidades" class="list-group-item">No Hay Criticidades!</li>
				</ul>
			</div>
			
			<div>
				<h5>Nueva Criticidad</h5>
				<ul class="list-group">
					<li class="list-group-item">
						Nombre Criticidad:					
						<input id="nombreCriticidadNueva" name="criticidad" class="tabuladoDerecha inputLi" type="text" placeholder="Ej:Bajo"/>
					</li>
					<li class="list-group-item">
						Ponderación:
						<input id="ponderacionCriticidadNuevo" name="ponderacionFalla" class="tabuladoDerecha inputLi" type="number" placeholder="Ej:12.3"/>
					</li>
					<li class="list-group-item">
						<button id="crearYAgregarCriticidad" type="button" class="btn btn-primary ancho100">Crear y Agregar</button>
					</li>
				</ul>
			</div>
				
				

		</div>

		<div class="oculto opcion" id="contenidoagregarTipoReparacion">
			<h4>Reparaciones</h4>
			<div>
				<h5>Reparaciones Seleccionadas</h5>
				<ul id="listaReparacionesSeleccionadas" class="list-group">
					<li id="sinReparaciones" class="list-group-item">No Hay Reparaciones Seleccionadas!</li>
				</ul>
			</div>
			<div>
				<h5>Reparaciones Existentes</h5>
				<div class="list-group">
					<a class="list-group-item capitalizado">
						<span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span>
						<h4 class="list-group-item-heading">M1</h4>
			    		<p class="list-group-item-text">Descripcion: ssss sssssss ssssssssss sssssssss ssssss sssssss sss sssss sssss sssss sssss sssss sssssss ssssss sse ssssss ssssss ssssssssss ssssssssssssssssss ssssssssssssssssssssss ss s sssssssss ssssssss ssssssssss ssssssssss sssssssssssss sssssss sssssssssss ssssss sssssssss sssssss sssssss sssssssssss sssssssss ssss sssss sssssss <br> Costo: $123.23 </p>
						
					</a>
					<a class="list-group-item capitalizado">
						<span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span>
						<h4 class="list-group-item-heading">M1</h4>
			    		<p class="list-group-item-text">Descripcion: asdsadasdsdasdsad; <br> Costo: $123.23 </p>
						
					</a>
					<a class="list-group-item capitalizado">
						<span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span>
						<h4 class="list-group-item-heading">M1</h4>
			    		<p class="list-group-item-text">Descripcion: asdsadasdsdasdsad; <br> Costo: $123.23 </p>
					</a>
				</div>
			</div>
			<div>
				<h5>Nuevas Reperaciones</h5>
				<ul class="list-group">
					<li class="list-group-item">
						Nombre Reparacion:<input id="nombreReparacionNuevo" class="tabuladoDerecha inputLi" name="reparacion" type="text" placeholder="Ej:Sellado de Juntas"/>
					</li>
					
					<li class="list-group-item">
						Costo de Reparacion por Unidad:<input id="costoReparacionNuevo" class="tabuladoDerecha inputLi" name="reparacion" type="text" placeholder="Ej:$578.25"/>
					</li>

					<li class="list-group-item rowTextArea">
						Decripción Reparacion:<textarea id="descripcionReparacionNuevo" class="tabuladoDerecha inputLi" name="reparacion" type="text" placeholder="Ej:Descripcion Procedimental" row="10" col="50"></textarea>
					</li>


					<li class="list-group-item">
						<button id="crearYAgregarReparaciones" type="button" class="btn btn-primary ancho100">Crear y Agregar</button>
					</li>
				</ul>
			</div>
			
		</div>

	</div>

<!-- tipos reperacion // material // criticidades // tipo de atributos -->


</div>
