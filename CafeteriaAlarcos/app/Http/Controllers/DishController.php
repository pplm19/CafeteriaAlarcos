<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\DCategory;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dishes.index', ['dishes' => Dish::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dishes.create', ['types' => Type::all(), 'dcategories' => DCategory::all(), 'ingredients' => Ingredient::all(), 'allergens' => Allergen::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
            'recipe' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'type_id' => ['required', Rule::exists(Type::class, 'id')],
            'dcategories' => [
                'nullable',
                'array',
                Rule::exists(DCategory::class, 'id')
            ],
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

        $dcategories = $request->input('dcategories');
        $ingredients = $request->input('ingredients');
        $allergens = $request->input('allergens');

        if ($request->hasFile('imageFile')) {
            $file = $request->file('imageFile');
            $fileName = $file->hashName();
            $file->storeAs('public/images/dishes', $fileName);
            $request->merge(['image' => $fileName]);
        }

        $dish = Dish::create($request->all());

        if ($dcategories) $dish->dcategories()->sync($dcategories);
        if ($ingredients) $dish->ingredients()->sync($ingredients);
        if ($allergens) $dish->allergens()->sync($allergens);

        return redirect()->route('dishes.index')->withSuccess("¡Plato creado! Se ha creado satisfactoriamente el plato $dish->name.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Dish $dish)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        return view('dishes.edit', ['dish' => $dish, 'types' => Type::all(), 'dcategories' => DCategory::all(), 'ingredients' => Ingredient::all(), 'allergens' => Allergen::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'imageFile' => ['nullable', 'image'],
            'recipe' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'type_id' => ['required', Rule::exists(Type::class, 'id')],
            'dcategories' => [
                'nullable',
                'array',
                Rule::exists(DCategory::class, 'id')
            ],
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

        $dcategories = $request->input('dcategories');
        $ingredients = $request->input('ingredients');
        $allergens = $request->input('allergens');

        if ($request->hasFile('imageFile')) {
            $file = $request->file('imageFile');
            $fileName = $file->hashName();
            $file->storeAs('public/images/dishes', $fileName);
            $request->merge(['image' => $fileName]);

            $imagePath = public_path('/storage/images/dishes/' . $dish['image']);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $dish->dcategories()->sync($dcategories);
        $dish->ingredients()->sync($ingredients);
        $dish->allergens()->sync($allergens);

        $dish->update($request->all());

        return redirect()->route('dishes.index')->withSuccess('¡Plato actualizado! Los cambios se han guardado correctamente.');
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
                Rule::exists(Dish::class, 'id')
            ]
        ]);

        $dishes = $request->input('select');

        foreach ($dishes as $dish) {
            // [ERROR] ID dependency
            $dishData = Dish::find($dish);

            $image = $dishData['image'];

            $dishData->delete();

            $imagePath = public_path('/storage/images/dishes/' . $image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()->route('dishes.index')->withSuccess('¡Platos eliminados! Los registros han sido eliminados exitosamente .');
    }
}
