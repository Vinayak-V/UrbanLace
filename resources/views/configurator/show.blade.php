<x-configurator-layout>
    @section('price_display')
        ${{ number_format($shoe->base_price, 0) }}
    @endsection

    <!-- 3D Canvas Container -->
    <div id="three-container" class="flex-grow relative cursor-grab active:cursor-grabbing bg-gradient-to-b from-[#f5f5f5] to-[#e0e0e0]">
        <!-- Loading Overlay -->
        <div id="loading-overlay" class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-brand-offwhite">
            <div class="w-16 h-16 border-4 border-gray-200 border-t-green-500 rounded-full animate-spin mb-4"></div>
            <p class="font-bold uppercase tracking-wider text-sm text-brand-black">Loading Studio...</p>
        </div>
        
        <!-- Controls Helper -->
        <div class="absolute bottom-6 left-6 text-xs text-gray-500 font-medium bg-white/50 backdrop-blur px-3 py-1.5 rounded-full pointer-events-none">
            Left Click: Rotate | Right Click: Pan | Scroll: Zoom
        </div>
    </div>

    <!-- UI Panel -->
    <div class="w-96 flex-shrink-0 bg-white shadow-2xl z-10 flex flex-col border-l border-gray-200"
         x-data="{ 
            activeZone: null,
            activeMaterialType: 'canvas',
            zones: {{ Js::from($shoe->colorZones) }},
            materials: {{ Js::from($materials) }},
            designName: 'My {{ $shoe->name }}',
            shoeModel: '{{ $shoe->model_type }}'
         }"
         @zone-selected.window="activeZone = $event.detail.mesh_name"
         @material-selected.window="activeMaterialType = $event.detail.material">
        
        <div class="p-6 border-b border-gray-100 flex-shrink-0">
            <h1 class="text-3xl font-display font-black italic uppercase tracking-tight mb-1">{{ $shoe->name }}</h1>
            <p class="text-sm text-gray-500 font-medium">{{ ucfirst($shoe->model_type) }} Top Custom Sneaker</p>
        </div>

        <!-- Zones List -->
        <div class="flex-grow overflow-y-auto p-6 space-y-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Customizable Zones</h3>
            
            <template x-for="zone in zones" :key="zone.id">
                <button 
                    @click="$dispatch('select-zone', { mesh_name: zone.mesh_name })"
                    :class="{'border-green-500 bg-green-50': activeZone === zone.mesh_name, 'border-gray-200 bg-white hover:border-gray-300': activeZone !== zone.mesh_name}"
                    class="w-full text-left p-4 rounded border-2 transition-colors flex items-center justify-between group">
                    <span class="font-bold text-sm uppercase tracking-wide text-brand-black" x-text="zone.name"></span>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs text-gray-400 group-hover:text-brand-black transition-colors" x-show="activeZone !== zone.mesh_name">Edit</span>
                        <!-- Color indicator blob -->
                        <div :id="'color-indicator-' + zone.mesh_name" class="w-6 h-6 rounded-full border border-gray-300 shadow-inner" :style="`background-color: ${zone.default_color}`"></div>
                    </div>
                </button>
            </template>
        </div>

        <!-- Color Picker Container -->
        <div id="picker-container" class="p-6 border-t border-gray-100 flex-shrink-0 hidden bg-brand-offwhite">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-bold text-sm uppercase tracking-wider">Customize <span x-text="activeZone" class="text-green-600"></span></h4>
                <button id="close-picker" class="text-gray-400 hover:text-brand-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Materials Grid -->
            <div class="mb-5">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Material</p>
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="mat in materials" :key="mat.id">
                        <button 
                            @click="$dispatch('select-material', { material: mat.type })"
                            :class="{'border-brand-black bg-brand-black text-white': activeMaterialType === mat.type, 'border-gray-300 bg-white text-brand-black hover:border-gray-400': activeMaterialType !== mat.type}"
                            class="py-2 px-3 text-xs font-bold uppercase tracking-wider rounded border-2 transition-colors"
                            x-text="mat.name">
                        </button>
                    </template>
                </div>
            </div>

            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Color</p>
            <!-- Pickr mount point -->
            <div class="color-picker-mount"></div>
        </div>

        <!-- Action Area -->
        <div class="p-6 border-t border-gray-200 bg-white flex-shrink-0">
            <div class="mb-4">
                <label for="designName" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Design Name</label>
                <input type="text" id="designName" x-model="designName" class="w-full text-sm border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-medium">
            </div>
            
            <button id="save-design-btn" class="w-full flex items-center justify-center px-6 py-4 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors rounded shadow-[2px_2px_0px_rgba(17,17,17,1)] active:shadow-none active:translate-y-0.5 active:translate-x-0.5">
                Save & Add to Cart
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </div>

    <!-- Pass data to JS -->
    <script>
        window.urbanLaceConfig = {
            shoeId: {{ $shoe->id }},
            modelType: '{{ $shoe->model_type }}',
            initialDesign: {!! json_encode($initialDesign) !!},
            saveUrl: '{{ route("configurator.save") }}',
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</x-configurator-layout>
