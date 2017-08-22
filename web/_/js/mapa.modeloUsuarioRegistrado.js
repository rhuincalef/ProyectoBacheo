/* inicializarFormularioBache: Funcion encargada de renderizar los elementos del formulario
 * segun coresponde a un usuario registrado																		*/
function inicializarFormularioBache(){
  	Bacheo.myDropzone.removeAllFiles();
	$("#informacionBache").modal("toggle");
	var $divSelect = $("#contenedorSelect");
	$divSelect.empty();
	var materiales = GestorMateriales.obtenerArregloMateriales();
	var keysMateriales = Object.keys(materiales);
	var $opcionesMaterial = $('<select class="form-control campoIzquierdo derechoAmpliado" name="tipoMaterial" id="tipoMaterial"/>');
	$(keysMateriales).each(function(indice,elemento){
		/* No se muestran aquellos tipos de materiales que no poseen tipos de falla */
		if (materiales[elemento].fallas.length <= 0) {
			keysMateriales.splice(indice, 1);
			return;
		}
	    var opcion = new Option(materiales[elemento].nombre,materiales[elemento].id,true,true);
	    $(opcion).click(function(){
	    	cargarTiposFalla(materiales[elemento].fallas);
	    });
	    $opcionesMaterial.append(opcion);
	});
	$opcionesMaterial.change(function(event){
		var indice = $(this).val() - 1;
		cargarTiposFalla(materiales[indice].fallas);
	});
	$divSelect.append($('<label class="label label-primary campoIzquierdo izquierdoReducido">Tipo de Material</label>'));
	$divSelect.append($opcionesMaterial);
	$divSelect.append($('<label class="label label-primary campoIzquierdo izquierdoReducido">Factor Área (%)</label>'));
	$divSelect.append('<input class="form-control campoDerecho derechoAmpliado" name="factorArea" id="factorArea" type="number" step="any" min="0"/>');

	$divSelect.append($('<div id="contenedorSelectFallas" class="input-group" style="width:100%;"/>'));
	cargarTiposFalla(materiales[keysMateriales[0]].fallas);

	$("#modaInfoBacheAceptar").unbind();
	$("#modaInfoBacheAceptar").click(function(){
		recolectarFalla();
	});
};

// Agregamos al gestor de Materiales la obtención de los nieles de criticidades de un tipo de falla
// necesario sólo en la vista de usuario registrado
var GestorMaterialesRegistrado = (function (Module) {
    
    console.log(Module);
    var diccionarioCriticidades = {};
    Module.diccionarioCriticidades = diccionarioCriticidades;
    Module.obtenerCriticidades = function obtenerCriticidades(idCriticidades,arregloCriticidades) {
        // another method!
        var criticidadesAPedir = [];
        if (idCriticidades == undefined) {
        	return diccionarioCriticidades;
        };
        idCriticidades.map(function(k,v){
        	if(diccionarioCriticidades.hasOwnProperty(k))
        		arregloCriticidades.push(diccionarioCriticidades[k]);
        	else
        		criticidadesAPedir.push(k);
        });
        if (criticidadesAPedir.length==0) {
        	return;
        }
        $.post("publico/getCriticidadesPorIDs",{"arregloIDsCriticidades":JSON.stringify(criticidadesAPedir)}, function(data){
        	var datos = JSON.parse(data);
        	var tipos = JSON.parse(datos.valor);
        	$(tipos).each(function(indice,elemento){
        		criticidad = {"id":elemento.id, "nombre":elemento.nombre, "descripcion":elemento.descripcion};
        		diccionarioCriticidades[criticidad.id] = criticidad;
        		arregloCriticidades.push(criticidad);
        	});
        });
    };

    var diccionarioTiposEstado = {};
    Module.diccionarioTiposEstado = diccionarioTiposEstado;
    Module.obtenerTiposEstado = function obtenerTiposEstado() {
    	if (Object.keys(diccionarioTiposEstado).length == 0) {
    		console.log("Debo obtener los tipos de estados!!");
    		$.post("publico/getAll/TipoEstado",function(data) {
    			var datos = JSON.parse(data);
        		var tipos = JSON.parse(datos.valor);
        		$(tipos).each(function(indice,elemento){
	        		estado = {"id":elemento.id, "nombre":elemento.nombre};
	        		diccionarioTiposEstado[estado.id] = estado;
	        		//arregloCriticidades.push(estado);
        		});
    		});
    		return diccionarioTiposEstado;
    	}
    	return diccionarioTiposEstado;
    }
    
    return GestorMateriales;
    
})(GestorMateriales || {});

