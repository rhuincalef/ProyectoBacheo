$(document).ready(function(){
	var opcionesMapa = {
 		center: new google.maps.LatLng(-43.25333333, -65.30944),
 		zoom: 16
		};	
	var mapaDWM = new google.maps.Map(new google.maps.Map(document.getElementById('canvasMapa'),opcionesMapa));
});