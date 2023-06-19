<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configurations.index', ['configurations' => Configuration::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(Configuration $configuration)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Configuration $configuration)
    {
        return view('configurations.edit', ['configuration' => $configuration]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuration $configuration)
    {
        $request->validate([
            'value' => ['required', 'string'],
        ]);

        $configuration->update($request->all());

        return redirect()->route('configurations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Configuration $configuration)
    // {
    //     //
    // }
}
