var Material = (function(){

	
	this.materiales = {"id":"-1","nombre":""};
	var materialesExistentes = [];

	function inicializar(){
		$.get("getAll/TipoMaterial", function( data ) {
			var respuesta = JSON.parse(data);
			if(respuesta.codigo == CODIGO_EXITO){
				$("#sinMaterialesExistentes").addClass("oculto");
				var materialesRecividos = JSON.parse(respuesta.valor);
				materialesRecividos.map(function(material){
					materialesExistentes.push(material);
					cargarMaterial(material.nombre);
				});
			}
		});

	}

	function cargarMaterial(material){
		var material = material.toLowerCase();
		var $li = $('<li class="list-group-item capitalizado"></li>');
		$li.append(material + '<span class="glyphicon glyphicon-plus tabuladoDerecha" aria-hidden="true" onclick="Material.agregarMaterialExistente(this)"></span>');
		$("#listaMaterialesExistentes").append($li);
	}
	

	function agregarMaterial(unMaterial){
		unMaterial.nombre = unMaterial.nombre.toLowerCase();
		if ((materiales.nombre == unMaterial.nombre)  || (unMaterial.nombre.length == 0) ){
			alertar("Error!", "El nombre no puede estar vacio ni ser repetido", "error");
			return false;
		}			
	
		var $li = $('#materialAgregado');
		$li.removeClass("oculto");
		$li.empty();
		$li.append(unMaterial.nombre);
		$li.append('<span class="glyphicon glyphicon-remove tabuladoDerecha" aria-hidden="true" onclick="Material.eliminarMaterial(this);"></span>');
		$("#sinMateriales").addClass("oculto");
		Material.material = unMaterial;
		return true;
	}

	function crearYAgregarMaterial(){
		var elMaterial = {"id":"","nombre":$("#nombreMaterialNuevo").val()}
		agregarMaterial(elMaterial);
		$("#nombreMaterialNuevo").val("");
			
	}

	function agregarMaterialExistente(elemento){
		var unNombre = elemento.previousSibling.textContent;
		agregarMaterial(materialesExistentes.filter(function(e){ return e.nombre.toLowerCase() == unNombre})[0]);
	}

	function eliminarMaterial(elemento){
		$("#materialAgregado").addClass("oculto");
		$("#sinMateriales").removeClass("oculto");
		Material.material = {"id":"-1","nombre":""};
	}

	return{
		inicializar:inicializar,
		material:this.materiales,
		agregarMaterial:agregarMaterial,
		crearYAgregarMaterial:crearYAgregarMaterial,
		agregarMaterialExistente:agregarMaterialExistente,
		eliminarMaterial:eliminarMaterial
	}
}());