var Material = (function(){

	
	var materiales = [];

	

	function agregarMaterial(material){
		material = material.toLowerCase();
		if ((materiales.filter(function(mat){return mat == material}).length != 0)  || (material.length == 0) ){
			alertar("Error!", "El nombre no puede estar vacio ni ser repetido", "error");
			return false;
		}			
	
		var $li = $('<li class="list-group-item capitalizado"></li>');
		$li.append(material);
		$li.append('<span class="glyphicon glyphicon-remove tabuladoDerecha" aria-hidden="true" onclick="Material.eliminarMaterial(this);"></span>');
		$("#listaMaterialesSeleccionados").append($li);
		$("#sinMateriales").addClass("oculto");
		materiales.push(material);
		return true;
	}

	function crearYAgregarMaterial(){
		agregarMaterial($("#nombreMaterialNuevo").val());
		$("#nombreMaterialNuevo").val("");
			
	}

	function agregarMaterialExistente(elemento){
		agregarMaterial(elemento.previousSibling.textContent);

	}

	function eliminarMaterial(elemento){
		$(elemento.parentNode).remove();

		var pos = materiales.indexOf(elemento.previousSibling.textContent );
		pos > -1 && materiales.splice( pos, 1 );
		if(materiales.length == 0)
			$("#sinMateriales").removeClass("oculto");

	}

	return{
		agregarMaterial:agregarMaterial,
		crearYAgregarMaterial:crearYAgregarMaterial,
		agregarMaterialExistente:agregarMaterialExistente,
		eliminarMaterial:eliminarMaterial
	}
}());