<?php

namespace Tests\Feature\Api;

use App\PromoCode;
use App\Promotion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_validate_a_code_name()
    {
        $promotion = factory(Promotion::class)->create();
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'HELLO',
            'promotion_id' => $promotion->id,
            'uses' => 0,
            'max_uses' => 1,
            'begin_at' => now()->subDay(),
            'end_at' => now()->addDay(),
        ]);
        $this->json('GET', "/api/promocodes/validate/{$promoCode->name}")
            ->assertStatus(200)
            ->assertExactJson([
                'promotion_id' => $promotion->id,
                'is_valid' => $promoCode->isValid()
            ]);
    }

    /** @test */
    public function it_invalidates_unexisting_code_names()
    {
        $this->json('GET', "/api/promocodes/validate/FAKECODE")
            ->assertStatus(200)
            ->assertJson([
                'is_valid' => false
            ]);

    }
}
