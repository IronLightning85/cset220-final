<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Model and Login Layout</title>

    <!-- Three.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- OBJLoader.js to load .obj files -->
    <script src="https://cdn.jsdelivr.net/gh/mrdoob/three.js@r128/examples/js/loaders/OBJLoader.js"></script>
    <!-- OrbitControls.js for user interaction -->
    <script src="https://cdn.jsdelivr.net/gh/mrdoob/three.js@r128/examples/js/controls/OrbitControls.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body, html {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .login-section, .model-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-section {
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .model-section {
            background-color: #ffffff;
            position: relative;
        }

        #3d-model {
            width: 100%;
            height: 100%;
            display: block;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            width: 80%;
            max-width: 300px;
        }

        .login-form input {
            margin: 0.5rem 0;
            padding: 0.75rem;
            font-size: 1rem;
        }

        .login-form button {
            padding: 0.75rem;
            font-size: 1rem;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Left section for login -->
    <div class="login-section">
        <h1>Login</h1>
        <form class="login-form">
            <input type="text" placeholder="Username">
            <input type="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Right section for 3D model -->
    <div class="model-section">
        <canvas id="3d-model"></canvas>
    </div>
</div>

<script>
// Initialize scene, camera, and renderer for the 3D model
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(80, window.innerWidth / window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('3d-model') });
renderer.setSize(window.innerWidth / 2, window.innerHeight); // Half width for 3D canvas
renderer.setClearColor(0xffffff, 1);

// Light for the 3D model
const light = new THREE.DirectionalLight(0xffffff, 1);
light.position.set(1, 1, 1).normalize();
scene.add(light);

// Load the texture
const textureLoader = new THREE.TextureLoader();
const texture = textureLoader.load('textures/your-texture.png'); // Replace with your texture path

// Load the OBJ model
const loader = new THREE.OBJLoader();
loader.load('models/MSH_Shady_shoals.obj', function (obj) {
    // Apply texture to the model's material
    obj.traverse(function(child) {
        if (child.isMesh) {
            child.material = new THREE.MeshStandardMaterial({ map: texture });
        }
    });
    scene.add(obj);
    animate();
}, undefined, function (error) {
    console.error('An error occurred while loading the OBJ file:', error);
});

// Camera position
camera.position.z = 5;

// OrbitControls for the user to interact with the 3D model
const controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.25;

// Animation loop
function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

// Handle window resize to keep layout responsive
window.addEventListener('resize', () => {
    camera.aspect = (window.innerWidth / 2) / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth / 2, window.innerHeight);
});
</script>

</body>
</html>