var TipoFalla = function(datos){
	this.id = datos.id;
	this.nombre = datos.nombre;
	this.influencia = datos.influencia;
	this.atributos = [];
	this.criticidades = [];
	this.reparaciones = [];
	this.multimedia = null;
	var _this = this;

	console.log(datos);
	GestorMateriales.obtenerReparaciones(datos.reparaciones,_this.reparaciones);
	GestorMateriales.obtenerCriticidades(datos.criticidades,_this.criticidades);

	$.post("index.php/publico/getTiposAtributo", {"idTipos":JSON.stringify(datos.atributos)}, function(data) {
		var datos = JSON.parse(data);
		if(datos.codigo == 200){
			var attr = JSON.parse(datos.valor);
			$(attr).each(function(indice,elemento){
    			_this.atributos.push({"id":elemento.id,"nombre":elemento.nombre});
    		});
		}
	});
	this.getMultimedia = function(){
		if(this.multimedia != null)
			return this.multimedia;
		$.get( "index.php/publico/getMultimediaTipoFalla/"+_this.id, function(data) {
			var datos = JSON.parse(data);
			$(datos).each(function(indice,elemento){
    			_this.multimedia = elemento.multimedia;
    			return _this.multimedia;
    		});
		});
	};

	return this;
};

/* cargarTiposFalla: Obtiene y completa la parte del formulario encargada de presentar los diferentes tipos
 * de falla registrados en el sistema																		*/
function cargarTiposFalla(fallas){
	var $divSelectFallas = $("#contenedorSelectFallas");
	$divSelectFallas.empty();
	$divSelectFallas.append($('<label class="label label-primary campoIzquierdo izquierdoReducido">Tipo de Falla</label>'));
	var $opcionesFallas = $('<select class="form-control campoDerecho derechoAmpliado" name="tipoFalla" id="tipoFalla"/>');
	$(fallas).each(function(indice,elemento){
		var opcion = new Option(elemento.nombre,elemento.id,true,true);
	    $(opcion).click(function(){
	    	cargarOpcionesFalla(elemento.atributos,elemento.reparaciones, elemento.criticidades);
	    });
	    $opcionesFallas.append(opcion);
	});
	$opcionesFallas.change(function(event){
		var indice = $(this).val() - 1;
		cargarOpcionesFalla(fallas[indice].atributos, fallas[indice].reparaciones, fallas[indice].criticidades);
	});
	$opcionesFallas.val(fallas[0].id);
	$divSelectFallas.append($opcionesFallas);
	$divSelectFallas.append('<div id="contenedorAtributosFalla" class="input-group" style="width:100%;"/>');
	cargarOpcionesFalla(fallas[0].atributos,fallas[0].reparaciones, fallas[0].criticidades);
}

/* cargarOpcionesFalla: Agrega al formulario los campos a llenar correspondientes a las propiedades del tipo 
 * de falla especificado en la casilla de seleccion de Tipo de Falla										*/
