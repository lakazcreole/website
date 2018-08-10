<?php

namespace Tests\Unit;

use App\Discount;
use App\PromoCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromoCodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_found_by_name()
    {
        $code = factory(PromoCode::class)->create([
            'name' => 'TEST',
            'discount_id' => factory(Discount::class)->create()->id,
        ]);
        $this->assertEquals($code->id, PromoCode::findByName('TEST')->id);
    }

    /** @test */
    public function it_has_a_discount_relationship()
    {
        $code = factory(PromoCode::class)->create([
            'name' => 'TEST',
            'discount_id' => factory(Discount::class)->create()->id,
        ]);
        $this->assertEquals($code->discount_id, $code->discount->id);
    }

    /** @test */
    public function it_has_an_is_valid_method()
    {
        $discount = factory(Discount::class)->create();
        $validCode = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
        ]);
        $invalidCode1 = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
            'begin_at' => now()->subDays(2),
            'end_at' => now()->subDay(),
        ]);
        $invalidCode2 = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
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
        $discount = factory(Discount::class)->create();
        $validCode = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
        ]);
        $invalidCode1 = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
            'begin_at' => now()->subDays(2),
            'end_at' => now()->subDay(),
        ]);
        $invalidCode2 = factory(PromoCode::class)->create([
            'discount_id' => $discount->id,
            'uses' => 1,
            'max_uses' => 1,
        ]);
        $this->assertEquals($validCode->isValid(), $validCode->toArray()['is_valid']);
        $this->assertEquals($invalidCode1->isValid(), $invalidCode1->toArray()['is_valid']);
        $this->assertEquals($invalidCode2->isValid(), $invalidCode2->toArray()['is_valid']);
    }
}
