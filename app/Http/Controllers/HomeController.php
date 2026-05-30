<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredShoes = Shoe::where('is_active', true)->take(3)->get();
        return view('home', compact('featuredShoes'));
    }
}