function cargarOpcionesFalla(atributos,reparaciones, criticidades){
	var $contenedorAtributos = $("#contenedorAtributosFalla");
	$contenedorAtributos.empty();
	$(atributos).each(function(indice,elemento){
		var $unDiv = $('<div/>');
		$unDiv.append($('<label class="label label-primary campoIzquierdo izquierdoReducido">'+elemento.nombre+'</label>'));
		$unDiv.append($('<input type="text" propId="'+elemento.id+'" step="any" min="0" class="campoDerecho derechoAmpliado bfh-number"/>'));
		$contenedorAtributos.append($unDiv);
	});
	
	var $unDiv = $('<div/>');
	//$unDiv = $("#contenedorAtributosFalla");
	$unDiv.append($('<label class="label label-primary campoIzquierdo izquierdoReducido">Reparación</label>'));
	var $opcionesReparacion = $('<select class="form-control campoDerecho derechoAmpliado" name="tipoReparacion" id="tipoReparacion"/>');
	var keysReparaciones = Object.keys(reparaciones);
	$(keysReparaciones).each(function(indice,elemento){
	    var opcion = new Option(reparaciones[elemento].nombre,reparaciones[elemento].id,true,true);
	    $opcionesReparacion.append(opcion);
	  });
	$unDiv.append($opcionesReparacion);
	$contenedorAtributos.append($unDiv);

	var $unDiv = $('<div/>');
	// var $unDiv = $("#contenedorAtributosFalla");
	$unDiv.append($('<label class="label label-primary campoIzquierdo izquierdoReducido">Criticidades</label>'));
	var $opcionesCriticidades = $('<select class="form-control campoDerecho derechoAmpliado" name="criticidad" id="criticidad"/>');
	$opcionesCriticidades.empty();
	$(criticidades).each(function(indice, elemento){
		var opcion = new Option(elemento.nombre, elemento.id, true, true);
		$opcionesCriticidades.append(opcion);
	});
	$unDiv.append($opcionesCriticidades);
	$contenedorAtributos.append($unDiv);
}


// Bacheo.agregarMarcador
function recolectarFalla(){
	var datos = {};
	datos.falla = {};
	datos.direccion = {};
	var $formulario = $('form[id="formularioBache"]')[0];
	datos.direccion.callePrincipal = $formulario["calle"].value;
	datos.direccion.calleSecundariaA = "No tenemos como obtenerlo!!!";
	datos.direccion.calleSecundariaB = "No tenemos como obtenerlo!!!";
	datos.direccion.altura = $formulario["altura"].value;
	// datos.tipoMaterial = $formulario["tipoMaterial"].value;
	datos.tipoMaterial = {};
	datos.tipoMaterial.id = parseInt($formulario["tipoMaterial"].value);
	// datos.tipoFalla = $formulario["tipoFalla"].value;
	datos.tipoFalla = {};
	datos.tipoFalla.id = $formulario["tipoFalla"].value;
	if ($formulario["descripcion"].value.length != 0) {	
		datos.observacion = {};
		datos.observacion.comentario = $formulario["descripcion"].value;
	}
	datos.falla.factorArea = parseFloat(($formulario["factorArea"].value));
	if (parseInt($formulario["tipoReparacion"].value) != 0) {
		datos.reparacion = {};
		datos.reparacion.id = parseInt($formulario["tipoReparacion"].value);
	}
	datos.criticidad = {};
	datos.criticidad.id = parseInt($formulario["criticidad"].value);
	var arregloAtributos = $("#contenedorAtributosFalla").find("input");
	datos.atributos = [];
	for (var i = arregloAtributos.length - 1; i >= 0; i--) {
		var attr = {"id":$(arregloAtributos[i]).attr("propId"),"valor":arregloAtributos[i].value};
		datos.atributos.push(attr);
	};
	Bacheo.agregarMarcador(datos);
}

var directionsDisplay = new google.maps.DirectionsRenderer();
var directionsService = new google.maps.DirectionsService();

var request = {
	 origin: $('#origen').val(),
	 destination: $('#destino').val(),
	 travelMode: google.maps.DirectionsTravelMode[$('#modo_viaje').val()],
	 unitSystem: google.maps.DirectionsUnitSystem[$('#tipo_sistema').val()],
	 provideRouteAlternatives: true
 };

function trazarRuta() {
	/* Ordenar */
	console.log("trazarRuta")
	if ($("#buscarCalleSideBar").val().length == 0) {
		alertar("La Pucha","Debe ingresar una calle.","error");
		return;
	}
	calle = $("#buscarCalleSideBar").val();
	tiposFallasIds = [];
	tiposEstadoIds = [];
	$checkboxTiposFalla = $("#tipoFallaCheckbox").find("input");
	$checkboxTiposFalla.each(function(index, value){
		if ($(value).prop("checked")) {
			tiposFallasIds.push($(value).val());
		}
	});
	if (tiposFallasIds.length == 0) {
		tiposFallasIds.push($("#todas-form-check").find("input").val());
	}
	$checkboxTiposEstado = $("#tipoEstadoCheckbox").find("input");
	$checkboxTiposEstado.each(function(index, value){
		if ($(value).prop("checked")) {
			tiposEstadoIds.push($(value).val());
		}
	});
	if (tiposEstadoIds.length == 0) {
		tiposEstadoIds.push($("#todos-tiposEstado-form-check").find("input").val());
	}
	//return;
	$.post('getFallasPorCalle', 
		//{"calle":"Gales", tiposFalla:JSON.stringify([1,2,3]), estados:JSON.stringify([1,2])},
		//{"calle":"Gales", tiposFalla:JSON.stringify([1,2,3]), estados:JSON.stringify([1])},
		{"calle":calle, tiposFalla:JSON.stringify(tiposFallasIds), estados:JSON.stringify(tiposEstadoIds)},
		function (data) {
			fallas = JSON.parse(data);
			getDirections(fallas);
		}
	);
}

