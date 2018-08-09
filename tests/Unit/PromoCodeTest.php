<?php

namespace Tests\Unit;

use App\PromoCode;
use App\Promotion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_found_by_name()
    {
        $promo = factory(PromoCode::class)->create([
            'name' => 'TEST',
            'promotion_id' => factory(Promotion::class)->create()->id,
        ]);
        $this->assertEquals($promo->id, PromoCode::findByName('TEST')->id);
    }

    /** @test */
    public function it_has_a_promotion_relationship()
    {
        $promo = factory(PromoCode::class)->create([
            'name' => 'TEST',
            'promotion_id' => factory(Promotion::class)->create()->id,
        ]);
        $this->assertEquals($promo->promotion_id, $promo->promotion->id);
    }

    /** @test */
    public function it_has_an_is_valid_method()
    {
        $promotion = factory(Promotion::class)->create();
        $validCode = factory(PromoCode::class)->create([
            'promotion_id' => $promotion->id,
        ]);
        $invalidCode1 = factory(PromoCode::class)->create([
            'promotion_id' => $promotion->id,
            'begin_at' => now()->subDays(2),
            'end_at' => now()->subDay(),
        ]);
        $invalidCode2 = factory(PromoCode::class)->create([
            'promotion_id' => $promotion->id,
            'uses' => 1,
            'max_uses' => 1,
        ]);
        $this->assertTrue($validCode->isValid());
        $this->assertFalse($invalidCode1->isValid());
        $this->assertFalse($invalidCode2->isValid());
    }

    /** @test */
    public function it_has_an_is_valid_attribute_when_serialized()
    {
        $promotion = factory(Promotion::class)->create();
        $validCode = factory(PromoCode::class)->create([
            'promotion_id' => $promotion->id,
        ]);
        $invalidCode1 = factory(PromoCode::class)->create([
            'promotion_id' => $promotion->id,
            'begin_at' => now()->subDays(2),
            'end_at' => now()->subDay(),
        ]);
        $invalidCode2 = factory(PromoCode::class)->create([
            'promotion_id' => $promotion->id,
            'uses' => 1,
            'max_uses' => 1,
        ]);
        $this->assertEquals($validCode->isValid(), $validCode->toArray()['is_valid']);
        $this->assertEquals($invalidCode1->isValid(), $invalidCode1->toArray()['is_valid']);
        $this->assertEquals($invalidCode2->isValid(), $invalidCode2->toArray()['is_valid']);
    }
}
