<x-app-layout>
    @section('title', '| My Designs')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-display font-black uppercase italic tracking-tight text-brand-black">My Designs</h1>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-brand-black transition-colors">← Dashboard</a>
        </div>

        @if($designs->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($designs as $design)
            <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                <!-- Shoe Image -->
                <div class="bg-brand-offwhite rounded-xl h-40 flex items-center justify-center mb-4 overflow-hidden">
                    @if($design->shoe)
                        <img src="{{ asset('images/shoe_' . $design->shoe->model_type . '.png') }}" class="w-3/4 h-3/4 object-contain mix-blend-darken">
                    @endif
                </div>

                <!-- Design Name -->
                <h3 class="font-bold text-brand-black text-lg mb-1">{{ $design->name ?? 'Untitled Design' }}</h3>
                <p class="text-xs text-gray-500 mb-3">{{ $design->shoe->name ?? 'Unknown Model' }} • {{ $design->created_at->format('M d, Y') }}</p>

                <!-- Color Swatches -->
                @if(is_array($design->design_json))
                <div class="flex space-x-1.5 mb-4">
                    @foreach(collect($design->design_json)->filter(fn($v) => str_starts_with((string)$v, '#'))->take(8) as $zone => $color)
                        <div class="w-5 h-5 rounded-full border border-gray-300 shadow-inner" style="background-color: {{ $color }}" title="{{ ucfirst($zone) }}"></div>
                    @endforeach
                </div>
                @endif

                <!-- CTA -->
                @if($design->shoe)
                <a href="{{ route('configurator.show', $design->shoe_id) }}" class="block text-center text-xs font-bold uppercase tracking-wider text-green-500 hover:text-brand-black transition-colors border-t border-gray-100 pt-3">
                    Customize Again →
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $designs->links() }}</div>
        @else
        <div class="text-center py-20 bg-white border border-gray-100 rounded-xl">
            <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
            <h2 class="text-xl font-bold text-brand-black mb-2">No designs saved yet</h2>
            <p class="text-gray-500 mb-6">Use the 3D configurator to create your first custom design!</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 text-sm font-black uppercase tracking-wider text-brand-black bg-green-400 hover:bg-green-300 rounded transition-colors">Start Designing</a>
        </div>
        @endif
    </div>
</x-app-layout>
