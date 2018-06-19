<?php

namespace Tests\Feature\Api;

use App\Offer;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $product = factory(Product::class)->create();
        $offer = factory(Offer::class)->create([
            'begin_at' => now()->subDay(),
            'end_at' => now()->addDay(),
            'product_id' => $product->id,
            'enabled' => true,
        ]);
        $this->json('GET', '/api/products/offers')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $offer->id,
                        'begin_at' => $offer->begin_at,
                        'end_at' => $offer->end_at,
                        'imageUrl' => $offer->imageUrl,
                        'enabled' => true,
                        'product' => [
                            'id' => $product->id,
                            'name' => $product->name,
                            'type' => $product->type,
                            'pieces' => $product->pieces,
                            'description' => $product->description,
                            'price' => $product->price,
                        ]
                    ]
                ],
            ]);
    }

    /** @test */
    public function index_only_show_current_offers()
    {
        $product = factory(Product::class)->create();
        factory(Offer::class)->create([
            'begin_at' => now()->subDays(3),
            'end_at' => now()->subDays(1),
            'product_id' => $product->id,
            'enabled' => true,
        ]);
        factory(Offer::class)->create([
            'begin_at' => now()->subDay(),
            'end_at' => now()->addDay(),
            'product_id' => $product->id,
            'enabled' => false,
        ]);
        $this->json('GET', '/api/products/offers')
            ->assertExactJson([
                'data' => []
            ]);
    }
}
