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
            ->assertViewHas('discounts', Discount::all());
    }

    /** @test */
    public function create()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.discounts.create'))
            ->assertStatus(200)
            ->assertViewIs('discounts.create')
            ->assertViewHas('products', Product::all())
            ->assertViewHas('productTypes', Product::TYPES);
    }

    /** @test */
    public function store()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        $data = [
            'name' => 'FREE COKE',
            'products' => [
                [
                    'id' => $product1->id,
                    'percent' => 100,
                    'required' => true
                ],
                [
                    'id' => $product2->id,
                    'percent' => 50,
                    'required' => false
                ]
            ],
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.discounts.store'), $data)
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$data['name']} a été créée avec succès !");
        $this->assertDatabaseHas('discounts', [
            'name' => $data['name']
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => Discount::findByName($data['name'])->id,
            'product_id' => $product1->id,
            'percent' => 100,
            'required' => true
        ]);
        $this->assertDatabaseHas('discount_product', [
            'discount_id' => Discount::findByName($data['name'])->id,
            'product_id' => $product2->id,
            'percent' => 50,
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
            ->assertViewHas('name', $discount->name)
            ->assertViewHas('discountProducts', $discount->products)
            ->assertViewHas('products', Product::all())
            ->assertViewHas('productTypes', Product::TYPES);
    }
}
