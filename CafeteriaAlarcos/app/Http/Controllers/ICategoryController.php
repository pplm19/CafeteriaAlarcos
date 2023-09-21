<?php

namespace App\Http\Controllers;

use App\Models\ICategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ICategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('icategories.index', ['icategories' => ICategory::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('icategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $icategory = ICategory::create($request->all());

        return redirect()->route('icategories.index')->withSuccess("¡Categoría creada! Se ha creado satisfactoriamente la categoría $icategory->name.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(ICategory $iCategory)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ICategory $icategory)
    {
        return view('icategories.edit', ['icategory' => $icategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ICategory $icategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $icategory->update($request->all());

        return redirect()->route('icategories.index')->withSuccess('¡Categoría actualizada! Los cambios se han guardado correctamente.');
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
                Rule::exists(ICategory::class, 'id')
            ]
        ]);

        $icategories = $request->input('select');

        foreach ($icategories as $icategory) {
            // [ERROR] ID dependency
            ICategory::find($icategory)->delete();
        }

        return redirect()->route('icategories.index')->withSuccess('¡Categorías eliminadas! Los registros han sido eliminados exitosamente .');
    }
}
