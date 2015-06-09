
<div class="contenido">

	<div class="jumbotron personalizacionJumbotron">
        <h1>Creación Tipo Falla</h1>
	</div>

	<div class="contenedorABM">

		<div id="secciones" class="list-group">
			<a id="nombreTipoFalla" class="list-group-item disabled datosTipoFalla">
			    <h4 class="list-group-item-heading">Nombre Tipo Falla:
			    	<input name="nombreTipoFalla" type="text" placeholder="Ej:Bache" class="list-group-item-text tabuladoDerecha inputLi"/>
			    </h4>
			    <h4 class="list-group-item-heading">Influencia Tipo Falla:
			    	<input name="influenciaTipoFalla" type="number" placeholder="Ej:10" class="list-group-item-text tabuladoDerecha inputLi"/>
			    </h4>
		  	</a>	
			<a id="material" class="list-group-item active">
			    <h4 class="list-group-item-heading">Material</h4>
			    <p class="list-group-item-text">Materiales en los que se presenta la falla.</p>
			</a>
			<a id="agregarAtributo" class="list-group-item">
			    <h4 class="list-group-item-heading">Atributos</h4>
			    <p class="list-group-item-text">Atributos a relevar de la falla.</p>
			</a>
			<a id="agregarTipoCriticidad" class="list-group-item">
			    <h4 class="list-group-item-heading">Criticidad</h4>
			    <p class="list-group-item-text">Criticidades posibles en la falla. </p>
			</a>
			<a id="agregarTipoReparacion" class="list-group-item">
			    <h4 class="list-group-item-heading">Reparaciones</h4>
			    <p class="list-group-item-text">Reparaciones permitidas para esta falla.</p>
			</a>
			<a id="agregarImagen" class="list-group-item">
			    <h4 class="list-group-item-heading">Imagen</h4>
			    <p class="list-group-item-text">Coloque una imagen que permita reconocer la falla.</p>
			</a>
			<a class="list-group-item">
			    <button id="crearTipoFalla" class="btn btn-primary ancho100" type="button">Crear Tipo Falla</button>
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
					<li id="materialAgregado" class="list-group-item oculto"></li>
				</ul>
			</div>
			<div>
				<h5>Materiales Existentes</h5>
				<ul id="listaMaterialesExistentes" class="list-group">
					<li id="sinMaterialesExistentes" class="list-group-item capitalizado"> No Hay Materiales Para Seleccionar! </li>
				
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
						<input id="nombreCriticidadNueva" name="nombreCriticidad" class="tabuladoDerecha inputLi" type="text" placeholder="Ej:Bajo"/>
					</li>
					<li class="list-group-item">
						Descripcion:					
						<input id="descripcionCriticidadNueva" name="descripcionCriticidad" class="tabuladoDerecha inputLi" type="text" placeholder="Ej:menor a 5 cm"/>
					</li>
					<li class="list-group-item">
						Ponderación:
						<input id="ponderacionCriticidadNueva" name="ponderacionCriticidad" class="tabuladoDerecha inputLi" type="number" placeholder="Ej:12.3"/>
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
				
				<div id="listaReparacionesSeleccionadas" class="list-group">
					<a id="sinReparaciones" class="list-group-item capitalizado"> No Hay Reparaciones Seleccionadas! </a>
				</div>
				<!-- <ul id="listaReparacionesSeleccionadas" class="list-group">
					<li id="sinReparaciones" class="list-group-item">No Hay Reparaciones Seleccionadas!</li>
				</ul> -->
			</div>
			<div>
				<h5>Reparaciones Existentes</h5>
				<div id="listaReparacionesExistentes" class="list-group">
					<a id="sinReparacionesExistentes" class="list-group-item capitalizado">
						Sin Reparaciones Existentes!
					</a>
					<!-- <a class="list-group-item capitalizado">
						<span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Reparacion.agregarReparacionExistente(this)"></span>
						<h4 name="nombre" class="list-group-item-heading">M3</h4>
			    		Descripcion:<p name="descripcion" class="list-group-item-text sangria">ssss sssssss ssssssssss sssssssss ssssss sssssss sss sssss sssss sssss sssss sssss sssssss ssssss sse ssssss ssssss ssssssssss ssssssssssssssssss ssssssssssssssssssssss ss s sssssssss ssssssss ssssssssss ssssssssss sssssssssssss sssssss sssssssssss ssssss sssssssss sssssss sssssss sssssssssss sssssssss ssss sssss sssssss </p>
			    		<br>
			    		Costo:<p name="costo" class="sangria"> $123.23 </p>
						
					</a> -->
					
				</div>
			</div>
			<div>
				<h5>Nuevas Reperaciones</h5>
				<ul class="list-group">
					<li class="list-group-item">
						Nombre Reparacion:<input id="nombreReparacionNueva" class="tabuladoDerecha inputLi" name="reparacion" type="text" placeholder="Ej:Sellado de Juntas"/>
					</li>
					
					<li class="list-group-item">
						Costo de Reparacion por Unidad:<input id="costoReparacionNueva" class="tabuladoDerecha inputLi" name="reparacion" type="number" placeholder="Ej:578.25"/>
					</li>

					<li class="list-group-item rowTextArea">
						Decripción Reparacion:<textarea id="descripcionReparacionNueva" class="tabuladoDerecha inputLi" name="reparacion" type="text" placeholder="Ej:Descripcion Procedimental" row="10" col="50"></textarea>
					</li>


					<li class="list-group-item">
						<button id="crearYAgregarReparaciones" type="button" class="btn btn-primary ancho100">Crear y Agregar</button>
					</li>
				</ul>
			</div>
			
		</div>

		<div class="oculto opcion" id="contenidoagregarImagen">
			<h4>Imagen</h4>
			<div>
				<h5>Nueva Imagen</h5>
				<div>
					<div id="handlerImagen" class="divDropeable">
						Coloque su imagen aqui
					</div>
					<div id="contenedorImagenEjemplo" class="oculto">
					<span class="glyphicon glyphicon-remove tabuladoDerecha" aria-hidden="true" onclick="activarCargaImagen();"></span>
						<img id="imagenEjemplo" class="imagenEjemplo">
					</div>

				</div>
			</div>
				
				

		</div>

	</div>

<!-- tipos reperacion // material // criticidades // tipo de atributos -->


</div>
