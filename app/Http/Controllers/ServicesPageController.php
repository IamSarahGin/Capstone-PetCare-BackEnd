<?php

namespace App\Http\Controllers;
use App\Models\ServicesPage;
use Illuminate\Http\Request;

class ServicesPageController extends Controller
{
    public function index()
    {
        $services = ServicesPage::all();
        return response()->json($services);
    }
}
