<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bonbons piment
        DB::table('products')->insert([
            'name' => 'Bonbons piment',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        // Bouchons
        DB::table('products')->insert([
            'name' => 'Bouchons (porc)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Bouchons (porc combava)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Bouchons (poulet)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        // Samoussas
        DB::table('products')->insert([
            'name' => 'Samoussas (poulet)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Samoussas (fromage)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Samoussas (sarcive)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Samoussas (porc)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        // Plats
        DB::table('products')->insert([
            'name' => 'Cari poulet',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 7,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Rougail saucisses',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 7,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Shop suey de légumes',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 6,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Shop suey poulet',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 7,
            'disabled' => false,
        ]);
        // Rougail
        DB::table('products')->insert([
            'name' => 'Rougail citron',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'Pimenté',
            'price' => 0,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Rougail concombre',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'Pimenté',
            'price' => 0,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Rougail tomates',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'Pimenté',
            'price' => 0,
            'disabled' => false,
        ]);
        // Boissons
        DB::table('products')->insert([
            'name' => 'Coca-cola 33cl',
            'type' => 'drink',
            'pieces' => 1,
            'description' => null,
            'price' => 2,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Sprite 33cl',
            'type' => 'drink',
            'pieces' => 1,
            'description' => null,
            'price' => 2,
            'disabled' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Eau 50cl',
            'type' => 'drink',
            'pieces' => 1,
            'description' => null,
            'price' => 1.5,
            'disabled' => false,
        ]);
    }
}
