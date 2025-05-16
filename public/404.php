<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | MediaSociale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f0f2f5;
            color: #444;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .error-content {
            z-index: 2;
            text-align: center;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            position: relative;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-out forwards;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: #1877f2;
            margin-bottom: 0;
            line-height: 1;
            text-shadow: 3px 3px 0 rgba(0, 0, 0, 0.1);
            animation: pulse 2s infinite;
        }
        
        .error-message {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: #333;
        }
        
        .error-description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #666;
        }
        
        .back-button {
            background-color: #1877f2;
            color: #fff;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(24, 119, 242, 0.3);
        }
        
        .back-button:hover {
            background-color: #166fe5;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(24, 119, 242, 0.4);
            color: white;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 576px) {
            .error-code {
                font-size: 6rem;
            }
            .error-message {
                font-size: 1.5rem;
            }
            .error-content {
                margin: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Three.js canvas will be injected here -->
    
    <div class="error-content">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Page Not Found</h2>
        <p class="error-description">Oops! The page you're looking for doesn't exist or has been moved to another URL.</p>
        <a href="index.php" class="back-button">Back to Home</a>
    </div>
    
    <script>
        // ThreeJS Scene Setup
        let scene, camera, renderer, cube;
        let cubes = [];
        const numCubes = 50;
        
        function init() {
            // Create scene
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0xf0f2f5);
            
            // Create camera
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 5;
            
            // Create renderer
            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            document.body.appendChild(renderer.domElement);
            
            // Create light
            const light = new THREE.DirectionalLight(0xffffff, 1);
            light.position.set(5, 5, 5);
            scene.add(light);
            
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
            scene.add(ambientLight);
            
            // Create multiple cubes with the digit 4 on them
            for (let i = 0; i < numCubes; i++) {
                const size = Math.random() * 0.5 + 0.2;
                const geometry = new THREE.BoxGeometry(size, size, size);
                
                // Create material with random color
                const material = new THREE.MeshStandardMaterial({
                    color: new THREE.Color(Math.random() * 0.1 + 0.1, Math.random() * 0.3 + 0.4, Math.random() * 0.3 + 0.6),
                    metalness: 0.3,
                    roughness: 0.7
                });
                
                const newCube = new THREE.Mesh(geometry, material);
                
                // Position randomly in a sphere
                const radius = Math.random() * 10 + 5;
                const theta = Math.random() * Math.PI * 2;
                const phi = Math.random() * Math.PI;
                
                newCube.position.x = radius * Math.sin(phi) * Math.cos(theta);
                newCube.position.y = radius * Math.sin(phi) * Math.sin(theta);
                newCube.position.z = radius * Math.cos(phi);
                
                // Random rotation
                newCube.rotation.x = Math.random() * Math.PI;
                newCube.rotation.y = Math.random() * Math.PI;
                newCube.rotation.z = Math.random() * Math.PI;
                
                // Random rotation speed
                newCube.userData = {
                    rotSpeed: {
                        x: (Math.random() - 0.5) * 0.01,
                        y: (Math.random() - 0.5) * 0.01,
                        z: (Math.random() - 0.5) * 0.01
                    },
                    floatSpeed: Math.random() * 0.005 + 0.001,
                    floatOffset: Math.random() * Math.PI * 2
                };
                
                scene.add(newCube);
                cubes.push(newCube);
            }
            
            // Add event listener for window resize
            window.addEventListener('resize', onWindowResize, false);
            
            // Start animation loop
            animate();
        }
        
        function onWindowResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }
        
        function animate() {
            requestAnimationFrame(animate);
            
            // Rotate camera slowly around the scene
            const time = Date.now() * 0.0005;
            camera.position.x = Math.sin(time) * 7;
            camera.position.z = Math.cos(time) * 7;
            camera.lookAt(0, 0, 0);
            
            // Animate cubes
            const now = Date.now() * 0.001;
            cubes.forEach(cube => {
                // Rotate each cube
                cube.rotation.x += cube.userData.rotSpeed.x;
                cube.rotation.y += cube.userData.rotSpeed.y;
                cube.rotation.z += cube.userData.rotSpeed.z;
                
                // Make the cube float up and down
                const floatY = Math.sin(now + cube.userData.floatOffset) * 0.1;
                cube.position.y += floatY * cube.userData.floatSpeed;
            });
            
            renderer.render(scene, camera);
        }
        
        // Initialize the 3D scene
        init();
    </script>
</body>
</html>
