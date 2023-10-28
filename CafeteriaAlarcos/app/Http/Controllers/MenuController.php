<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Menu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menus.index', ['menus' => Menu::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menus.create', ['dishTypes' => Dish::all()->groupBy('type_id')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'dishes' => [
                'required',
                'array',
                Rule::exists(Dish::class, 'id')
            ],
        ]);

        $menu = Menu::create($request->all());

        $dishes = $request->input('dishes');

        if (!empty($dishes)) {
            foreach ($dishes as $pos => $dish) {
                $menu->dishes()->attach([$dish => ['order' => $pos]]);
            }
        }

        return redirect()->route('menus.index')->withSuccess("¡Menú creado! Se ha creado satisfactoriamente el menú $menu->name.");
    }

    /**
     * Display the specified resource.
     */
    // public function show(Menu $menu)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('menus.edit', ['menu' => $menu, 'dishTypes' => Dish::all()->groupBy('type_id')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'dishes' => [
                'nullable',
                'array',
                Rule::exists(Dish::class, 'id')
            ],
        ]);

        $menu->update($request->all());

        $dishes = $request->input('dishes');

        $dishesSync = [];

        if (!empty($dishes)) {
            foreach ($dishes as $pos => $dish) {
                $dishesSync[$dish] = ['order' => $pos];
            }
        }

        $menu->dishes()->sync($dishesSync);

        return redirect()->route('menus.index')->withSuccess('¡Menú actualizado! Los cambios se han guardado correctamente.');
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
    //             Rule::exists(Menu::class, 'id')
    //         ]
    //     ]);

    //     $menus = $request->input('select');

    //     // [ERROR]
    //     try {
    //         DB::beginTransaction();

    //         foreach ($menus as $menu) {
    //             $menuDB = Menu::find($menu);
    //             $menuDB->dishes()->detach();
    //             $menuDB->delete();
    //         }

    //         DB::commit();

    //         return redirect()->route('menus.index')->withSuccess('¡Menús eliminados! Los registros han sido eliminados exitosamente.');
    //     } catch (Exception $e) {
    //         DB::rollBack();

    //         return redirect()->route('menus.index')->withError('¡Error! No se pudieron eliminar algunos menús seleccionados ya que están vinculados uno o varios turnos.');
    //     }
    // }
}
