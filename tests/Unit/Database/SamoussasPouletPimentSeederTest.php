<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SamoussasPouletPimentSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeeds()
    {
        $this->artisan('db:seed', ['--class' => 'SamoussasPouletPimentSeeder']);
        $this->assertDatabaseHas('products', [
            'name' => 'Samoussas pimentés (poulet)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
    }
}
