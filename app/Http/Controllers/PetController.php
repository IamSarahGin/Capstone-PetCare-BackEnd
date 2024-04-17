<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function index()
{
    $pets = Pet::all(['id', 'pet_type']); // Retrieve only id and pet_type columns
    return response()->json($pets);
}


public function store(Request $request)
{
    $pet = Pet::create($request->all());
    return response()->json($pet, 201);
}


    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return response()->json($pet);
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $pet->update($request->all());
        return response()->json($pet, 200);
    }

    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();
        return response()->json(null, 204);
    }
}
