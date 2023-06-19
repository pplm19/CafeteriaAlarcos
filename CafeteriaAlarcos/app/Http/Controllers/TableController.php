<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

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
            'quantity' => ['required', 'numeric', 'min:1'],
            'maxNumber' => ['required', 'numeric', 'min:1'],
            'minNumber' => ['nullable', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index'); // Success
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
            'quantity' => ['required', 'numeric', 'min:1'],
            'maxNumber' => ['required', 'numeric', 'min:1'],
            'minNumber' => ['nullable', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $table->update($request->all());

        return redirect()->route('tables.index'); // Success
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index'); // Success
    }
}
