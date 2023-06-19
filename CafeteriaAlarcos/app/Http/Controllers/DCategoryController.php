<?php

namespace App\Http\Controllers;

use App\Models\DCategory;
use Illuminate\Http\Request;

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

        DCategory::create($request->all());

        return redirect()->route('dcategories.index'); // Success
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
        return view('dcategories.edit', ['dcategory' => $dcategory]); // Success
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

        return redirect()->route('dcategories.index'); // Success
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DCategory $dcategory)
    {
        $dcategory->delete();

        return redirect()->route('dcategories.index'); // Success
    }
}
