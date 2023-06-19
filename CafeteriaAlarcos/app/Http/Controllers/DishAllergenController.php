<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\Dish;
use App\Models\DishAllergen;
use App\Models\DishCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DishAllergenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dish_id' => ['required', Rule::exists(Dish::class, 'id')],
            'allergen_id' => ['required', Rule::exists(Allergen::class, 'id')],
        ]);

        DishAllergen::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(DishAllergen $dishAllergen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DishAllergen $dishAllergen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DishAllergen $dishAllergen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DishAllergen $dishAllergen)
    {
        //
    }
}