function getDirections(fallas) {
	console.log("fallas");
	//console.log(fallas[0]);
	console.log(typeof(fallas));
	if (fallas.length == 0) {
		alertar("laPucha","No existen fallas.","error");
		return;
	}
	/* Ordena por:
	http://stackoverflow.com/questions/10906337/how-to-sort-an-array-in-javascript-in-a-customized-order
	*/
	fallas.sort(function (a, b) {
		return a.latitud - b.latitud;
		}
	);
	var origen = new google.maps.LatLng(parseFloat(fallas[0].latitud),parseFloat(fallas[0].longitud));
	var last = fallas[fallas.length - 1];
	var destino = new google.maps.LatLng(parseFloat(last.latitud),parseFloat(last.longitud));
	request = {};
	request.origin = origen;
	request.destination = destino;
	request.travelMode = google.maps.DirectionsTravelMode["WALKING"];
	request.unitSystem = google.maps.DirectionsUnitSystem["METRIC"];
	request.provideRouteAlternatives = false;
	directionsService.route(request, function(response, status) {
	    if (status == google.maps.DirectionsStatus.OK) {
	        directionsDisplay.setMap($("#canvasMapa").gmap3("get"));
	        directionsDisplay.setDirections(response);
	    } else {
	    		alertar("laPucha","No existen rutas entre ambos puntos","error");
	    }
	});
}

function limpiarRuta() {
	directionsDisplay.setMap(null); // clear direction from the map
	directionsDisplay.setPanel(null); // clear directionpanel from the map          
	directionsDisplay = new google.maps.DirectionsRenderer(); // this is to render again, otherwise your route wont show for the second time searching
	directionsDisplay.setMap($("#canvasMapa").gmap3("get")); //this is to set up again
}

function buscarFallasCalle(event) {
  event.preventDefault();
  console.log("buscarFallasCalle");
  var calle = $("#buscarCalleSideBar").val();
  console.log("Calle: "+calle);
  if (calle=="") {
    alertar("La Pucha!","Debe ingresar una calle.","error");
  }
}

$(document).ready(function(){
    $("#buscarFallasCalle").click(buscarFallasCalle);
    $(".dropdown-menu-side-bar li").click(function( event ) {
    	event.preventDefault();
    	var $target = $( event.currentTarget );
    	$target.closest( '.btn-group' )
    	.find( '[data-bind="label"]' ).text( $target.text() )
    	.end()
    	.children( '.dropdown-toggle' ).dropdown( 'toggle' );
    	console.log(".dropdown-menu-side-bar li");
    	console.log($target);
    	$(".formulario-side-bar").show();
    	cargarTiposFallaSideBarForm();
    	cargarTiposEstadoSideBarForm();
    	return false;
    });
    $(".formulario-side-bar").hide();

	var boundsTrelew = new google.maps.LatLngBounds(
	  new google.maps.LatLng(-43.230650145567985, -65.37500381469727),
	  new google.maps.LatLng(-43.28790660359147, -65.25123596191406)
	);
	$("#buscarCalleSideBar").geocomplete({
	  map: $("#canvasMapa").gmap3("get"),
	  country: 'ar',
	  bounds:boundsTrelew,
	  componentRestrictions:{
	    postal_code:'9100'
	  }
	});
	$("#buscarCalleSideBar").geocomplete("autocomplete").setBounds(boundsTrelew);
	$("#buscarCalleSideBar").bind("geocode:result", function(event, result){
    	console.log(result);
  	});

	$("#trazarRuta").click(trazarRuta);
	$("#limpiarRuta").click(limpiarRuta);
	GestorMateriales.obtenerTiposEstado();
});

