<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AllergenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('allergens.index', ['allergens' => Allergen::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('allergens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $allergen = Allergen::create($request->all());

        return redirect()->route('allergens.index')->withSuccess("¡Alérgeno creado! Se ha creado satisfactoriamente el alérgeno $allergen->name.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Allergen $allergen)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allergen $allergen)
    {
        return view('allergens.edit', ['allergen' => $allergen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allergen $allergen)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $allergen->update($request->all());

        return redirect()->route('allergens.index')->withSuccess('¡Alérgeno actualizado! Los cambios se han guardado correctamente.');
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
                Rule::exists(Allergen::class, 'id')
            ]
        ]);

        $allergens = $request->input('select');

        foreach ($allergens as $allergen) {
            // [ERROR] ID dependency
            Allergen::find($allergen)->delete();
        }

        return redirect()->route('allergens.index')->withSuccess('¡Alérgenos eliminados! Los registros han sido eliminados exitosamente .');
    }
}
