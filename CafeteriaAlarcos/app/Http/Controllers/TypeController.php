<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('types.index', ['types' => Type::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Type::create($request->all());

        return redirect()->route('types.index'); // Success
    }

    /**
     * Display the specified resource.
     */
    // public function show(Type $type)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('types.edit', ['type' => $type]); // Success
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $type->update($request->all());

        return redirect()->route('types.index'); // Success
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
                Rule::exists(Type::class, 'id')
            ]
        ]);

        $types = $request->input('select');

        foreach ($types as $type) {
            // [ERROR] ID dependency
            Type::find($type)->delete();
        }

        return redirect()->route('types.index'); // Success
    }
}
