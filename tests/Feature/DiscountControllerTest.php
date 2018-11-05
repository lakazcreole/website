<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use App\Discount;
use Tests\TestCase;
use App\DiscountItem;
use Illuminate\Support\Facades\DB;
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
                'discounts' => Discount::with('items.products')->get(),
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
            'description' => 'Boisson offerte',
            'items' => [
                [
                    'percent' => 100,
                    'required' => true,
                    'products' => [ $product1->id ]
                ],
                [
                    'percent' => 50,
                    'required' => false,
                    'products' => [ $product1->id, $product2->id ]
                ]
            ]
        ];
        $this->actingAs($this->admin)
            ->post(route('dashboard.discounts.store'), $data)
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$data['name']} a été créée.");
        // Discount
        $this->assertDatabaseHas('discounts', [
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        // Discount items
        $discount = Discount::latest()->first();
        $this->assertDatabaseHas('discount_items', [
            'discount_id' => $discount->id,
            'percent' => $data['items'][0]['percent'],
            'required' => $data['items'][0]['required']
        ]);
        $this->assertDatabaseHas('discount_items', [
            'discount_id' => $discount->id,
            'percent' => $data['items'][1]['percent'],
            'required' => $data['items'][1]['required']
        ]);
        // Discount item products
        $discountItem1 = DiscountItem::where([
                [ 'discount_id', $discount->id  ],
                [ 'percent', $data['items'][0]['percent'] ],
                [ 'required', $data['items'][0]['required'] ]
            ])->first();
        $discountItem2 = DiscountItem::where([
                [ 'discount_id', $discount->id  ],
                [ 'percent', $data['items'][1]['percent'] ],
                [ 'required', $data['items'][1]['required'] ]
            ])->first();
        $this->assertDatabaseHas('discount_item_product', [
            'discount_item_id' => $discountItem1->id,
            'product_id' => $data['items'][0]['products'][0]
        ]);
        $this->assertDatabaseHas('discount_item_product', [
            'discount_item_id' => $discountItem2->id,
            'product_id' => $data['items'][1]['products'][0]
        ]);
        $this->assertDatabaseHas('discount_item_product', [
            'discount_item_id' => $discountItem2->id,
            'product_id' => $data['items'][1]['products'][1]
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
                'discountItems' => $discount->items,
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
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();
        // Initial state
        $discount = factory(Discount::class)->create();
        $discountItems = factory(DiscountItem::class, 2)->create(['discount_id' => $discount->id]);
        $discountItems->each(function($item) use ($product1) {
            $item->products()->attach($product1->id);
        });
        // Updated state
        $data = [
            'name' => 'FREE COKE',
            'description' => 'Boisson offerte',
            'items' => [
                [
                    'percent' => 99,
                    'required' => false,
                    'products' => [ $product2->id ]
                ]
            ]
        ];
        $this->actingAs($this->admin)
            ->put(route('dashboard.discounts.update', ['discount' => $discount]), $data)
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$data['name']} a été modifiée.");
        // Discount
        $this->assertDatabaseHas('discounts', [
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        // Discount items
        $discount = Discount::latest()->first();
        $this->assertDatabaseHas('discount_items', [
            'discount_id' => $discount->id,
            'percent' => $data['items'][0]['percent'],
            'required' => $data['items'][0]['required']
        ]);
        $this->assertEquals(1, DiscountItem::where('discount_id', $discount->id)->count());
        // Discount item products
        $discountItem1 = DiscountItem::where('discount_id', $discount->id)->first();
        $this->assertDatabaseHas('discount_item_product', [
            'discount_item_id' => $discountItem1->id,
            'product_id' => $data['items'][0]['products'][0]
        ]);
        $this->assertEquals(1, DB::table('discount_item_product')->count());
    }

    /** @test */
    public function destroy()
    {
        $discount = factory(Discount::class)->create();
        $this->actingAs($this->admin)
            ->delete(route('dashboard.discounts.destroy', ['discount' => $discount]))
            ->assertRedirect(route('dashboard.discounts.index'))
            ->assertSessionHas('success', "La réduction {$discount->name} a été supprimée.");
        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);
    }
}
