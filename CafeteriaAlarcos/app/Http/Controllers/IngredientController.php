<?php

namespace App\Http\Controllers;

use App\Models\ICategory;
use App\Models\Ingredient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $ingredient = Ingredient::create($request->all());

        return redirect()->route('ingredients.index')->withSuccess("¡Ingrediente creado! Se ha creado satisfactoriamente el ingrediente $ingredient->name.");
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

        return redirect()->route('ingredients.index')->withSuccess('¡Ingrediente actualizado! Los cambios se han guardado correctamente.');
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

        try {
            DB::beginTransaction();

            foreach ($ingredients as $ingredient) {
                Ingredient::find($ingredient)->delete();
            }

            DB::commit();

            return redirect()->route('ingredients.index')->withSuccess('¡Ingredientes eliminados! Los registros han sido eliminados exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('ingredients.index')->withError('¡Error! Ha ocurrido un error inesperado al borrar los registros, inténtelo de nuevo más tarde.');
        }
    }
}
