<?php

namespace App\Http\Controllers;

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
        return view('menus.create');
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
                'nullable',
                'array',
                Rule::exists(Dish::class, 'id')
            ],
        ]);

        $dishes = $request->input('dishes');

        $menu = Menu::create($request->all());

        if ($dishes) $menu->dishes()->sync($dishes);

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
        return view('menus.edit', ['menu' => $menu]);
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

        $dishes = $request->input('dishes');

        $menu->update($request->all());

        $menu->dishes()->sync($dishes);

        return redirect()->route('menus.index')->withSuccess('¡Menú actualizado! Los cambios se han guardado correctamente.');
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
                Rule::exists(Menu::class, 'id')
            ]
        ]);

        $menus = $request->input('select');

        try {
            DB::beginTransaction();

            foreach ($menus as $menu) {
                Menu::find($menu)->delete();
            }

            DB::commit();

            return redirect()->route('menus.index')->withSuccess('¡Menús eliminados! Los registros han sido eliminados exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('menus.index')->withError('¡Error! No se pudieron eliminar algunos menús seleccionados ya que están vinculados a varios platos.');
        }
    }
}
