<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientDish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IngredientDishController extends Controller
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
            'ingredient_id' => ['required', Rule::exists(Ingredient::class, 'id')],
        ]);

        IngredientDish::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientDish $ingredientDish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IngredientDish $ingredientDish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IngredientDish $ingredientDish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IngredientDish $ingredientDish)
    {
        //
    }
}
