(function(webGL,$,undefined){


    // Codigo de guia para customizar el visor -->
    // https://github.com/mrdoob/three.js/blob/master/examples/webgl_physics_terrain.html
    // ( https://threejs.org/examples/#webgl_physics_terrain )


      // Elementos para visualizar la nube
      webGL.renderer = undefined;
      webGL.scene = undefined;
      webGL.camera = undefined;
      webGL.controls = undefined;

      // Elementos para reconstruir la nube
      webGL.pointcloud = undefined;
      webGL.pointSize = undefined;
      webGL.colores = [];
      webGL.vertices = [];
      // webGL.geometry = undefined;
      // webGL.material = undefined;
      

      webGL.resetear_canvas = function(){
        webGL.renderer.clear();
        console.log("Limpiado webGL.renderer...");
        console.log("");
        if (webGL.pointcloud!= undefined)
          webGL.scene.remove(webGL.pointcloud);
      }


// Check if iframe or not to change the button
      function inIframe () {
        if ( window.location !== window.parent.location ) {
          return true;
        } else {
          return false;
        }
      }

      // Convert colors
      function colorToHex(color) {
        if (color.substr(0, 1) === '0x') {
          return color;
        }
        var digits = /(.*?)rgb\((\d+),(\d+),(\d+)\)/.exec(color);

        var red = parseInt(digits[2]);
        var green = parseInt(digits[3]);
        var blue = parseInt(digits[4]);

        var rgb = blue | (green << 8) | (red << 16);
        return digits[1] + '0x' + rgb.toString(16);
      }

      // Build a color
      function buildColor(v){
        var pi = 3.151592;
        var r = Math.cos(v*2*pi + 0) * (127) + 128;
        var g = Math.cos(v*2*pi + 2) * (127) + 128;
        var b = Math.cos(v*2*pi + 4) * (127) + 128;
        var color = 'rgb(' + Math.round(r) + ',' + Math.round(g) + ',' + Math.round(b) + ')';
        return color;
      }

      // Render loop
      function animate() {
        requestAnimationFrame(animate);
        webGL.controls.update();
      }


      // Render the scene
      function render() {
        webGL.renderer.render(webGL.scene, webGL.camera);
      }


      webGL.iniciarWebGL = function(urlPcFile){
        // Funciones de js config-carga-csv.js
        console.log("En iniciarWebGL...");
        // configurar_info_falla();
        
        // Draw the progressbar on the middle
        var left = Math.round( (window.innerWidth - 400)/2 );
        // $("#progressbar-container").css("left","25%");
        // $("#progressbar-container").css("left",left + "px");

        // Scene
        webGL.scene = new THREE.Scene();

        webGL.camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 300);
        webGL.camera.position.z = -1;

        // Detect webgl support
        if (!Detector.webgl) {
          Detector.addGetWebGLMessage();
          return;
        }
 
        // The webGL.renderer
        if (webGL.renderer != undefined) {
          webGL.renderer.clear();
          console.log("webGL previamente inicializado!!! limpiando..."); 
        }else{
          webGL.renderer = new THREE.WebGLRenderer();
          console.log("Nueva instancia webGL..."); 
        }
        webGL.renderer.setSize(window.innerWidth/2,window.innerHeight/2 -4,false);
        // webGL.renderer.setSize(window.innerWidth,window.innerHeight -4);

        
        // Se configuran los controles controls
        webGL.controls = new THREE.TrackballControls(webGL.camera);
        webGL.controls.rotateSpeed = 1.0;
        webGL.controls.zoomSpeed = 10.2;
        webGL.controls.panSpeed = 0.8;
        webGL.controls.noZoom = false;
        webGL.controls.noPan = false;
        webGL.controls.staticMoving = true;
        webGL.controls.dynamicDampingFactor = 0.3;
        webGL.controls.keys = [65, 17, 18];
        webGL.controls.addEventListener('change', render);

        
        // Init the geometry
        webGL.pointSize = 0.015;
        // webGL.geometry = new THREE.Geometry({dynamic:true});
        // webGL.material = new THREE.ParticleBasicMaterial({size:webGL.pointSize, vertexColors:true});

        // Load the webGL.pointcloud
        var pointcloudLoaded = false;
        var min_x = 0, min_y = 0, min_z = 0, max_x = 0, max_y = 0, max_z = 0, freq = 0;
        // Carga la nube si no esta configurada.
        if (webGL.pointcloud != undefined) {
          console.log("Pointcloud ya inicializada!!");
          configurarEscena(webGL.vertices,webGL.colors);
        }else{
          console.log("Generando pointcloud");
          solicitarNube();
        }


      // Realiza una peticion ajax de la nube
      function solicitarNube(){
        Papa.parse(urlPcFile, {
            download: true,
            worker: true,
            step: function(row) {
              var line = row.data[0];
              //if (line.length != 6) return;
              if (line.length != 6 && line.length != 3) return;

              // Point
              var x = parseFloat(line[0]);
              var y = parseFloat(line[1]);
              var z = parseFloat(line[2]);
              if(x>max_x) max_x = x;
              if(x<min_x) min_x = x;
              if(y>max_y) max_y = y;
              if(y<min_y) min_y = y;
              if(z>max_z) max_z = z;
              if(z<min_z) min_z = z;
              webGL.vertices.push(new THREE.Vector3(x, y, z));

              if (line.length == 6) {
                // Color
                var color = 'rgb(' + line[3] + ',' + line[4] + ',' + line[5] + ')';
                webGL.colores.push(new THREE.Color(colorToHex(color)));
              } else {
                webGL.colores.push(new THREE.Color(colorToHex('rgb(255,0,0)')));
              } 

              // freq++;
              // if (freq > 2000) {
              //   var per = Math.round(geometry.vertices.length * 100 / <?php echo $lineCount ?>);
              //   $("#progressbar").attr("aria-valuenow", per);
              //   $("#progressbar").css("width", per + "%");
              //   $("#progressbar").text(per + "%");
              //   freq = 0;
              // }
            },
            complete: function() {
              console.log("webGL.pointcloud with " + webGL.vertices.length + " points loaded.");
              configurarEscena();
            }
        });
      }

      function configurarEscena(vertices,colores){
        // Se oculta la imagen
        $("#cargando-gif").fadeOut();
        $("#containerWebGL").fadeIn();
        $("#boton-info").fadeIn();

        // Build the scene
        var geometry = new THREE.Geometry({dynamic:true});
        var material = new THREE.ParticleBasicMaterial({size:webGL.pointSize, vertexColors:true});
        geometry.vertices = webGL.vertices;
        geometry.colors = webGL.colores;
        webGL.pointcloud = new THREE.ParticleSystem(geometry,material);
        webGL.scene.fog = new THREE.FogExp2(0x000000, 0.0009);
        webGL.scene.add(webGL.pointcloud);

        // Remove the progressbar
        // $("#progressbar-container").hide();
        if (inIframe()) {
          $("#controls-iframe").show();
        }else {
          $("#controls-browser").show();
        }

        // Add the canvas, render and animate
        var container = document.getElementById('containerWebGL');
        container.appendChild(webGL.renderer.domElement);
        pointcloudLoaded = true;
        render();
        animate();
      }

      // Funciones de asociacion de eventos de zoom con el canvas.
      function asociarEvtZoom(){
        window.addEventListener('DOMMouseScroll', onMouseWheel, false);
        window.addEventListener('mousewheel', onMouseWheel, false);
        $("body").addClass("disable-scroll");
      }

      function desasociarEvtZoom(){
        window.removeEventListener('DOMMouseScroll', onMouseWheel, false);
        window.removeEventListener('mousewheel', onMouseWheel, false);
        $("body").removeClass("disable-scroll"); 
      }


      // Changes the color of the points
      function changeColor(color_mode,geometry) {
        // Clear the geometry colors and maintain the vertices
        if (color_mode == 'rgb')
            geometry.colors = colors;
        else {
          var axis_colors = [];
          for (var i=0; i<geometry.vertices.length; i++) {
            var x = geometry.vertices[i].x;
            var y = geometry.vertices[i].y;
            var z = geometry.vertices[i].z;
            var t = 0;
            switch(color_mode) {
              case 'x':
                t = (x-min_x)/(max_x-min_x);
                break;
              case 'y':
                t = (y-min_y)/(max_y-min_y);
                break;
              case 'z':
                t = (z-min_z)/(max_z-min_z);
                break;
              default:
                alert('Color mode option not available');
                break;
            }
            axis_colors.push(new THREE.Color(colorToHex(buildColor(t))));
          }
          geometry.colors = axis_colors;
        }
      }

      // Zoom on wheel
      function onMouseWheel(evt) {
        var d = ((typeof evt.wheelDelta != "undefined")?(-evt.wheelDelta):evt.detail);
        d = 100 * ((d>0)?1:-1);
        console.log(d);
        var cPos = webGL.camera.position;
        if (isNaN(cPos.x) || isNaN(cPos.y) || isNaN(cPos.y)) return;

        // Your zomm limitation
        // For X axe you can add anothers limits for Y / Z axes
        if (cPos.z > 50  || cPos.z < -50 ) return;

        mb = d>0 ? 1.1 : 0.9;
        cPos.x  = cPos.x * mb;
        cPos.y  = cPos.y * mb;
        cPos.z  = cPos.z * mb;
      }

      // Handle colors and webGL.pointSize
      function onKeyDown(evt) {

        console.log("En onKeyDown()...");
        if (pointcloudLoaded) {
          // Increase/decrease point size
          if (evt.keyCode == 189 || evt.keyCode == 109)
            webGL.pointSize -= 0.003;
          if (evt.keyCode == 187 || evt.keyCode == 107)
            webGL.pointSize += 0.003;

          console.log("incrementado pointSize!");
          console.log("");
          geometry = new THREE.Geometry();
          geometry.vertices = webGL.vertices;

          if (evt.keyCode == 49) changeColor('x',geometry);
          if (evt.keyCode == 50) changeColor('y',geometry);
          if (evt.keyCode == 51) changeColor('z',geometry);
          if (evt.keyCode == 52) changeColor('rgb',geometry);

          console.log("Cambiado color");
          // Re-render the scene
          material = new THREE.ParticleBasicMaterial({ size: webGL.pointSize, vertexColors: true });
          console.log("material");
          webGL.pointcloud = new THREE.ParticleSystem(geometry, material);
          webGL.scene = new THREE.Scene();
          webGL.scene.fog = new THREE.FogExp2(0x000000, 0.0009);
          webGL.scene.add(webGL.pointcloud);
          render();
        }
      }

      // Se asocian los eventos y los handlers
      $("#containerWebGL").on("mouseover",asociarEvtZoom);
      $("#containerWebGL").on("mouseout",desasociarEvtZoom);
      document.addEventListener("keydown", onKeyDown, false);

    } //Fin de inicializar webGL
    

}(window.webGL = window.webGL || {},jQuery));
