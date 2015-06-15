var seleccionado = "material";
var anteriorSeleccionado = "material";
//var imagenCroop = null;

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
	$("#crearTipoFalla").click(function(){
		crearFalla();
	}); //CRITICIDADES

//	activarDropImagen();
	ImagenCroop.inicializar("handlerImagen","contenedorImagenEjemplo","imagenEjemplo","eliminarImagen");
	//imagenCroop.activarDropImagen();
});

function cargarOpciones(opcion){
	anteriorSeleccionado = seleccionado;
	seleccionado = opcion;
	$("#"+anteriorSeleccionado).removeClass("active");
	$("#contenido"+anteriorSeleccionado).addClass("oculto");

	$("#"+seleccionado).addClass("active");
	$("#contenido"+opcion).removeClass("oculto");
}



function crearFalla(){
	var tipoFalla = new ObjetoTipoFalla();
	tipoFalla.inicializar();

	$.post('crear/TipoFalla', 
	{"clase": "TipoFalla", 
	"datos": JSON.stringify({
			"general": {"nombre": tipoFalla.nombre, "influencia": tipoFalla.influencia},
	        "material": tipoFalla.material,
	        "atributos": tipoFalla.atributos,
	        "criticidades": tipoFalla.criticidades,
	        "reparaciones": tipoFalla.reparaciones
		}),
	}).done(function(respuesta){
		var rta = JSON.parse(respuesta);
		if(rta.codigo == 200)
			alertar("Hecho!", rta.mensaje, "success");
		else
			alertar("Error!", rta.mensaje, "error");
	});

};

var ObjetoTipoFalla = function(){
	this.nombre ="";
	this.material = "";
	this.atributos = [];
	this.criticidades = [];
	this.reparaciones = [];

	this.inicializar = function(){
		this.nombre = $($("#nombreTipoFalla").find("[name|=nombreTipoFalla]")[0]).val();
		this.influencia = $($("#nombreTipoFalla").find("[name|=influenciaTipoFalla]")[0]).val();
		this.material = Material.material;
		this.atributos = Atributo.atributos;
		this.criticidades = Criticidad.criticidades;
		this.reparaciones = Reparacion.reparaciones;
/*		if(imagenCroop != null){
			this.imagenEjemplo = $("#imagenEjemplo").attr("src");
			this.coordenadasImagen = obtenerCoordenadas();
		}
	};*/
		if(ImagenCroop.hayImagen){
			this.imagenEjemplo = ImagenCroop.obtenerImagen();
			this.coordenadasImagen = ImagenCroop.obtenerCoordenadas();
		}
	};
}