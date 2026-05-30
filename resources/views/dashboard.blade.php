<x-app-layout>
    @section('title', '| Dashboard')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Welcome -->
        <div class="mb-10">
            <h1 class="text-4xl font-display font-black uppercase italic tracking-tight text-brand-black mb-2">Welcome back, {{ $user->name }}!</h1>
            <p class="text-gray-500 font-medium">Manage your designs, orders, and account from here.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Orders</span>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-brand-black">{{ $ordersCount }}</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Saved Designs</span>
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-brand-black">{{ $designsCount }}</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Spent</span>
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-brand-black">${{ number_format($totalSpent, 0) }}</p>
            </div>
        </div>

        <!-- Quick Actions & Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Quick Actions -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Quick Actions</h3>
                <a href="{{ route('products.index') }}" class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl hover:shadow-md transition-shadow group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-green-400 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <span class="font-bold text-brand-black text-sm">Design New Shoe</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('dashboard.orders') }}" class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl hover:shadow-md transition-shadow group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-brand-offwhite flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <span class="font-bold text-brand-black text-sm">All Orders</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('dashboard.designs') }}" class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl hover:shadow-md transition-shadow group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-brand-offwhite flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                        </div>
                        <span class="font-bold text-brand-black text-sm">My Designs</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Recent Orders</h3>
                @if($recentOrders->count() > 0)
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-brand-offwhite">
                                <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Order</th>
                                <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Date</th>
                                <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Status</th>
                                <th class="text-right text-xs font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr class="border-t border-gray-50 hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('dashboard.orderDetail', $order->id) }}'">
                                <td class="px-6 py-4 font-bold text-brand-black text-sm">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'crafting' => 'bg-purple-100 text-purple-800',
                                            'shipped' => 'bg-indigo-100 text-indigo-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-brand-black text-sm">${{ number_format($order->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="bg-white border border-gray-100 rounded-xl p-10 text-center">
                    <p class="text-gray-400 mb-4">No orders yet. Time to design your first custom pair!</p>
                    <a href="{{ route('products.index') }}" class="text-green-500 font-bold text-sm hover:text-brand-black transition-colors">Browse Models →</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
