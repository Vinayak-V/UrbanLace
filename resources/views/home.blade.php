<x-app-layout>
    <!-- Powerful Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden bg-brand-black -mt-20">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/lifestyle_hero.png') }}" alt="Custom Sneakers in Action" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pt-32 pb-20">
            <div class="max-w-3xl">
                <h1 class="text-6xl md:text-8xl lg:text-[10rem] font-display font-black text-white leading-[0.85] tracking-tighter uppercase italic mb-6">
                    LEVEL UP <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-300">YOUR KICKS</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 font-medium tracking-wide max-w-xl">
                    100% CUSTOM. HANDCRAFTED. BUILT FOR THE STREETS.
                </p>
                <a href="#explore" class="inline-flex items-center justify-center px-8 py-4 text-lg font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors transform hover:-translate-y-1 rounded shadow-[4px_4px_0px_rgba(255,255,255,1)]">
                    Start Designing
                    <svg class="ml-2 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Brand / Trust Strip -->
    <div class="bg-white py-8 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Premium Materials Sourced From</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                <div class="font-display font-black text-2xl tracking-tighter">VIBRAM</div>
                <div class="font-display font-black text-2xl tracking-tighter">GORE-TEX</div>
                <div class="font-display font-black text-2xl tracking-tighter">CORDURA</div>
                <div class="font-display font-black text-2xl tracking-tighter">HORWEEN</div>
                <div class="font-display font-black text-2xl tracking-tighter">PRIMA-LOFT</div>
            </div>
        </div>
    </div>

    <!-- Category Bento Grid -->
    <section class="py-16 bg-brand-offwhite">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredShoes as $catShoe)
                <a href="{{ route('products.show', $catShoe->id) }}" class="group relative h-[400px] overflow-hidden bg-gray-900 rounded">
                    @php
                        $catImages = ['low' => 'shoe_low.png', 'mid' => 'shoe_mid.png', 'high' => 'shoe_high.png'];
                        $catLabels = ['low' => 'Low Tops', 'mid' => 'Mid Tops', 'high' => 'High Tops'];
                    @endphp
                    <img src="{{ asset('images/' . ($catImages[$catShoe->model_type] ?? 'shoe_low.png')) }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 flex justify-between items-end">
                        <h3 class="text-2xl font-black text-white uppercase italic tracking-wide">{{ $catLabels[$catShoe->model_type] ?? $catShoe->name }}</h3>
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-full flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Best Sellers Grid -->
    <section id="explore" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <h2 class="text-5xl font-display font-black text-brand-black uppercase italic tracking-tight">Best Sellers</h2>
                
                <!-- Smart Filtering -->
                <div class="flex space-x-2 mt-6 md:mt-0 bg-brand-offwhite p-1 rounded-full">
                    <button class="px-6 py-2 bg-white shadow-sm rounded-full text-sm font-bold uppercase tracking-wider text-brand-black">All</button>
                    <button class="px-6 py-2 text-sm font-bold uppercase tracking-wider text-gray-500 hover:text-brand-black">Outdoor</button>
                    <button class="px-6 py-2 text-sm font-bold uppercase tracking-wider text-gray-500 hover:text-brand-black">Urban</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Shoe Cards dynamically populated -->
                @php
                    $images = ['shoe_low.png', 'shoe_mid.png', 'shoe_high.png'];
                @endphp
                @foreach($featuredShoes as $index => $shoe)
                <a href="{{ route('products.show', $shoe->id) }}" class="group border border-gray-100 p-4 rounded hover:shadow-xl transition-shadow bg-white flex flex-col h-full no-underline">
                    <div class="relative bg-brand-offwhite aspect-square mb-4 flex items-center justify-center rounded overflow-hidden">
                        <!-- Simulated Product Image -->
                        <img src="{{ asset('images/' . $images[$index % 3]) }}" class="w-4/5 h-4/5 object-contain mix-blend-darken group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-bold text-lg text-brand-black">{{ $shoe->name }}</h3>
                        </div>
                        <div class="flex items-center space-x-1 mb-2">
                            <div class="flex text-yellow-400">
                                @for($i=0; $i<5; $i++) <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                            </div>
                            <span class="text-xs text-gray-500">(42)</span>
                        </div>
                        <p class="text-lg font-black text-brand-black mb-4">${{ number_format($shoe->base_price, 0) }}</p>
                    </div>
                    <div class="flex justify-between items-center mt-auto border-t border-gray-100 pt-4">
                        <div class="flex space-x-2">
                            <div class="w-4 h-4 rounded-full bg-black border border-gray-300"></div>
                            <div class="w-4 h-4 rounded-full bg-white border border-gray-300"></div>
                            <div class="w-4 h-4 rounded-full bg-red-500 border border-gray-300"></div>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-green-500 group-hover:text-brand-black transition-colors flex items-center">
                            Customize <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </a>
                @endforeach
                <!-- Duplicate last for grid fill (demo) -->
                @if(isset($featuredShoes[0]))
                <a href="{{ route('products.show', $featuredShoes[0]->id) }}" class="group border border-gray-100 p-4 rounded hover:shadow-xl transition-shadow bg-white flex flex-col h-full no-underline">
                    <div class="relative bg-brand-offwhite aspect-square mb-4 flex items-center justify-center rounded overflow-hidden">
                        <img src="{{ asset('images/shoe_low.png') }}" class="w-4/5 h-4/5 object-contain mix-blend-darken group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-bold text-lg text-brand-black mb-1">Urban Core Essential</h3>
                        <div class="flex items-center space-x-1 mb-2">
                            <div class="flex text-yellow-400">@for($i=0; $i<5; $i++) <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor</div>
                            <span class="text-xs text-gray-500">(128)</span>
                        </div>
                        <p class="text-lg font-black text-brand-black mb-4">$110</p>
                    </div>
                    <div class="flex justify-between items-center mt-auto border-t border-gray-100 pt-4">
                        <div class="flex space-x-2">
                            <div class="w-4 h-4 rounded-full bg-blue-500 border border-gray-300"></div>
                            <div class="w-4 h-4 rounded-full bg-yellow-400 border border-gray-300"></div>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-green-500 group-hover:text-brand-black transition-colors flex items-center">
                            Customize <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Custom Promo Banner -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded overflow-hidden bg-brand-black flex items-center min-h-[300px]">
                <img src="{{ asset('images/lifestyle_hero.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent"></div>
                <div class="relative z-10 p-12 max-w-2xl">
                    <h2 class="text-4xl md:text-6xl font-display font-black text-white uppercase italic tracking-tight mb-4">
                        CUSTOM SNEAKER <span class="text-green-400">ACCESSORIES</span>
                    </h2>
                    <p class="text-gray-300 text-lg mb-8">Premium laces, custom aglets, and care kits designed to keep your kicks fresh.</p>
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 transition-colors rounded">
                        Shop Accessories
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews -->
    <section class="py-20 bg-brand-offwhite">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <h2 class="text-5xl font-display font-black text-brand-black uppercase italic tracking-tight">Customer Reviews</h2>
                <div class="flex items-center mt-4 md:mt-0">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i=0; $i<5; $i++) <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <span class="text-brand-black font-bold text-lg">4.9/5 from 2,000+ reviews</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Review 1 -->
                <div class="bg-white p-8 rounded border border-gray-100 shadow-sm flex flex-col h-full relative">
                    <svg class="absolute top-6 right-6 w-8 h-8 text-gray-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" /></svg>
                    <div class="flex text-yellow-400 mb-4 z-10">
                        @for($i=0; $i<5; $i++) <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <p class="text-brand-black text-lg italic mb-6 flex-grow z-10">"Honestly the best custom sneakers I've ever owned. The configurator was super easy to use and the final product is flawless. The Italian leather feels incredibly premium."</p>
                    <div class="flex items-center z-10 mt-auto">
                        <div class="w-10 h-10 bg-brand-black rounded-full flex items-center justify-center text-white font-bold mr-3">MJ</div>
                        <div>
                            <p class="font-bold text-brand-black text-sm">Marcus J.</p>
                            <p class="text-xs text-gray-500">Purchased High Tops</p>
                        </div>
                    </div>
                </div>
                <!-- Review 2 -->
                <div class="bg-white p-8 rounded border border-gray-100 shadow-sm flex flex-col h-full relative">
                    <svg class="absolute top-6 right-6 w-8 h-8 text-gray-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" /></svg>
                    <div class="flex text-yellow-400 mb-4 z-10">
                        @for($i=0; $i<5; $i++) <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <p class="text-brand-black text-lg italic mb-6 flex-grow z-10">"I get compliments every time I wear these out. Being able to choose the exact colors for the swoosh, laces, and sole made it so personal. Arrived exactly in 2 weeks."</p>
                    <div class="flex items-center z-10 mt-auto">
                        <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center text-brand-black font-bold mr-3">SP</div>
                        <div>
                            <p class="font-bold text-brand-black text-sm">Sarah P.</p>
                            <p class="text-xs text-gray-500">Purchased Low Tops</p>
                        </div>
                    </div>
                </div>
                <!-- Review 3 -->
                <div class="bg-white p-8 rounded border border-gray-100 shadow-sm flex flex-col h-full relative">
                    <svg class="absolute top-6 right-6 w-8 h-8 text-gray-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" /></svg>
                    <div class="flex text-yellow-400 mb-4 z-10">
                        @for($i=0; $i<5; $i++) <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <p class="text-brand-black text-lg italic mb-6 flex-grow z-10">"The craftsmanship is insane. You can smell the real leather out of the box. They fit perfectly and look exactly like the 3D model I built on the website."</p>
                    <div class="flex items-center z-10 mt-auto">
                        <div class="w-10 h-10 bg-brand-black rounded-full flex items-center justify-center text-white font-bold mr-3">DL</div>
                        <div>
                            <p class="font-bold text-brand-black text-sm">David L.</p>
                            <p class="text-xs text-gray-500">Purchased Mid Tops</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
