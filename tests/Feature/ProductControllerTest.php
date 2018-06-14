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

    protected $productTypes = [
        [ 'type' => 'starter', 'title' => 'Entrées' ],
        [ 'type' => 'main', 'title' => 'Plats' ],
        [ 'type' => 'drink', 'title' => 'Boissons' ],
        [ 'type' => 'side', 'title' => 'Accompagnements' ],
    ];

    public function testIndex()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->get(route('dashboard.products.index'))
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('productTypes', $this->productTypes)
            ->assertViewHas('products', Product::all())
            ->assertViewHas('apiToken', $user->api_token);
    }

    public function testCreate()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->get(route('dashboard.products.create'))
            ->assertStatus(200)
            ->assertViewIs('products.create')
            ->assertViewHas('productTypes', $this->productTypes);
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
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->post(route('dashboard.products.store'), $data)
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('success', "Le produit {$data['name']} a été créé avec succès !");
        $this->assertDatabaseHas('products', $data);
    }

    public function testStoreValidatesData()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $this->actingAs($user)
            ->post(route('dashboard.products.store'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name', 'type', 'price', 'disabled']);
    }

    public function testEdit()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $product = factory(Product::class)->create();
        $this->actingAs($user)
            ->get(route('dashboard.products.edit', ['product' => $product]))
            ->assertStatus(200)
            ->assertViewIs('products.edit')
            ->assertViewHas('id', $product->id)
            ->assertViewHas('name', $product->name)
            ->assertViewHas('type', $product->type)
            ->assertViewHas('pieces', $product->pieces)
            ->assertViewHas('description', $product->description)
            ->assertViewHas('price', $product->price)
            ->assertViewHas('disabled', $product->disabled)
            ->assertViewHas('productTypes', $this->productTypes);
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
        $user = factory(User::class)->create(['admin' => true]);
        $product = factory(Product::class)->create();
        $this->actingAs($user)
            ->post(route('dashboard.products.update', ['product' => $product]), $data)
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('success', "Le produit #{$product->id} ({$data['name']}) a été modifié avec succès !");
        $this->assertDatabaseHas('products', $data);
    }

    public function testUpdateWithSameName()
    {
        $user = factory(User::class)->create(['admin' => true]);
        $product = factory(Product::class)->create();
        $data = [
            'name' => $product->name,
            'type' => 'side',
            'pieces' => 1,
            'description' => 'It is delicious!',
            'price' => 7.5,
            'disabled' => false
        ];
        $this->actingAs($user)
            ->post(route('dashboard.products.update', ['product' => $product]), $data)
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertViewHas('success', "Le produit #{$product->id} ({$data['name']}) a été modifié avec succès !");
        $this->assertDatabaseHas('products', $data);
    }
}
