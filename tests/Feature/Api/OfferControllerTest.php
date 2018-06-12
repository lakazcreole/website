<?php

namespace Tests\Feature\Api;

use App\Offer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_responds_with_available_offers()
    {
        $offer = factory(Offer::class)->create([
            'start_at' => now()->subDay(),
            'end_at' => now()->addDay()
        ]);
        $this->json('GET', '/api/offers')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $offer->id,
                        'start_at' => $offer->start_at,
                        'end_at' => $offer->end_at
                    ]
                ],
            ]);
    }
}
