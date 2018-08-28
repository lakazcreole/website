<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use App\Discount;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['admin' => true]);
    }

    /** @test */
    public function index()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.discounts.index'))
            ->assertStatus(200)
            ->assertViewIs('discounts.index')
            ->assertViewHasAll([
                'discounts' => Discount::all(),
                'createRoute' => 'dashboard.discounts.create',
                'editRoute' => 'dashboard.discounts.edit'
            ]);
    }

    /** @test */
    public function create()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.discounts.create'))
            ->assertStatus(200)
            ->assertViewIs('discounts.create')
            ->assertViewHasAll([
                'products' => Product::all(),
                'productTypes' => Product::TYPES,
                'indexRoute' => 'dashboard.discounts.index',
                'storeRoute' => 'dashboard.discounts.store',
            ]);
    }

    /** @test */
    public function store()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $data = [
            'name' => 'FREE COKE',
            'description' => 'Boisson gratuite offerte',
            'products' => [
                [
                    'id' => $product1->id,
                    'percent' => 100,
                    'max_items' => 1,
                    'required' => true
                ],
                [
                    'id' => $product2->id,
                    'percent' => 50,
                    'max_items' => 2,
                    'required' => false
                ]
            ],
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.discounts.store'), $data)
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$data['name']} a été créée avec succès !");
        $this->assertDatabaseHas('discounts', [
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => Discount::findByName($data['name'])->id,
            'product_id' => $product1->id,
            'percent' => 100,
            'max_items' => 1,
            'required' => true
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => Discount::findByName($data['name'])->id,
            'product_id' => $product2->id,
            'percent' => 50,
            'max_items' => 2,
            'required' => false
        ]);
    }

    /** @test */
    public function edit()
    {
        $discount = factory(Discount::class)->create();
        $this->actingAs($this->admin)
            ->get(route('dashboard.discounts.edit', ['discount' => $discount]))
            ->assertStatus(200)
            ->assertViewIs('discounts.edit')
            ->assertViewHasAll([
                'id' => $discount->id,
                'name' => $discount->name,
                'description' => $discount->description,
                'discountProducts' => $discount->products,
                'products' =>  Product::all(),
                'productTypes' => Product::TYPES,
                'indexRoute' => 'dashboard.discounts.index',
                'updateRoute' => 'dashboard.discounts.update',
                'destroyRoute' => 'dashboard.discounts.destroy',
                'routeParameter' => 'discount'
            ]);
    }

    /** @test */
    public function update()
    {
        $discount = factory(Discount::class)->create();
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $data = [
            'name' => 'FREE COKE',
            'description' => 'Boisson gratuite offerte',
            'products' => [
                [
                    'id' => $product1->id,
                    'percent' => 100,
                    'max_items' => 1,
                    'required' => true
                ],
                [
                    'id' => $product2->id,
                    'percent' => 50,
                    'max_items' => 2,
                    'required' => false
                ]
            ],
        ];
        $this->actingAs($this->admin)
            ->put(route('dashboard.discounts.update', ['discount' => $discount]), $data)
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$data['name']} a été modifiée avec succès !");
        $this->assertDatabaseHas('discounts', [
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => Discount::findByName($data['name'])->id,
            'product_id' => $product1->id,
            'percent' => 100,
            'max_items' => 1,
            'required' => true
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => Discount::findByName($data['name'])->id,
            'product_id' => $product2->id,
            'percent' => 50,
            'max_items' => 2,
            'required' => false
        ]);
    }

    /** @test */
    public function destroy()
    {
        $discount = factory(Discount::class)->create();
        $this->actingAs($this->admin)
            ->delete(route('dashboard.discounts.destroy', ['discount' => $discount]))
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$discount->name} a été supprimée avec succès !");
        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);
    }
}