function cargarTiposFallaSideBarForm(argument) {
	$tipoFallaCheckbox = $("#tipoFallaCheckbox");
	$tipoFallaCheckbox.empty();
	$("#seleccionarTipoFallaSideBar").unbind("click");
	tiposFalla = GestorMateriales.diccionarioTiposFalla;
	$.each(tiposFalla, function (index, tipoFalla) {
		label = $('<div class="form-check"><input class="form-check-input" type="checkbox" value="'+tipoFalla.id+'"><label class="form-check-label">'+tipoFalla.nombre+'</label></div>');
		$tipoFallaCheckbox.append(label);
		$(label).find("input").change(function() {
			checkedState = $(this).prop("checked");
			if (checkedState) {
				$("#todas-form-check input").prop('checked', false);
			}
			$(this).prop('checked', checkedState);
		});
	});
	//indexTodasFallas = Object.keys(tiposFalla).length + 1;
	indexTodasFallas = -1;
	label = $('<div id="todas-form-check" class="form-check"><input class="form-check-input" type="checkbox" value="'+indexTodasFallas+'"><label class="form-check-label">Todas</label></div>');
	$tipoFallaCheckbox.append(label);
	$("#todas-form-check input").change(function() {
		checkedState = $(this).prop("checked");
		if (checkedState) {
			$('#tipoFallaCheckbox').children(".form-check").children("input").each(function () {
				if ($(this) != $("#todas-form-check input")) {
				$(this).prop('checked', false);
				}
			});
		}
		$(this).prop('checked', checkedState);
	});
	$("#seleccionarTipoFallaSideBar").click(function() {
		if ($("#tipoFallaCheckbox").hasClass("mostrar")) {
			$("#tipoFallaCheckbox").children(".form-check").hide("slow");
			$("#tipoFallaCheckbox").removeClass("mostrar");
			return;
		}
		$("#tipoFallaCheckbox").addClass("mostrar");
		$("#tipoFallaCheckbox").children(".form-check").show("slow");
		return;
	});
	$("#tipoFallaCheckbox").children(".form-check").hide();
}

function cargarTiposEstadoSideBarForm() {
	$tipoEstadoCheckbox = $("#tipoEstadoCheckbox");
	$tipoEstadoCheckbox.empty();
	$("#seleccionarTipoEstadoSideBar").unbind("click");
	tiposEstado = GestorMateriales.obtenerTiposEstado();
	$.each(tiposEstado, function (index, tipoEstado) {
		label = $('<div class="form-check"><input class="form-check-input" type="checkbox" value="'+tipoEstado.id+'"><label class="form-check-label">'+tipoEstado.nombre+'</label></div>');
		$tipoEstadoCheckbox.append(label);
		$(label).find("input").change(function() {
			checkedState = $(this).prop("checked");
			if (checkedState) {
				$("#todos-tiposEstado-form-check input").prop('checked', false);
			}
			$(this).prop('checked', checkedState);
		});
	});
	indexTodosEstados = -1;
	label = $('<div id="todos-tiposEstado-form-check" class="form-check"><input class="form-check-input" type="checkbox" value="'+indexTodasFallas+'"><label class="form-check-label">Todos</label></div>');
	$tipoEstadoCheckbox.append(label);
	$("#todos-tiposEstado-form-check input").change(function() {
		checkedState = $(this).prop("checked");
		if (checkedState) {
			$('#tipoEstadoCheckbox').children(".form-check").children("input").each(function () {
				if ($(this) != $("#todos-tiposEstado-form-check input")) {
				$(this).prop('checked', false);
				}
			});
		}
		$(this).prop('checked', checkedState);
	});
	$("#seleccionarTipoEstadoSideBar").click(function() {
		if ($("#tipoEstadoCheckbox").hasClass("mostrar")) {
			$("#tipoEstadoCheckbox").children(".form-check").hide("slow");
			$("#tipoEstadoCheckbox").removeClass("mostrar");
			return;
		}
		$("#tipoEstadoCheckbox").addClass("mostrar");
		$("#tipoEstadoCheckbox").children(".form-check").show("slow");
		return;
	});
	$("#tipoEstadoCheckbox").children(".form-check").hide();
}
