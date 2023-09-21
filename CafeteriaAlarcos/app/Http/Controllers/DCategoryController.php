<?php

namespace App\Http\Controllers;

use App\Models\DCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dcategories.index', ['dcategories' => DCategory::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $dcategory = DCategory::create($request->all());

        return redirect()->route('dcategories.index')->withSuccess("¡Categoría creada! Se ha creado satisfactoriamente la categoría $dcategory->name.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(DCategory $dCategory)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DCategory $dcategory)
    {
        return view('dcategories.edit', ['dcategory' => $dcategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DCategory $dcategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $dcategory->update($request->all());

        return redirect()->route('dcategories.index')->withSuccess('¡Categoría actualizada! Los cambios se han guardado correctamente.');
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
                Rule::exists(DCategory::class, 'id')
            ]
        ]);

        $dcategories = $request->input('select');

        foreach ($dcategories as $dcategory) {
            // [ERROR] ID dependency
            DCategory::find($dcategory)->delete();
        }

        return redirect()->route('dcategories.index')->withSuccess('¡Categorías eliminadas! Los registros han sido eliminados exitosamente .');
    }
}
