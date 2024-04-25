<?php

namespace App\Http\Controllers;
use App\Models\HomePage;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $homePage = HomePage::all();
        return response()->json($homePage);
    }
}
