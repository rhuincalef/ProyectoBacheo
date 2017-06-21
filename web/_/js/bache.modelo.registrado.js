var GestorMaterialesRegistrado = (function (Module) {
    
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
        baseUrl = $("#baseUrlBache").text();
        $.post(baseUrl+"publico/getCriticidadesPorIDs",{"arregloIDsCriticidades":JSON.stringify(criticidadesAPedir)}, function(data){
        	var datos = JSON.parse(data);
        	var tipos = JSON.parse(datos.valor);
        	$(tipos).each(function(indice,elemento){
        		criticidad = {"id":elemento.id, "nombre":elemento.nombre, "descripcion":elemento.descripcion};
        		diccionarioCriticidades[criticidad.id] = criticidad;
        		arregloCriticidades.push(criticidad);
        	});
        });
    };
    
    return GestorMateriales;
    
})(GestorMateriales || {});

var TipoFalla = function(datos){
        this.id = datos.id;
        this.nombre = datos.nombre;
        this.influencia = datos.influencia;
        this.atributos = [];
        // this.criticidades = datos.criticidades;
        this.criticidades = [];
        this.reparaciones = [];
        this.multimedia = null;
        var _this = this;

        console.log(datos);
        GestorMateriales.obtenerReparaciones(datos.reparaciones,_this.reparaciones);
        GestorMateriales.obtenerCriticidades(datos.criticidades,_this.criticidades);

        baseUrl = $("#baseUrlBache").text();
        $.post(baseUrl+"publico/getTiposAtributo", {"idTipos":JSON.stringify(datos.atributos)}, function(data) {
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
            baseUrl = $("#baseUrlBache").text();
            $.get(baseUrl+"index.php/publico/getMultimediaTipoFalla/"+_this.id, function(data) {
                var datos = JSON.parse(data);
                $(datos).each(function(indice,elemento){
                    _this.multimedia = elemento.multimedia;
                    return _this.multimedia;
                });
            });
        };

        return this;
    };

function checkFormulario() {
    $formulario = $("#formularioEspecificacionesTecnicas");
    if ($formulario.hasClass("form-desactivado")) {
        $("#formularioEspecificacionesTecnicas").find("select").attr("disabled", false);
        $("#formularioEspecificacionesTecnicas").find("input").attr("disabled", false);
        $("#contenedorFormulario").find("textarea").attr("disabled", false);
        $("#contenedorAtributosFalla").find("select").attr("disabled", false);
        $("#contenedorFormulario").find("button").attr("disabled", false);
        $("#formularioEspecificacionesTecnicas").removeClass("form-desactivado");
        return;
    }
    $("#formularioEspecificacionesTecnicas").find("select").attr("disabled", true);
    $("#formularioEspecificacionesTecnicas").find("input").attr("disabled", true);
    $("#contenedorFormulario").find("button").attr("disabled", true);
    $("#contenedorFormulario").find("textarea").attr("disabled", true);
    $("#contenedorAtributosFalla").find("select").attr("disabled", true);
    $("#formularioEspecificacionesTecnicas").addClass("form-desactivado");
    return;
}

$(document).ready(function(){
    // Enable Bootstrap-checkbox via JavaScript
    $(":checkbox").checkboxpicker();
    $(":checkbox").prop("checked", false);
    $(":checkbox").checkboxpicker().change(checkFormulario);
    $('.tabInfo li:eq(1)').click(function(){
        cargarMateriales();
        checkFormulario();
        $(this).unbind('click');
    });
    $('.tabInfo li').not(':eq(1)').click(function() {
        $(":checkbox").prop("checked", false);
    });
});
