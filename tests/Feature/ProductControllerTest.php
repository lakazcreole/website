<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(User::class)->create(['admin' => true]);
    }

    public function testIndex()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.products.index'))
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHasAll([
                'productTypes' => Product::TYPES,
                'products' => Product::orderBy('name')->get()
            ]);
    }

    public function testCreate()
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard.products.create'))
            ->assertStatus(200)
            ->assertViewIs('products.create')
            ->assertViewHas('productTypes', Product::TYPES);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Something new',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'It is delicious!',
            'price' => 7.5,
            'disabled' => false
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.products.store'), $data)
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "Le produit {$data['name']} a été créé.");
        $this->assertDatabaseHas('products', $data);
    }

    public function testStoreValidatesData()
    {
        $this->actingAs($this->admin)
            ->post(route('dashboard.products.store'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name', 'type', 'price', 'disabled']);
    }

    public function testEdit()
    {
        $product = factory(Product::class)->create();
        $this->actingAs($this->admin)
            ->get(route('dashboard.products.edit', ['product' => $product]))
            ->assertStatus(200)
            ->assertViewIs('products.edit')
            ->assertViewHasAll([
                'id' =>  $product->id,
                'name' =>  $product->name,
                'type' =>  $product->type,
                'pieces' =>  $product->pieces,
                'description' =>  $product->description,
                'price' =>  $product->price,
                'disabled' =>  $product->disabled,
                'productTypes' =>  Product::TYPES,
            ]);
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'Something new',
            'type' => 'side',
            'pieces' => 1,
            'description' => 'It is delicious!',
            'price' => 7.5,
            'disabled' => false
        ];
        $product = factory(Product::class)->create();
        $this->actingAs($this->admin)
            ->post(route('dashboard.products.update', ['product' => $product]), $data)
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "Le produit {$data['name']} a été modifié.");
        $this->assertDatabaseHas('products', $data);
    }

    public function testUpdateWithSameName()
    {
        $product = factory(Product::class)->create();
        $data = [
            'name' => $product->name,
            'type' => 'side',
            'pieces' => 1,
            'description' => 'It is delicious!',
            'price' => 7.5,
            'disabled' => false
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.products.update', ['product' => $product]), $data)
            ->assertRedirect(route('dashboard.orders.index'))
            ->assertSessionHas('success', "Le produit {$data['name']} a été modifié.");
        $this->assertDatabaseHas('products', $data);
    }
}
