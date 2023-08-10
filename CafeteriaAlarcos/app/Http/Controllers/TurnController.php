<?php

namespace App\Http\Controllers;

use App\Models\Turn;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TurnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'searchDate' => ['nullable', 'date'],
        ]);

        $data = [
            'turns' => Turn::distinct('date')->orderBy('date', 'DESC')->get('date')
        ];

        if ($request->has('search')) {
            $data['turnsList'] = Turn::whereDate('date', $request->input('searchDate'))->paginate(15);

            $request->flash();
        }

        return view('turns.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('turns.create', ['date' => $request->input('date')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['nullable', 'date_format:H:i', 'after:start'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Turn::create($request->all());

        return redirect()->route('turns.index', ['search' => true, 'searchDate' => $request->input('date')]); // Success
    }

    /**
     * Display the specified resource.
     */
    // public function show(Turn $turn)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turn $turn)
    {
        return view('turns.edit', ['turn' => $turn]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turn $turn)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'start' => ['required', 'date_format:H:i:s'],
            'end' => ['nullable', 'date_format:H:i:s', 'after:start'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $turn->update($request->all());

        return redirect()->route('turns.index'); // Success
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turn $turn)
    {
        $turn->delete();

        return redirect()->route('turns.index'); // Success
    }

    public function copyStructure(Request $request)
    {
        $request->validate([
            'date' => ['required', Rule::exists(Turn::class, 'date')]
        ]);

        return view('turns.copy', ['copyFrom' => $request->input('date')]);
    }

    public function storeCopyStructure(Request $request)
    {
        $request->validate([
            'copyFrom' => ['required', Rule::exists(Turn::class, 'date')],
            'date' => ['required', 'date'],
        ]);

        $copyFrom = $request->input('copyFrom');
        $date = $request->input('date');

        $turns = Turn::whereDate('date', $copyFrom)->get();

        foreach ($turns as $turn) {
            $turnCopy = $turn->replicate()->fill([
                'date' => $date
            ]);

            $turnCopy->save();
        }

        return redirect()->route('turns.index', ['search' => true, 'searchDate' => $date]); // Success
    }

    public function destroyStructure(Request $request)
    {
        $request->validate([
            'date' => ['required', Rule::exists(Turn::class, 'date')]
        ]);

        $turns = Turn::whereDate('date', $request->input('date'))->get();

        foreach ($turns as $turn) {
            $turn->delete();
        }

        return redirect()->route('turns.index'); // Success
    }
}