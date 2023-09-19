<?php

namespace App\Http\Controllers;

use App\Models\ICategory;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ingredients.index', ['ingredients' => Ingredient::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ingredients.create', ['icategories' => ICategory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'i_category_id' => ['required', Rule::exists(ICategory::class, 'id')],
        ]);

        Ingredient::create($request->all());

        return redirect()->route('ingredients.index'); // Success
    }

    /**
     * Display the specified resource.
     */
    // public function show(Ingredient $ingredient)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', ['ingredient' => $ingredient, 'icategories' => ICategory::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'i_category_id' => ['required', Rule::exists(ICategory::class, 'id')],
        ]);

        $ingredient->update($request->all());

        return redirect()->route('ingredients.index'); // Success
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'select' => [
                'required',
                'array',
                Rule::exists(Ingredient::class, 'id')
            ]
        ]);

        $ingredients = $request->input('select');

        foreach ($ingredients as $ingredient) {
            // [ERROR] ID dependency
            Ingredient::find($ingredient)->delete();
        }

        return redirect()->route('ingredients.index'); // Success
    }
}
