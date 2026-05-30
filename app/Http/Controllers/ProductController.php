<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $shoes = Shoe::where('is_active', true)->get();
        return view('products.index', compact('shoes'));
    }

    public function show($id)
    {
        $shoe = Shoe::with('colorZones')->findOrFail($id);
        return view('products.show', compact('shoe'));
    }
}
