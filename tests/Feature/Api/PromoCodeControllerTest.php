<?php

namespace Tests\Feature\Api;

use App\Discount;
use App\PromoCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_validate_a_code_name()
    {
        $discount = factory(Discount::class)->create();
        $promoCode = factory(PromoCode::class)->create([
            'name' => 'HELLO',
            'discount_id' => $discount->id,
            'uses' => 0,
            'max_uses' => 1,
            'begin_at' => now()->subDay(),
            'end_at' => now()->addDay(),
        ]);
        $this->json('GET', "/api/promocodes/validate/{$promoCode->name}")
            ->assertStatus(200)
            ->assertExactJson([
                'discount_id' => $discount->id,
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
