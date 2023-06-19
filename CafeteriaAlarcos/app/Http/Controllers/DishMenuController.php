<?php

namespace App\Http\Controllers;

use App\Models\DishMenu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DishMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dish_id' => ['required', Rule::exists(Dish::class, 'id')],
            'menu_id' => ['required', Rule::exists(Menu::class, 'id')],
            'order' => ['required', 'numeric'],
        ]);

        DishMenu::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(DishMenu $dishMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DishMenu $dishMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DishMenu $dishMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DishMenu $dishMenu)
    {
        //
    }
}
