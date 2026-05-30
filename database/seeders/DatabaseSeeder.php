<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@urbanlace.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@urbanlace.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Materials
        $materials = [
            ['name' => 'Premium Leather', 'price_modifier' => 20.00, 'type' => 'leather', 'is_active' => true],
            ['name' => 'Suede', 'price_modifier' => 15.00, 'type' => 'suede', 'is_active' => true],
            ['name' => 'Canvas', 'price_modifier' => 0.00, 'type' => 'canvas', 'is_active' => true],
            ['name' => 'Mesh', 'price_modifier' => 5.00, 'type' => 'mesh', 'is_active' => true],
        ];

        foreach ($materials as $mat) {
            \App\Models\Material::create($mat);
        }

        // Shoes & Color Zones
        $shoesData = [
            [
                'name' => 'Urban Classic Low',
                'base_price' => 120.00,
                'model_type' => 'low',
                'description' => 'A timeless low-top silhouette perfect for everyday wear.',
                'is_active' => true,
                'zones' => ['vamp', 'quarter', 'swoosh', 'heel', 'midsole', 'outsole', 'laces', 'tongue']
            ],
            [
                'name' => 'Urban Court Mid',
                'base_price' => 140.00,
                'model_type' => 'mid',
                'description' => 'Mid-top design offering better ankle support with street-ready style.',
                'is_active' => true,
                'zones' => ['vamp', 'quarter', 'swoosh', 'heel', 'midsole', 'outsole', 'laces', 'tongue', 'collar']
            ],
            [
                'name' => 'Urban Pro High',
                'base_price' => 160.00,
                'model_type' => 'high',
                'description' => 'Premium high-top sneaker for maximum impact and ankle support.',
                'is_active' => true,
                'zones' => ['vamp', 'quarter', 'swoosh', 'heel', 'midsole', 'outsole', 'laces', 'tongue', 'collar', 'strap']
            ]
        ];

        foreach ($shoesData as $shoeData) {
            $zones = $shoeData['zones'];
            unset($shoeData['zones']);

            $shoe = \App\Models\Shoe::create($shoeData);

            foreach ($zones as $zone) {
                \App\Models\ColorZone::create([
                    'shoe_id' => $shoe->id,
                    'name' => ucfirst($zone),
                    'mesh_name' => $zone, // This will match the Three.js mesh node name
                    'default_color' => '#FFFFFF',
                ]);
            }
        }

        // Delivery Options
        $deliveryOptions = [
            ['name' => 'Standard Shipping', 'description' => 'Handcrafted and shipped within 2-3 weeks.', 'price' => 0.00, 'estimated_days_min' => 14, 'estimated_days_max' => 21, 'is_active' => true],
            ['name' => 'Express Crafting', 'description' => 'Priority crafting and express shipping.', 'price' => 25.00, 'estimated_days_min' => 7, 'estimated_days_max' => 10, 'is_active' => true],
            ['name' => 'Rush Order', 'description' => 'Top priority. Fastest turnaround available.', 'price' => 50.00, 'estimated_days_min' => 3, 'estimated_days_max' => 5, 'is_active' => true],
        ];

        foreach ($deliveryOptions as $opt) {
            \App\Models\DeliveryOption::create($opt);
        }
    }
}
