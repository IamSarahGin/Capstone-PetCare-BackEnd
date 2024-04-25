<?php

namespace App\Http\Controllers;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function index()
    {
        $aboutPage = AboutPage::all();
        return response()->json($aboutPage);
    }
}
