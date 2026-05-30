<x-app-layout>
    @section('title', '| ' . $shoe->name)

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Left: Product Image Gallery -->
            <div x-data="{
                    activeIndex: 0,
                    images: [
                        { url: '{{ asset('images/shoe_' . $shoe->model_type . '.png') }}', class: '' },
                        { url: '{{ asset('images/shoe_' . $shoe->model_type . '.png') }}', class: 'scale-x-[-1]' },
                        { url: '{{ asset('images/shoe_' . $shoe->model_type . '.png') }}', class: 'rotate-[15deg] scale-90' }
                    ]
                }" 
                class="bg-brand-offwhite rounded-3xl h-[500px] lg:h-[700px] flex items-center justify-center relative p-8">
                
                <div class="text-center w-full h-full flex items-center justify-center">
                    <!-- Main Image -->
                    <img :src="images[activeIndex].url" 
                         :class="images[activeIndex].class" 
                         alt="{{ $shoe->name }}" 
                         class="w-4/5 h-4/5 object-contain mix-blend-darken transition-all duration-500 hover:scale-105 drop-shadow-2xl">
                </div>
                
                <!-- Thumbnails -->
                <div class="absolute bottom-8 left-8 right-8 flex justify-center space-x-4">
                    <template x-for="(image, index) in images" :key="index">
                        <div @click="activeIndex = index"
                             class="w-20 h-20 bg-white rounded-xl shadow-sm border flex items-center justify-center cursor-pointer transition-all duration-200 p-2 overflow-hidden"
                             :class="activeIndex === index ? 'border-brand-black ring-2 ring-brand-black/20' : 'border-gray-200 hover:border-gray-400'">
                            <img :src="image.url" :class="image.class" class="max-w-full max-h-full object-contain mix-blend-darken">
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right: Product Info & CTA -->
            <div class="flex flex-col justify-center">
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-brand-gray">
                        <li><a href="{{ route('home') }}" class="hover:text-brand-black">Home</a></li>
                        <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-brand-black">Models</a></li>
                        <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                        <li class="font-medium text-brand-black" aria-current="page">{{ $shoe->name }}</li>
                    </ol>
                </nav>

                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-display font-bold text-brand-black mb-4">{{ $shoe->name }}</h1>
                    <div class="text-3xl text-brand-coral font-bold tracking-tight mb-6">${{ number_format($shoe->base_price, 2) }}</div>
                    <p class="text-lg text-brand-gray leading-relaxed">{{ $shoe->description }}</p>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 mb-10">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-brand-black mb-4">Customizable Zones</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($shoe->colorZones as $zone)
                            <span class="bg-white border border-gray-200 text-brand-gray text-xs font-semibold px-3 py-1 rounded-full">{{ $zone->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col space-y-4">
                    <a href="{{ route('configurator.show', $shoe->id) }}" class="inline-flex items-center justify-between px-8 py-4 text-lg font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors transform hover:-translate-y-1 rounded shadow-[4px_4px_0px_rgba(255,255,255,1)]">
                        <span>Launch 3D Configurator</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <p class="text-center text-sm text-brand-gray mt-4 font-medium">
                        Estimated delivery: 2-3 weeks. Free returns within 30 days.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
