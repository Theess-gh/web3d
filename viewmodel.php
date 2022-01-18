<!DOCTYPE html>
<html lang="en">
<head>
    <title>3d Viewer</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
    $zip = new ZipArchive;
    $newfile = $_GET["zipfile"];
    $res = $zip->open($newfile);
    if ($res === TRUE) {
      $zip->extractTo('sc/');
      $zip->close();
      echo 'Модель загружена';
    } else {
      echo 'failed';
    }
    ?>
    <div class="container"></div>
    <script src="three.js"></script>
    <script type="module">

        import { OrbitControls } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/controls/OrbitControls.js'
        import { GLTFLoader } from './three.js-master/examples/jsm/loaders/GLTFLoader.js'

        let scene;
        let camera;
        let renderer;

        function init() {
            let container = document.querySelector('.container');

            //Scene
            scene = new THREE.Scene()
            scene.background = new THREE.Color(0xffffff);

            //Camera
            camera = new THREE.PerspectiveCamera(75, 500 / 500, 0.1, 3000);
            camera.position.z = 400;
            camera.position.y = 50;
            camera.position.x = 0;

            //render
            renderer = new THREE.WebGLRenderer({antialias: true})   
            renderer.setSize(500, 500)
            container.appendChild(renderer.domElement)
            if (container.childElementCount > 1){
                container.removeChild(container.firstChild)
            }

            //OrbitControls
            const controls = new OrbitControls(camera, renderer.domElement);
            controls.update();
            controls.enableDamping = true;
            controls.minDistance = 40;

            //light
            const ambient = new THREE.AmbientLight(0xffffff, 1);
            scene.add(ambient)

            let light = new THREE.PointLight(0xc4c4c4, 1);
            light.position.set(0, 300, 500);
            scene.add(light)

            let light2 = new THREE.PointLight(0xc4c4c4, 1);
            light2.position.set(500, 300, 500);
            scene.add(light2)

            let light3 = new THREE.PointLight(0xc4c4c4, 1);
            light3.position.set(0, 300, -500);
            scene.add(light3)

            let light4 = new THREE.PointLight(0xc4c4c4, 1);
            light4.position.set(-500, 300, 500);
            scene.add(light4)

            //model
            const loader = new GLTFLoader();
            loader.load('./sc/scene.gltf', gltf => {
                scene.add(gltf.scene);
            }, 
                function (error) {
                    console.log('Error: ' + error)
                }
            )

            //Resize
            window.addEventListener('resize', onWindowResize, false)
            
            function onWindowResize() {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();

                renderer.setSize(window.innerWidth, window.innerHeight)
            }

            function animate() {
                requestAnimationFrame(animate)
                controls.update();
                renderer.render(scene, camera)
            }
            animate()
        }
        init()
    </script>
</body>
</html>