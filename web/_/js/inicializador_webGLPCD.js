(function(webGL,$,undefined){


    // Codigo de guia para customizar el visor -->
    //https://threejs.org/examples/?q=pcd#webgl_loader_pcd

    webGL.container = undefined;
    webGL.stats = undefined;
    webGL.camera = undefined;
    webGL.controls = undefined;
    webGL.scene = undefined;
    webGL.renderer = undefined;
    webGL.nombreCaptura = undefined;

    //Proporcion del tamaño total de la ventana que el canvas ocupara
    // en porcentajes con rango [0,1]
    webGL.PROPORCION_ANCHO = 0.9;
    webGL.PROPORCION_ALTO = 0.75;
    //Tamanio por defecto del canvas para renderizar WebGL
    webGL.ANCHO_CANVAS_DEFAULT = window.innerWidth * webGL.PROPORCION_ANCHO;
    webGL.ALTURA_CANVAS_DEFAULT = window.innerHeight * webGL.PROPORCION_ALTO;

      onWindowResize = function () {
        //BACKUP!
        //webGL.camera.aspect = window.innerWidth / window.innerHeight;
        webGL.camera.aspect = (window.innerWidth * webGL.PROPORCION_ANCHO )/ (window.innerHeight * webGL.PROPORCION_ALTO);
        webGL.camera.updateProjectionMatrix();
        //BACKUP!
        //webGL.renderer.setSize( window.innerWidth, window.innerHeight );
        webGL.renderer.setSize( window.innerWidth * webGL.PROPORCION_ANCHO,
                                    window.innerHeight * webGL.PROPORCION_ALTO );
        webGL.controls.handleResize();
      }
      
      keyboard = function( ev ) {
        debugger;
        //var ZaghettoMesh = webGL.scene.getObjectByName( "Zaghetto.pcd" );
        var ZaghettoMesh = webGL.scene.getObjectByName( webGL.nombreCaptura );
        switch ( ev.key || String.fromCharCode( ev.keyCode || ev.charCode ) ) {
          case '+':
            ZaghettoMesh.material.size*=1.2;
            ZaghettoMesh.material.needsUpdate = true;
            break;
          case '-':
            ZaghettoMesh.material.size/=1.2;
            ZaghettoMesh.material.needsUpdate = true;
            break;
          case 'c':
            ZaghettoMesh.material.color.setHex(Math.random()*0xffffff);
            ZaghettoMesh.material.needsUpdate = true;
            break;
        }
      }

      animate = function() {
        requestAnimationFrame( animate );
        webGL.controls.update();
        webGL.renderer.render( webGL.scene, webGL.camera );
        webGL.stats.update();
      }

      init = function(urlCaptura,canvasWebGL){
        debugger;
        console.debug("En inicializador_webGLPCD.js");

        webGL.scene = new THREE.Scene();
        webGL.scene.background = new THREE.Color( 0x000000 );

        webGL.camera = new THREE.PerspectiveCamera( 15, window.innerWidth / window.innerHeight, 0.01, 40 );
        webGL.camera.position.x = 0.4;
        webGL.camera.position.z = -2;
        webGL.camera.up.set(0,0,1);

        webGL.controls = new THREE.TrackballControls( webGL.camera );

        //webGL.controls.rotateSpeed = 2.0;
        //webGL.controls.zoomSpeed = 0.3;
        //webGL.controls.panSpeed = 0.2;
        webGL.controls.rotateSpeed = 2.5;
        webGL.controls.zoomSpeed = 0.75;
        webGL.controls.panSpeed = 0.2;


        webGL.controls.noZoom = false;
        webGL.controls.noPan = false;

        webGL.controls.staticMoving = true;
        webGL.controls.dynamicDampingFactor = 0.3;

        webGL.controls.minDistance = 0.3;
        webGL.controls.maxDistance = 0.3 * 100;

        webGL.scene.add( webGL.camera );

        var axisHelper = new THREE.AxisHelper( 0.1 );
        webGL.scene.add( axisHelper );

        webGL.renderer = new THREE.WebGLRenderer( { antialias: true } );
        webGL.renderer.setPixelRatio( window.devicePixelRatio );
        //BACKUP!
        //webGL.renderer.setSize( window.innerWidth, window.innerHeight );
        debugger;
        webGL.renderer.setSize( webGL.ANCHO_CANVAS_DEFAULT,
                                    webGL.ALTURA_CANVAS_DEFAULT);
        document.body.appendChild( webGL.renderer.domElement );

        var loader = new THREE.PCDLoader();
        //loader.load( './models/pcd/Zaghetto.pcd', function ( mesh ) {
        loader.load( urlCaptura, function ( mesh ) {

          webGL.scene.add( mesh );
          var center = mesh.geometry.boundingSphere.center;
          webGL.controls.target.set( center.x, center.y, center.z);
          webGL.controls.update();

        } );

        webGL.container = canvasWebGL;
        //document.body.appendChild( webGL.container );
        webGL.container.appendChild( webGL.renderer.domElement );

        webGL.stats = new Stats();
        webGL.container.appendChild( webGL.stats.dom );

        window.addEventListener( 'resize', onWindowResize, false );

        window.addEventListener('keypress', keyboard);
      }


      webGL.iniciarWebGL = function(urlCaptura,contenedorWebGL){
        debugger;  
        init(urlCaptura,contenedorWebGL);
        var componentesURL= urlCaptura.split("/");
        webGL.nombreCaptura = componentesURL[componentesURL.length-1];
        animate();
      }

    
}(window.webGL = window.webGL || {},jQuery));
