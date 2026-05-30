import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import Pickr from '@simonwep/pickr';
import gsap from 'gsap';
import axios from 'axios';

class ShoeConfigurator {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        if (!this.container) return;

        this.config = window.urbanLaceConfig;
        this.designState = { ...this.config.initialDesign };
        
        this.meshes = {};
        this.activeMesh = null;
        
        this.initThreeJS();
        this.createProceduralShoe();
        this.initLighting();
        this.initPickr();
        this.bindEvents();
        
        // Hide loading overlay
        setTimeout(() => {
            document.getElementById('loading-overlay')?.classList.add('hidden');
        }, 800);
        
        this.animate();
    }

    initThreeJS() {
        this.scene = new THREE.Scene();
        // this.scene.background = new THREE.Color('#f5f5f5'); // Transparent so gradient shows
        
        this.camera = new THREE.PerspectiveCamera(45, this.container.clientWidth / this.container.clientHeight, 0.1, 1000);
        this.camera.position.set(10, 5, 10);
        
        this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.container.appendChild(this.renderer.domElement);
        
        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        this.controls.minDistance = 5;
        this.controls.maxDistance = 20;
        this.controls.maxPolarAngle = Math.PI / 2 + 0.1; // Don't go too far below ground

        // Handle window resize
        window.addEventListener('resize', () => {
            if (!this.container) return;
            this.camera.aspect = this.container.clientWidth / this.container.clientHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        });
    }

    initLighting() {
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
        this.scene.add(ambientLight);

        const dirLight = new THREE.DirectionalLight(0xffffff, 0.8);
        dirLight.position.set(5, 10, 5);
        dirLight.castShadow = true;
        dirLight.shadow.mapSize.width = 1024;
        dirLight.shadow.mapSize.height = 1024;
        this.scene.add(dirLight);

        const fillLight = new THREE.DirectionalLight(0xffffff, 0.3);
        fillLight.position.set(-5, 5, -5);
        this.scene.add(fillLight);
        
        // Add a subtle ground plane for shadows
        const planeGeometry = new THREE.PlaneGeometry(50, 50);
        const planeMaterial = new THREE.ShadowMaterial({ opacity: 0.2 });
        const plane = new THREE.Mesh(planeGeometry, planeMaterial);
        plane.rotation.x = -Math.PI / 2;
        plane.position.y = -1;
        plane.receiveShadow = true;
        this.scene.add(plane);
    }

    createProceduralShoe() {
        this.shoeGroup = new THREE.Group();
        
        // Standard Material Template
        const getMaterial = (zoneName) => {
            const hex = this.designState[zoneName] || '#ffffff';
            return new THREE.MeshStandardMaterial({ 
                color: hex,
                roughness: 0.7,
                metalness: 0.1
            });
        };

        // 1. Sole (Bottom)
        // Split into midsole and outsole
        const midsoleGeo = new THREE.BoxGeometry(3.05, 0.3, 7.05);
        const midsole = new THREE.Mesh(midsoleGeo, getMaterial('midsole'));
        midsole.position.y = -0.6;
        midsole.castShadow = true;
        midsole.name = 'midsole';
        this.shoeGroup.add(midsole);
        this.meshes['midsole'] = midsole;

        const outsoleGeo = new THREE.BoxGeometry(3, 0.2, 7);
        const outsole = new THREE.Mesh(outsoleGeo, getMaterial('outsole'));
        outsole.position.y = -0.85;
        outsole.castShadow = true;
        outsole.name = 'outsole';
        this.shoeGroup.add(outsole);
        this.meshes['outsole'] = outsole;

        // 2. Vamp (Main front body)
        const vampGeo = new THREE.BoxGeometry(2.8, 1.2, 4);
        const vamp = new THREE.Mesh(vampGeo, getMaterial('vamp'));
        vamp.position.set(0, 0.1, 1.5);
        vamp.castShadow = true;
        vamp.name = 'vamp';
        this.shoeGroup.add(vamp);
        this.meshes['vamp'] = vamp;

        // 3. Quarter (Sides of the shoe)
        const quarterGeo = new THREE.BoxGeometry(2.9, 1.2, 3);
        const quarter = new THREE.Mesh(quarterGeo, getMaterial('quarter'));
        quarter.position.set(0, 0.1, -0.5);
        quarter.castShadow = true;
        quarter.name = 'quarter';
        this.shoeGroup.add(quarter);
        this.meshes['quarter'] = quarter;

        // 4. Heel (Back body)
        const heelGeo = new THREE.BoxGeometry(2.8, 2, 2.5);
        const heel = new THREE.Mesh(heelGeo, getMaterial('heel'));
        heel.position.set(0, 0.5, -1.75);
        heel.castShadow = true;
        heel.name = 'heel';
        this.shoeGroup.add(heel);
        this.meshes['heel'] = heel;

        // 5. Laces (Top of vamp)
        const lacesGeo = new THREE.BoxGeometry(1.5, 0.2, 3);
        const laces = new THREE.Mesh(lacesGeo, getMaterial('laces'));
        laces.position.set(0, 0.8, 0.5);
        laces.castShadow = true;
        laces.name = 'laces';
        this.shoeGroup.add(laces);
        this.meshes['laces'] = laces;

        // 6. Tongue (Under laces)
        const tongueGeo = new THREE.BoxGeometry(1.4, 0.3, 2.8);
        const tongue = new THREE.Mesh(tongueGeo, getMaterial('tongue'));
        tongue.position.set(0, 0.7, 0.4);
        tongue.rotation.x = -0.2;
        tongue.castShadow = true;
        tongue.name = 'tongue';
        this.shoeGroup.add(tongue);
        this.meshes['tongue'] = tongue;

        // 7. Swoosh/Logo (Sides)
        const swooshGeo = new THREE.BoxGeometry(3.1, 0.5, 2);
        const swoosh = new THREE.Mesh(swooshGeo, getMaterial('swoosh'));
        swoosh.position.set(0, 0.2, -0.5);
        swoosh.castShadow = true;
        swoosh.name = 'swoosh';
        this.shoeGroup.add(swoosh);
        this.meshes['swoosh'] = swoosh;

        // If high-top or mid-top, extend the collar
        if (this.config.modelType === 'high' || this.config.modelType === 'mid') {
            const collarGeo = new THREE.BoxGeometry(2.6, 2, 2.3);
            const collar = new THREE.Mesh(collarGeo, getMaterial('collar'));
            collar.position.set(0, 2, -1.75);
            collar.castShadow = true;
            collar.name = 'collar';
            this.shoeGroup.add(collar);
            this.meshes['collar'] = collar; 
        }

        // If high-top, add a strap
        if (this.config.modelType === 'high') {
            const strapGeo = new THREE.BoxGeometry(2.7, 0.4, 2.4);
            const strap = new THREE.Mesh(strapGeo, getMaterial('strap'));
            strap.position.set(0, 2.5, -1.6);
            strap.castShadow = true;
            strap.name = 'strap';
            this.shoeGroup.add(strap);
            this.meshes['strap'] = strap;
        }

        this.scene.add(this.shoeGroup);
        
        // Center it
        this.shoeGroup.position.y = 0.5;
    }

    initPickr() {
        this.pickr = Pickr.create({
            el: '.color-picker-mount',
            theme: 'classic', 
            inline: true,
            showAlways: true,
            default: '#111111',
            components: {
                preview: true,
                opacity: false,
                hue: true,
                interaction: {
                    hex: true,
                    input: true,
                    save: false
                }
            }
        });

        this.pickr.on('change', (color) => {
            if (this.activeMesh) {
                const hex = color.toHEXA().toString();
                
                // Update 3D Model
                this.activeMesh.material.color.set(hex);
                
                // If we're updating heel on a high-top, also update collar
                if (this.activeMesh.name === 'heel' && this.meshes['collar']) {
                    this.meshes['collar'].material.color.set(hex);
                }

                // Update state
                this.designState[this.activeMesh.name] = hex;

                // Update UI indicator (dispatch Alpine event or update DOM directly)
                const indicator = document.getElementById(`color-indicator-${this.activeMesh.name}`);
                if (indicator) {
                    indicator.style.backgroundColor = hex;
                }
            }
        });
    }

    bindEvents() {
        // Listen to Alpine.js zone selection
        window.addEventListener('select-zone', (e) => {
            const meshName = e.detail.mesh_name;
            if (this.meshes[meshName]) {
                this.selectZone(meshName);
            }
        });

        // Listen to Alpine.js material selection
        window.addEventListener('select-material', (e) => {
            const materialType = e.detail.material;
            if (this.activeMesh) {
                this.updateMaterialProperties(this.activeMesh, materialType);
                
                if (this.activeMesh.name === 'heel' && this.meshes['collar']) {
                    this.updateMaterialProperties(this.meshes['collar'], materialType);
                }

                this.designState[`${this.activeMesh.name}_material`] = materialType;
            }
        });

        // Close picker
        document.getElementById('close-picker')?.addEventListener('click', () => {
            document.getElementById('picker-container').classList.add('hidden');
            if (this.activeMesh) {
                // Reset scale of previously active mesh
                gsap.to(this.activeMesh.scale, { x: 1, y: 1, z: 1, duration: 0.3 });
                this.activeMesh = null;
            }
            // Dispatch to Alpine to remove active class
            window.dispatchEvent(new CustomEvent('zone-selected', { detail: { mesh_name: null } }));
        });

        // Save Design
        document.getElementById('save-design-btn')?.addEventListener('click', () => {
            this.saveDesign();
        });
    }

    updateMaterialProperties(mesh, type) {
        switch (type) {
            case 'leather':
                mesh.material.roughness = 0.4;
                mesh.material.metalness = 0.2;
                break;
            case 'suede':
                mesh.material.roughness = 0.9;
                mesh.material.metalness = 0.0;
                break;
            case 'mesh':
                mesh.material.roughness = 0.8;
                mesh.material.metalness = 0.0;
                break;
            case 'canvas':
            default:
                mesh.material.roughness = 0.7;
                mesh.material.metalness = 0.0;
                break;
        }
        mesh.material.needsUpdate = true;
    }

    selectZone(meshName) {
        // Reset previous
        if (this.activeMesh) {
            gsap.to(this.activeMesh.scale, { x: 1, y: 1, z: 1, duration: 0.3 });
        }

        this.activeMesh = this.meshes[meshName];
        
        // Highlight animation
        gsap.to(this.activeMesh.scale, { x: 1.05, y: 1.05, z: 1.05, duration: 0.3, yoyo: true, repeat: 1 });
        gsap.to(this.activeMesh.scale, { x: 1.02, y: 1.02, z: 1.02, duration: 0.3, delay: 0.6 });

        // Update pickr to current color
        const currentColor = this.designState[meshName] || '#ffffff';
        this.pickr.setColor(currentColor);

        // Update active material UI
        const currentMaterial = this.designState[`${meshName}_material`] || 'canvas';
        window.dispatchEvent(new CustomEvent('material-selected', { detail: { material: currentMaterial } }));

        // Show picker UI
        document.getElementById('picker-container').classList.remove('hidden');
        
        // Tell Alpine about it
        window.dispatchEvent(new CustomEvent('zone-selected', { detail: { mesh_name: meshName } }));
    }

    async saveDesign() {
        const btn = document.getElementById('save-design-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Saving...';
        btn.disabled = true;

        const designNameInput = document.getElementById('designName');
        
        try {
            // 1. Save design
            const response = await axios.post(this.config.saveUrl, {
                _token: this.config.csrfToken,
                shoe_id: this.config.shoeId,
                design_name: designNameInput ? designNameInput.value : 'Custom Design',
                design_json: JSON.stringify(this.designState)
            });

            if (response.data.success) {
                btn.innerHTML = 'Adding to Cart...';

                // 2. Add to cart
                const cartResponse = await axios.post('/cart/add', {
                    _token: this.config.csrfToken,
                    shoe_id: this.config.shoeId,
                    shoe_design_id: response.data.design_id,
                    design_snapshot: JSON.stringify(this.designState),
                    size: 9, // Default size — user can change later
                    price_snapshot: document.querySelector('[class*="font-bold"][class*="text-lg"]')?.textContent?.replace(/[^0-9.]/g, '') || 120
                });

                if (cartResponse.data.success) {
                    btn.innerHTML = 'Added! Redirecting...';
                    btn.classList.add('bg-green-600', 'text-white');
                    btn.classList.remove('bg-green-400');
                    
                    setTimeout(() => {
                        window.location.href = '/cart';
                    }, 800);
                }
            }
        } catch (error) {
            console.error('Save failed', error);
            btn.innerHTML = 'Error!';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 2000);
        }
    }

    animate() {
        requestAnimationFrame(this.animate.bind(this));
        
        // Slow auto-rotation if no interaction
        if (this.shoeGroup && !this.activeMesh && this.controls.getAzimuthalAngle() === this.controls.getAzimuthalAngle()) {
            // this.shoeGroup.rotation.y += 0.002;
        }

        this.controls.update();
        this.renderer.render(this.scene, this.camera);
    }
}

// Initialize when DOM is ready and container exists
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('three-container')) {
        new ShoeConfigurator('three-container');
    }
});
