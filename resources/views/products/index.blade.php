<x-app-layout>
    @section('title', '| Models')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-display font-bold text-brand-black mb-4">Our Base Models</h1>
            <p class="text-xl text-brand-gray max-w-3xl">Select a silhouette below to start your customization journey. Each model is engineered for comfort and ready to become your canvas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($shoes as $shoe)
                <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col h-full border border-gray-100">
                    <div class="h-64 bg-brand-offwhite rounded-2xl flex items-center justify-center mb-6 relative group overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>
                        <span class="absolute top-4 right-4 bg-white text-brand-black text-sm font-bold px-3 py-1 rounded-full z-20">${{ number_format($shoe->base_price, 0) }}</span>
                        <!-- Replace with dynamic thumbnail later -->
                        <div class="text-gray-400 group-hover:scale-110 transition-transform duration-500 z-0">
                            [ Image: {{ $shoe->name }} ]
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-2xl font-display font-bold text-brand-black">{{ $shoe->name }}</h2>
                        </div>
                        <p class="text-brand-gray mb-6">{{ $shoe->description }}</p>
                    </div>
                    
                    <div class="mt-auto pt-6 border-t border-gray-100">
                        <a href="{{ route('products.show', $shoe->id) }}" class="btn-primary w-full text-center">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
