<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        try {
            DB::beginTransaction();

            foreach ($allergens as $allergen) {
                Allergen::find($allergen)->delete();
            }

            DB::commit();

            return redirect()->route('allergens.index')->withSuccess('¡Alérgenos eliminados! Los registros han sido eliminados exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('allergens.index')->withError('¡Error! No se pudieron eliminar algunos alérgenos seleccionados ya que están vinculados a un plato.');
        }
    }
}
