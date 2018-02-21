<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeedsAdminUser()
    {
        $this->artisan('db:seed', ['--class' => 'ProductsSeeder']);
        // Samoussas
        $this->assertDatabaseHas('products', [
            'name' => 'Samoussas (poulet)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Samoussas (fromage)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Samoussas (sarcive)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Samoussas (porc)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        // Bonbons piments
        $this->assertDatabaseHas('products', [
            'name' => 'Bonbons piment',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        // Bouchons
        $this->assertDatabaseHas('products', [
            'name' => 'Bouchons (porc)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Bouchons (porc combava)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Bouchons (poulet)',
            'type' => 'starter',
            'pieces' => 4,
            'description' => null,
            'price' => 3.5,
            'disabled' => false,
        ]);
        // Plats
        $this->assertDatabaseHas('products', [
            'name' => 'Cari poulet',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 7,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Rougail saucisses',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 7,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Shop suey de légumes',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 6,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Shop suey poulet',
            'type' => 'main',
            'pieces' => 1,
            'description' => 'Servi du riz blanc et des lentilles.',
            'price' => 7,
            'disabled' => false,
        ]);
        // Rougail
        $this->assertDatabaseHas('products', [
            'name' => 'Rougail tomates',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'Pimenté',
            'price' => 0,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Rougail concombre',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'Pimenté',
            'price' => 0,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Rougail citron',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'Pimenté',
            'price' => 0,
            'disabled' => false,
        ]);
        // Boissons
        $this->assertDatabaseHas('products', [
            'name' => 'Coca-cola 33cl',
            'type' => 'drink',
            'pieces' => 1,
            'description' => null,
            'price' => 2,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Sprite 33cl',
            'type' => 'drink',
            'pieces' => 1,
            'description' => null,
            'price' => 2,
            'disabled' => false,
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Eau 50cl',
            'type' => 'drink',
            'pieces' => 1,
            'description' => null,
            'price' => 1.5,
            'disabled' => false,
        ]);
    }
}
