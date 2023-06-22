<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\Dish;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserDishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dish::query();

        if ($request->has('search')) {
            $request->validate([
                'name' => ['nullable', 'string'],
                'ingredients' => [
                    'nullable',
                    'array',
                    Rule::exists(Ingredient::class, 'id')
                ],
                'allergens' => [
                    'nullable',
                    'array',
                    Rule::exists(Allergen::class, 'id')
                ],
            ]);

            $name = $request->input('name');
            if (strlen($name) > 0) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            }

            if ($request->has('ingredients')) {
                $ingredients = $request->input('ingredients');
                $query->whereHas('ingredients', function ($subQuery) use ($ingredients) {
                    $subQuery->whereIn('ingredient_id', $ingredients);
                });
            }

            if ($request->has('allergens')) {
                $allergens = $request->input('allergens');
                $query->whereDoesntHave('allergens', function ($subQuery) use ($allergens) {
                    $subQuery->whereIn('allergen_id', $allergens);
                });
            }

            $request->flash();
        }

        return view('userdishes.index', ['dishes' => $query->paginate(15), 'ingredients' => Ingredient::all(), 'allergens' => Allergen::all()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dish $dish)
    {
        return $dish;
    }
}
