<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Allergen;
use App\Models\DCategory;
use App\Models\Dish;
use App\Models\ICategory;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Turn;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Table::create([
            'quantity' => 10,
            'maxNumber' => 8,
            'minNumber' => 6
        ]);

        Table::create([
            'quantity' => 5,
            'maxNumber' => 4,
            'minNumber' => 2
        ]);

        Table::create([
            'quantity' => 2,
            'maxNumber' => 2,
            'minNumber' => 1
        ]);



        $fruta = ICategory::create([
            'name' => 'Fruta'
        ]);

        $verdura = ICategory::create([
            'name' => 'Verdura'
        ]);

        $carne = ICategory::create([
            'name' => 'Carne'
        ]);


        $zanahoria = Ingredient::create([
            'name' => 'Zanahorias',
            'i_category_id' => $fruta['id']
        ]);

        $manzana = Ingredient::create([
            'name' => 'Manzana',
            'i_category_id' => $verdura['id']
        ]);

        $pollo = Ingredient::create([
            'name' => 'Pollo',
            'i_category_id' => $carne['id']
        ]);


        $aperitivo = Type::create([
            'name' => 'Aperitivo'
        ]);

        $primerP = Type::create([
            'name' => 'Primer plato'
        ]);

        $segundoP = Type::create([
            'name' => 'Segundo plato'
        ]);

        Type::create([
            'name' => 'Postre'
        ]);


        $frutos = Allergen::create([
            'name' => 'Frutos secos'
        ]);

        Allergen::create([
            'name' => 'Gluten'
        ]);

        Allergen::create([
            'name' => 'Lactosa'
        ]);


        $vegano = DCategory::create([
            'name' => 'Vegano'
        ]);


        $ensalada = Dish::create([
            'name' => 'Ensalada de manzana',
            'type_id' => $aperitivo['id']
        ]);

        $sopa = Dish::create([
            'name' => 'Sopa de zanahoria',
            'type_id' => $primerP['id']
        ]);

        $polloHorno = Dish::create([
            'name' => 'Pollo al horno',
            'type_id' => $segundoP['id']
        ]);


        $ensalada->dcategories()->attach($vegano['id']);


        $ensalada->allergens()->attach($frutos['id']);

        $ensalada->ingredients()->attach($manzana['id']);

        $sopa->ingredients()->attach($zanahoria['id']);

        $polloHorno->ingredients()->attach($pollo['id']);


        $menu = Menu::create([
            'name' => 'Menú 1',
            'price' => 60.50,
        ]);

        $menu->dishes()->sync([
            $ensalada['id'] => ['order' => 1],
            $sopa['id'] => ['order' => 2],
            $polloHorno['id'] => ['order' => 3]
        ]);


        Turn::create([
            'name' => 'Turno 1',
            'date' => '2023-01-05',
            'start' => '10:00:00',
            'menu_id' => $menu['id']
        ]);

        Turn::create([
            'name' => 'Turno 2',
            'date' => '2023-07-02',
            'start' => '09:00:00',
            'end' => '10:00:00',
            'menu_id' => $menu['id']
        ]);

        Turn::create([
            'name' => 'Turno 3',
            'date' => '2023-07-02',
            'start' => '11:00:00',
            'menu_id' => $menu['id']
        ]);

        Turn::create([
            'name' => 'Turno 4',
            'date' => '2023-12-05',
            'start' => '10:00:00',
            'menu_id' => $menu['id']
        ]);
    }
}
