<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        class="fixed w-full top-4 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8">
    <nav aria-label="Top" 
         :class="{ 'bg-white/95 backdrop-blur-md shadow-lg shadow-black/5 border-gray-200': scrolled, 'bg-white shadow-md border-transparent': !scrolled }"
         class="max-w-7xl mx-auto rounded-full border px-6 transition-all duration-300">
        <div class="w-full h-16 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('home') ?? '/' }}" class="font-display font-black text-2xl tracking-tighter text-brand-black italic">
                    URBANLACE<span class="text-green-400">.</span>
                </a>
                <div class="hidden ml-12 space-x-8 lg:flex items-center h-full">
                    <a href="#" class="text-sm font-bold uppercase tracking-wide text-brand-black hover:text-green-500 transition-colors">Men</a>
                    <a href="#" class="text-sm font-bold uppercase tracking-wide text-brand-black hover:text-green-500 transition-colors">Women</a>
                    <a href="#" class="text-sm font-bold uppercase tracking-wide text-brand-black hover:text-green-500 transition-colors">Collections</a>
                    <a href="#" class="text-sm font-black uppercase tracking-wide text-green-500 flex items-center bg-green-50 px-3 py-1.5 rounded-full hover:bg-green-100 transition-colors">
                        Customize 
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-5">
                <!-- Search -->
                <button class="text-brand-black hover:text-green-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
                <!-- Cart -->
                <button class="text-brand-black hover:text-green-500 transition-colors relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="absolute -top-1.5 -right-1.5 bg-green-500 text-brand-black text-[10px] font-black rounded-full h-4 w-4 flex items-center justify-center">0</span>
                </button>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="hidden lg:inline-flex items-center justify-center h-9 px-4 rounded-full bg-brand-black text-white text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden lg:inline-flex items-center justify-center h-9 px-4 rounded-full border-2 border-brand-black text-brand-black text-xs font-bold uppercase tracking-wider hover:bg-brand-black hover:text-white transition-colors">Sign in</a>
                    <a href="{{ route('register') }}" class="hidden lg:inline-flex items-center justify-center h-9 px-4 rounded-full bg-green-400 text-brand-black text-xs font-bold uppercase tracking-wider hover:bg-green-300 transition-colors shadow-[2px_2px_0px_rgba(17,17,17,1)]">Register</a>
                @endauth
                
                <!-- Mobile menu button -->
                <div class="lg:hidden ml-2 flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-brand-black hover:text-green-500 focus:outline-none">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" x-show="mobileMenuOpen" style="display:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" style="display:none;" class="lg:hidden flex flex-col space-y-4 pb-6 pt-2 px-2">
            <a href="#" class="text-sm font-bold uppercase text-brand-black">Men</a>
            <a href="#" class="text-sm font-bold uppercase text-brand-black">Women</a>
            <a href="#" class="text-sm font-bold uppercase text-brand-black">Collections</a>
            <a href="#" class="text-sm font-black uppercase text-green-500">Customize</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-bold uppercase text-brand-black">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold uppercase text-brand-black">Sign in</a>
                <a href="{{ route('register') }}" class="text-sm font-black uppercase text-green-500">Register</a>
            @endauth
        </div>
    </nav>
</header>
