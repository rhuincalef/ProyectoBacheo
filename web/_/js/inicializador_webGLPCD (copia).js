(function(webGL,$,undefined){


    // Codigo de guia para customizar el visor -->
    //https://threejs.org/examples/?q=pcd#webgl_loader_pcd

      onWindowResize = function () {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize( window.innerWidth, window.innerHeight );
        controls.handleResize();
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
        controls.update();
        renderer.render( scene, camera );
        stats.update();
      }

      init = function(urlCaptura,canvasWebGL){
        debugger;
        console.debug("En inicializador_webGLPCD.js");

        scene = new THREE.Scene();
        scene.background = new THREE.Color( 0x000000 );

        camera = new THREE.PerspectiveCamera( 15, window.innerWidth / window.innerHeight, 0.01, 40 );
        camera.position.x = 0.4;
        camera.position.z = -2;
        camera.up.set(0,0,1);

        controls = new THREE.TrackballControls( camera );

        controls.rotateSpeed = 2.0;
        controls.zoomSpeed = 0.3;
        controls.panSpeed = 0.2;

        controls.noZoom = false;
        controls.noPan = false;

        controls.staticMoving = true;
        controls.dynamicDampingFactor = 0.3;

        controls.minDistance = 0.3;
        controls.maxDistance = 0.3 * 100;

        scene.add( camera );

        var axisHelper = new THREE.AxisHelper( 0.1 );
        scene.add( axisHelper );

        renderer = new THREE.WebGLRenderer( { antialias: true } );
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        document.body.appendChild( renderer.domElement );

        var loader = new THREE.PCDLoader();
        //loader.load( './models/pcd/Zaghetto.pcd', function ( mesh ) {
        loader.load( urlCaptura, function ( mesh ) {

          scene.add( mesh );
          var center = mesh.geometry.boundingSphere.center;
          controls.target.set( center.x, center.y, center.z);
          controls.update();

        } );

        container = canvasWebGL;
        //document.body.appendChild( container );
        container.appendChild( renderer.domElement );

        stats = new Stats();
        container.appendChild( stats.dom );

        /*
        container = document.createElement( 'div' );
        document.body.appendChild( container );
        container.appendChild( renderer.domElement );

        stats = new Stats();
        container.appendChild( stats.dom );*/

        window.addEventListener( 'resize', onWindowResize, false );

        //window.addEventListener('keypress', keyboard);
      }


      webGL.iniciarWebGL = function(urlCaptura,contenedorWebGL){
        debugger;  
        init(urlCaptura,contenedorWebGL);
        animate();
      }

    
}(window.webGL = window.webGL || {},jQuery));
