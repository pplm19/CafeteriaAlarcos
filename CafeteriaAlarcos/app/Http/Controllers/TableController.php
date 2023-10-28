<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tables.index', ['tables' => Table::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'min:1', 'max:65535'],
            'maxNumber' => ['required', 'numeric', 'min:1', 'max:65535'],
            'minNumber' => ['required', 'numeric', 'min:1', 'max:65535'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index')->withSuccess("¡Mesa creada! Se ha creado satisfactoriamente la mesa.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Table $table)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        return view('tables.edit', ['table' => $table]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'min:1', 'max:65535'],
            'maxNumber' => ['required', 'numeric', 'min:1', 'max:65535'],
            'minNumber' => ['required', 'numeric', 'min:1', 'max:65535'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $table->update($request->all());

        return redirect()->route('tables.index')->withSuccess('¡Mesa actualizada! Los cambios se han guardado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request)
    // {
    //     $request->validate([
    //         'select' => [
    //             'required',
    //             'array',
    //             Rule::exists(Table::class, 'id')
    //         ]
    //     ]);

    //     $icategories = $request->input('select');

    //     try {
    //         DB::beginTransaction();

    //         foreach ($icategories as $icategory) {
    //             Table::find($icategory)->delete();
    //         }

    //         DB::commit();

    //         return redirect()->route('tables.index')->withSuccess('¡Mesas eliminadas! Los registros han sido eliminados exitosamente.');
    //     } catch (Exception $e) {
    //         DB::rollBack();

    //         return redirect()->route('tables.index')->withError('¡Error! Ha ocurrido un error inesperado al borrar los registros, inténtelo de nuevo más tarde.');
    //     }
    // }
}
