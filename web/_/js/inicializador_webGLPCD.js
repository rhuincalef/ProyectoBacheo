(function(webGL,$,undefined){


    // Codigo de guia para customizar el visor -->
    //https://threejs.org/examples/?q=pcd#webgl_loader_pcd

    webGL.container = undefined;
    webGL.stats = undefined;
    webGL.camera = undefined;
    webGL.controls = undefined;
    webGL.scene = undefined;
    webGL.renderer = undefined;

      onWindowResize = function () {
        webGL.camera.aspect = window.innerWidth / window.innerHeight;
        webGL.camera.updateProjectionMatrix();
        webGL.renderer.setSize( window.innerWidth, window.innerHeight );
        webGL.controls.handleResize();
      }

      /*function keyboard ( ev ) {
        var ZaghettoMesh = scene.getObjectByName( "Zaghetto.pcd" );
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
      }*/

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

        webGL.controls.rotateSpeed = 2.0;
        webGL.controls.zoomSpeed = 0.3;
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
        webGL.renderer.setSize( window.innerWidth, window.innerHeight );
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

        /*
        webGL.container = document.createElement( 'div' );
        document.body.appendChild( webGL.container );
        webGL.container.appendChild( renderer.domElement );

        stats = new Stats();
        webGL.container.appendChild( stats.dom );*/

        window.addEventListener( 'resize', onWindowResize, false );

        //window.addEventListener('keypress', keyboard);
      }


      webGL.iniciarWebGL = function(urlCaptura,contenedorWebGL){
        debugger;  
        init(urlCaptura,contenedorWebGL);
        animate();
      }

    
}(window.webGL = window.webGL || {},jQuery));
