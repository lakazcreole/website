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

    /** @test */
    public function index_responds_with_products_associated_with_offers()
    {
        $product = factory(Product::class)->create();
        $offer = factory(Offer::class)->create([
            'start_at' => now()->subDay(),
            'end_at' => now()->addDay(),
            'product_id' => $product->id,
        ]);
        $this->json('GET', '/api/products/offers')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $offer->id,
                        'start_at' => $offer->start_at,
                        'end_at' => $offer->end_at,
                        'imageUrl' => $offer->imageUrl,
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
}
