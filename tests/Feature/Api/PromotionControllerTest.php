<?php

namespace Tests\Feature\Api;

use App\Promotion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_can_show_promotions()
    {
        $promotion = factory(Promotion::class)->create();
        $this->json('GET', "api/promotions/{$promotion->id}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $promotion->id,
                'final_percentage' => $promotion->final_percentage,
                'final_raw' => $promotion->final_raw
            ]);
    }

    /** @test */
    public function show_returns_404_if_promotion_does_not_exist()
    {
        $this->json('GET', 'api/promotions/0')
            ->assertStatus(404);
    }
}
