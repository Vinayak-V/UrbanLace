<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Models\ShoeDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConfiguratorController extends Controller
{
    public function show($id)
    {
        $shoe = Shoe::with('colorZones')->findOrFail($id);
        
        // Pass a default empty design JSON if none exists
        $initialDesign = new \stdClass();
        foreach ($shoe->colorZones as $zone) {
            $initialDesign->{$zone->mesh_name} = $zone->default_color;
        }

        $materials = \App\Models\Material::where('is_active', true)->get();

        return view('configurator.show', compact('shoe', 'initialDesign', 'materials'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'shoe_id' => 'required|exists:shoes,id',
            'design_json' => 'required|json',
            'design_name' => 'nullable|string|max:255',
        ]);

        $designData = [
            'shoe_id' => $request->shoe_id,
            'design_json' => json_decode($request->design_json, true),
            'name' => $request->design_name ?? 'My Custom Design',
            'user_id' => Auth::id() ?? 0,
        ];

        try {
            $design = ShoeDesign::create($designData);
            return response()->json(['success' => true, 'design_id' => $design->id, 'message' => 'Design saved successfully!']);
        } catch (\Exception $e) {
            Log::error('Error saving design: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save design.'], 500);
        }
    }
}
