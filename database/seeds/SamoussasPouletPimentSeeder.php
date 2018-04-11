<?php

use Illuminate\Database\Seeder;

class SamoussasPouletPimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Samoussas pimentés (poulet)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
    }
}
