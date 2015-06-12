// Requiere:
//			Jquery
//			JCroop

var ImagenCroop = (function(){
	var hayImagen = false;
	var crooper = null;
	var idDroper = "";
	var idContenedorImagen = "";
	var idImagen = "";
	var idBotonCambiarImagen = "";

	var inicializar = function(idHandler,idContenedorImagen,idImagen,idBotonCambiarImagen){
			ImagenCroop.idDroper = idHandler;
			ImagenCroop.idContenedorImagen = idContenedorImagen;
			ImagenCroop.idImagen = idImagen;
			ImagenCroop.idBotonCambiarImagen = idBotonCambiarImagen;
			$("#"+ImagenCroop.idBotonCambiarImagen).click(function(){
				ImagenCroop.activarCargaImagen();
			});
			ImagenCroop.activarDropImagen();
		};

	var activarDropImagen = function(){
			var divContenedor = document.getElementById(ImagenCroop.idDroper);
			divContenedor.addEventListener("dragover", function(e){e.preventDefault();}, true);
			divContenedor.addEventListener("drop", function(e){
				e.preventDefault(); 
				cargarImagen(e.dataTransfer.files[0]);
			}, true);
		};

	var cargarImagen = function(imagen){
			$("#"+ImagenCroop.idDroper).addClass("oculto");
			if(!imagen.type.match(/image.*/)){
				console.log("El Elemento seleccionado no es una imagen!: ", imagen.type);
				return;
			}
			ImagenCroop.hayImagen = true;
			var reader = new FileReader();
			reader.onload = function(e){
				$("#"+ImagenCroop.idImagen).attr("src",e.target.result);
				$("#"+ImagenCroop.idContenedorImagen).removeClass("oculto");
		        ImagenCroop.crooper = jQuery.Jcrop($("#"+ImagenCroop.idImagen)[0],{
		            bgColor:     "black",
		            bgOpacity:   .4,
		            setSelect:   [ 200, 200, 300, 300 ],
		            aspectRatio: 1
		        });

			};
			reader.readAsDataURL(imagen);
		};

	var activarCargaImagen =function(){
			ImagenCroop.crooper.destroy();
			ImagenCroop.hayImagen = false;
			$("#"+ImagenCroop.idContenedorImagen).addClass("oculto");
			$("#"+ImagenCroop.idImagen).attr("src","");
			$("#"+ImagenCroop.idDroper).removeClass("oculto");
		};

	var obtenerImagen = function(){
		if(ImagenCroop.hayImagen)
			return $("#"+ImagenCroop.idImagen).attr("src");
		return null;
	};

	var obtenerCoordenadas = function(){
			var coord = ImagenCroop.crooper.tellSelect();
			var altoImg = $("#"+ImagenCroop.idImagen).height();
			var anchoImg = $("#"+ImagenCroop.idImagen).width();
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
		};

	return{
		inicializar:inicializar,
		activarCargaImagen:activarCargaImagen,
		activarDropImagen:activarDropImagen,
		cargarImagen:cargarImagen,
		obtenerCoordenadas:obtenerCoordenadas,
		obtenerImagen:obtenerImagen,
		hayImagen:hayImagen,
	}
}());