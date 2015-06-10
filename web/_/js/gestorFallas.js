var seleccionado = "material";
var anteriorSeleccionado = "material";
var imagenCroop = null;

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

	activarDropImagen();
});



function activarDropImagen(){
	var target = document.getElementById("handlerImagen");
	target.addEventListener("dragover", function(e){e.preventDefault();}, true);
	target.addEventListener("drop", function(e){
		e.preventDefault(); 
		cargarImagen(e.dataTransfer.files[0]);
	}, true);
}

function cargarImagen(imagen){
	$("#handlerImagen").addClass("oculto");
	//	Prevent any non-image file type from being read.
	if(!imagen.type.match(/image.*/)){
		console.log("El Elemento seleccionado no es una imagen!: ", src.type);
		return;
	}
	//	Create our FileReader and run the results through the render function.
	var reader = new FileReader();
	reader.onload = function(e){
		//render(e.target.result);
		$("#imagenEjemplo").attr("src",e.target.result);
		$("#contenedorImagenEjemplo").removeClass("oculto");
        imagenCroop = jQuery.Jcrop($('#imagenEjemplo')[0],{
            bgColor:     'black',
            bgOpacity:   .4,
            setSelect:   [ 200, 200, 300, 300 ],
            aspectRatio: 1
        });

	};
	reader.readAsDataURL(imagen);
}

function activarCargaImagen(){
	imagenCroop.destroy();
	imagenCroop = null;
	$("#contenedorImagenEjemplo").addClass("oculto");
	$("#imagenEjemplo").attr("src","");
	$("#handlerImagen").removeClass("oculto");
}

function cargarOpciones(opcion){
	anteriorSeleccionado = seleccionado;
	seleccionado = opcion;
	$("#"+anteriorSeleccionado).removeClass("active");
	$("#contenido"+anteriorSeleccionado).addClass("oculto");

	$("#"+seleccionado).addClass("active");
	$("#contenido"+opcion).removeClass("oculto");
}


function obtenerCoordenadas(){
	var coord = imagenCroop.tellSelect();
	var altoImg = $("#imagenEjemplo").height();
	var anchoImg = $("#imagenEjemplo").width();
	var x = (coord.x / anchoImg);
	var y = (coord.y / altoImg);
	var ancho = (coord.w / anchoImg);
	var alto = (coord.h / altoImg);
	return{
		x:x,
		y:y,
		ancho:ancho,
		alto:alto
	}
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
		if(imagenCroop != null){
			this.imagenEjemplo = $("#imagenEjemplo").attr("src");
			this.coordenadasImagen = obtenerCoordenadas();
		}
	};
};