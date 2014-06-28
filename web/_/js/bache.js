$(document).ready(function(){
	var mapOptions = {
          center: new google.maps.LatLng(-43.253432, -65.310137),
          zoom: 16,
          mapTypeControl: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    var map = new google.maps.Map(document.getElementById("canvasMapa"),mapOptions);

});