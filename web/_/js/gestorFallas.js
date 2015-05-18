var seleccionado = "material";
var anteriorSeleccionado = "material";

$(document).ready(function(){
	var listaOpciones = $("#secciones").find(".list-group-item");
	for (var i = 1; i < listaOpciones.length; i++) {
		(function($elemento){
			$elemento.click(function(){
				cargarOpciones($elemento.attr("id"));
			});
		}($(listaOpciones[i])));

	};
	Material.inicializar();
	Reparacion.inicializar();

	$("#crearYAgregarMaterial").click(Material.crearYAgregarMaterial); //MATERIALES
	$("#crearYAgregarAtributo").click(Atributo.crearYAgregarAtributo); //ATRIBUTOS
	$("#crearYAgregarCriticidad").click(Criticidad.crearYAgregarCriticidad); //CRITICIDADES
	$("#crearYAgregarReparaciones").click(Reparacion.crearYAgregarReparacion); //CRITICIDADES
});

function cargarOpciones(opcion){
	anteriorSeleccionado = seleccionado;
	seleccionado = opcion;
	$("#"+anteriorSeleccionado).removeClass("active");
	$("#contenido"+anteriorSeleccionado).addClass("oculto");

	$("#"+seleccionado).addClass("active");
	$("#contenido"+opcion).removeClass("oculto");
}
