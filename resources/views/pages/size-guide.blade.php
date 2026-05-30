<x-app-layout>
    @section('title', '| Size Guide')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-4xl font-display font-bold text-brand-black mb-8 text-center">Size Guide</h1>
        <p class="text-lg text-brand-gray text-center mb-12">
            Find your perfect fit. Our shoes generally fit true to size. If you are between sizes, we recommend sizing up.
        </p>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-brand-offwhite">
                        <th class="p-4 border-b border-gray-200 font-semibold text-brand-black">US Men's</th>
                        <th class="p-4 border-b border-gray-200 font-semibold text-brand-black">US Women's</th>
                        <th class="p-4 border-b border-gray-200 font-semibold text-brand-black">UK</th>
                        <th class="p-4 border-b border-gray-200 font-semibold text-brand-black">EU</th>
                        <th class="p-4 border-b border-gray-200 font-semibold text-brand-black">CM</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b border-gray-100">7</td>
                        <td class="p-4 border-b border-gray-100">8.5</td>
                        <td class="p-4 border-b border-gray-100">6</td>
                        <td class="p-4 border-b border-gray-100">40</td>
                        <td class="p-4 border-b border-gray-100">25</td>
                    </tr>
                    <tr class="hover:bg-gray-50 bg-brand-offwhite/30">
                        <td class="p-4 border-b border-gray-100">8</td>
                        <td class="p-4 border-b border-gray-100">9.5</td>
                        <td class="p-4 border-b border-gray-100">7</td>
                        <td class="p-4 border-b border-gray-100">41</td>
                        <td class="p-4 border-b border-gray-100">26</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b border-gray-100">9</td>
                        <td class="p-4 border-b border-gray-100">10.5</td>
                        <td class="p-4 border-b border-gray-100">8</td>
                        <td class="p-4 border-b border-gray-100">42.5</td>
                        <td class="p-4 border-b border-gray-100">27</td>
                    </tr>
                    <tr class="hover:bg-gray-50 bg-brand-offwhite/30">
                        <td class="p-4 border-b border-gray-100">10</td>
                        <td class="p-4 border-b border-gray-100">11.5</td>
                        <td class="p-4 border-b border-gray-100">9</td>
                        <td class="p-4 border-b border-gray-100">44</td>
                        <td class="p-4 border-b border-gray-100">28</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b border-gray-100">11</td>
                        <td class="p-4 border-b border-gray-100">12.5</td>
                        <td class="p-4 border-b border-gray-100">10</td>
                        <td class="p-4 border-b border-gray-100">45</td>
                        <td class="p-4 border-b border-gray-100">29</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="bg-brand-black rounded-2xl p-8 text-white text-center">
            <h3 class="text-2xl font-bold mb-4">Still Not Sure?</h3>
            <p class="text-gray-400 mb-6">Contact our support team for personal sizing advice.</p>
            <a href="#" class="btn-accent">Contact Support</a>
        </div>
    </div>
</x-app-layout>
